<?php

Class User {
    public $id;
    public $email; 
    public $name;
    public $first_name;
    public $last_name;
    public $is_admin = TRUE;
    public $roles;
    public $password;
    public $db;

    public function __construct($db, $user_id = 0) {
        $this->db = $db;
        
        if($user_id != 0) {
            $this->id = $user_id;
            $this->db = $db;
            $this->set_permissions();
            $this->set_user_info();
        }
    }
    
    private function set_permissions() {
        $query = "SELECT role.title, role_membership.oid, Group_Concat(permission.value SEPARATOR ',') as permissions
from user_role
JOIN role on role.rid = user_role.rid
JOIN role_membership on role_membership.rid = role.rid
JOIN role_permission on role_permission.rid = role.rid
JOIN permission on permission.pid = role_permission.pid
WHERE user_role.uid = :uid
GROUP BY oid";
        $params = array('uid' => $this->id);
        $results = $this->db->query($query, $params);
        
        foreach($results as $row) {
            $this->roles[$row['oid']] = explode(',', $row['permissions']);
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
        $query = 'SELECT * FROM User WHERE uid = :uid LIMIT 1';
        $params = array('uid' => $this->id);
        $info = $this->db->query($query, $params);
        $this->first_name = $info[0]['first_name'];
        $this->last_name = $info[0]['last_name'];
        $this->name = $info[0]['first_name'] . ' ' . $info[0]['last_name'];
        $this->email = $info[0]['email'];
        $this->password = $info[0]['password'];
    }
    
    public function get_organizations() {
        $query = 'SELECT membership.oid, organization.name 
FROM membership
JOIN organization ON organization.oid = membership.oid  
WHERE membership.uid = :uid';
        $params = array('uid' => $this->id);
        $result = $this->db->query($query, $params);
        
        $organizations = array();
        foreach ($result as $organization) {
            $organizations[] = new Organization($this->db, $organization['oid']); 
        }
        
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
            $query = 'UPDATE User SET password = :password, first_name = :first_name, last_name = :last_name WHERE uid = :uid';

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
    
}

    
?>
