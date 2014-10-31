<?php

Class User {
    public $id;
    public $email; 
    public $name;
    public $first_name;
    public $last_name;
    public $roles;
    public $password;
    public $db;

    public function __construct() {
        global $db;
        $this->db = $db;
        
        if (!isset($this->id) || empty($this->id)) {
            $this->id = 0;
        }
        
        if($this->id != 0) {
            $this->set_permissions();
            $this->set_user_info();
        }
    }
    
    public static function get_user($db, $user_id) {
        $query = 
            "SELECT id,
                email,
                password,
                first_name,
                last_name,
                CONCAT_WS(' ', first_name, last_name) as name
            FROM User
            WHERE id = :uid
            LIMIT 1;";
        $params = array('uid' => $user_id);
        $users = $db->query_objects($query, $params, 'User');
        
        return $users[0];
    }

    public static function get_users($db, $user_ids) {
        $uids = implode(',', $user_ids);
        $query = 
            "SELECT id,
                email,
                password,
                first_name,
                last_name,
                CONCAT_WS(' ', first_name, last_name) as name
            FROM User
            WHERE id IN ($uids)";
        $params = array('uid' => $uids);
        $users = $db->query_objects($query, $params, 'User');
        
        if (empty($users)) {
            return null;
        }
        
        return $users; 
    }

    private function set_permissions() {
        $query = 
            "SELECT user_role.oid, permission.value
            FROM user_role
            JOIN role on role.id = user_role.rid
            JOIN role_permission on role_permission.rid = role.id
            JOIN permission on permission.id = role_permission.pid
            WHERE user_role.uid = :uid";
        $params = array('uid' => $this->id);
        $results = $this->db->query($query, $params);
        
        foreach($results as $row) {
            $this->roles[$row['oid']][] = $row['value'];
        }

    }

    public function has_permission($organization_id, $action) {
        if(!empty($this->roles) && array_key_exists($organization_id, $this->roles)) {
            if(in_array($action, $this->roles[$organization_id]) ) {
                return true;
            }
        }
        
        return false;
    }
    
    public function recall() {
        $this->is_admin = TRUE;
    }
    
    private function set_user_info() {
        $query = 'SELECT * FROM User WHERE id = :uid LIMIT 1';
        $params = array('uid' => $this->id);
        $info = $this->db->query($query, $params);
        $this->first_name = $info[0]['first_name'];
        $this->last_name = $info[0]['last_name'];
        $this->name = $info[0]['first_name'] . ' ' . $info[0]['last_name'];
        $this->email = $info[0]['email'];
        $this->password = $info[0]['password'];
    }
    
    public function get_organizations() {
        $query = 
            'SELECT organization.*
            FROM membership
            JOIN organization ON organization.id = membership.oid  
            WHERE membership.uid = :uid';
        $params = array('uid' => $this->id);
        $organizations = $this->db->query_objects($query, $params, 'Organization');
        
        return $organizations;
    }
    
    public function save() {
        if($this->email == "" || $this->password == "" || $this->first_name == "" || $this->last_name == "") {
            return FALSE;
        }
        
        // If email doesn't exist
        if($this->check_username()) {
            $query = 'INSERT INTO User (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)';

            $params = array(
                'email' => $this->email,
                'password' => $this->password,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name
            );

            $this->db->query($query, $params);
            $this->id = $this->db->last_id();
        }
        
        // update user
        else {
            $query = 'UPDATE User SET password = :password, first_name = :first_name, last_name = :last_name WHERE id = :uid';

            $params = array(
                'uid' => $this->id,
                'password' => $this->password,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name
            );

            $this->db->query($query, $params);    
        }
        return TRUE;    
    }
    
    public function check_username() {
        $query = 'SELECT * FROM User WHERE email = :email LIMIT 1';
        $params = array('email' => $this->email);
        $existing = $this->db->query($query, $params);
        
        if(!empty($existing)) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    
    public static function exists($user_id) {
        global $db;
        $query = 'SELECT * FROM User WHERE id = :uid LIMIT 1';
        $params = array('uid' => $user_id);
        $existing = $db->query($query, $params);
        
        if(empty($existing)) {
            return FALSE;
        }
        
        return TRUE;    
    }
    
    public function send_membership_request($oid) {     
        //Check if request already exists
        $query = "SELECT oid FROM membership_request WHERE oid = :oid && uid = :uid";
        $params = array(
            'uid' => $this->id,
            'oid' => $oid
        );
        $result = $this->db->query($query, $params);
        
        if(!empty($result) || $this->is_member($oid)) {
            return FALSE;
        }
        
        $query = "INSERT INTO membership_request (oid, uid) VALUES(:oid, :uid)";
        $params = array(
            'uid' => $this->id,
            'oid' => $oid
        );
        $this->db->query($query, $params);
    }
    
    public function is_member($oid) {
        $query = "SELECT oid FROM membership WHERE oid = :oid && uid = :uid";
        $params = array(
            'uid' => $this->id,
            'oid' => $oid
        );
        $result = $this->db->query($query, $params);
        
        if(empty($result)) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function get_events() {
        $organizations = $this->get_organizations();

        $oids = array();
        foreach ($organizations as $organization) {
            if(is_numeric($organization->id)) {
                $oids[] = $organization->id;
            }   
        }

        $oids_string = implode(',', $oids);
        
        $date = new DateTime();
        $currrent_time = $date->format('Y-m-d h:i:s');
        $query = 
            "SELECT id,
                name,
                description,
                start,
                finish
            FROM Event
            WHERE 
                finish > '$currrent_time' AND
                oid in ($oids_string)";
        
        $params = array();
        $events = $this->db->query_objects($query, $params, 'Event');
        return $events;
    }
}

    
?>
