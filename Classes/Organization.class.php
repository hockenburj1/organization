<?php

Class Organization {
    private $db;
    public $id;
    public $name;
    public $description;
    public $parents;
    public $parent;
    public $tags;
    public $abbreviation;
    public $requestable;
    
    function __construct($db, $organization_id = 0){
        $this->db = $db;
        $this->id = $organization_id;
        
        if($organization_id != 0) {
            $result = $this->db->query("SELECT * FROM Organization WHERE oid = $organization_id");

            $this->id = $organization_id;
            $this->name = $result['0']['name'];
            $this->description = $result['0']['description'];
            $this->parents = $this->get_parents();
            $this->parent = $result['0']['parent_oid'];
            $this->tags = $this->get_tags();
            $this->abbreviation = $result['0']['abbreviation'];
            $this->requestable = $result['0']['membership_requestable'];
        }
    }
    
    function get_name() {
        return $this->name;
    }
    
    function get_id() {
        return $this->id;
    }
    
    function get_documents() {
        $result = $this->db->query("SELECT title, url FROM Document WHERE oid = $this->id AND administrator = '0' ");
        
        return $result;
    }
    
    function get_admin_documents() {
        $result = $this->db->query("SELECT title, url FROM Document WHERE oid = $this->id AND administrator = '1' ");
        
        return $result;
    }
    
    function get_events() {}
    function get_members() {
        $members = array();
        $result = $this->db->query("SELECT uid FROM Membership where oid = $this->id");
        
        foreach ($result as $user_row) {
            $members[] = new User($user_row['oid']); 
        }
        
        return $members;
    }
    
    function get_parent($organization_id) {
        $result = $this->db->query("SELECT parent_oid FROM Organization WHERE oid = $organization_id");
        $parent_id = $result[0]['parent_oid'];
        
        if(empty($parent_id)) {
            return "";
        }
        
        $result = $this->db->query("SELECT oid, name FROM Organization WHERE oid = $parent_id");
        return $result;
    }
    
    function get_parents() {
        $parents = array();
        $id = $this->id;
        $parent = $this->get_parent($id);

        while ( !empty($parent) ) {
            $parent_id = $parent[0]['oid'];
            $parent_name = $parent[0]['name'];

            $parents[$parent_id] = $parent_name;
            $parent = $this->get_parent($parent_id);
        }
     
        $parent_objects = array();
        foreach(array_keys($parents) as $parent_id) {
            $parent_objects[] = new Organization($this->db, $parent_id);
        }
        
        return $parent_objects;
    }
    
    function get_memberships() {
        $memberships = array(new Organization($this->db, $this->id));
        
        if(!empty($this->parents)) {
            $memberships = array_merge($memberships, $this->parents);
        }

        return $memberships;
    }
    
    function get_children() {
        $processed_children = array();
        $children = $this->db->query("SELECT oid, name, parent_oid FROM Organization WHERE parent_oid = $this->id");
        
        while(!empty($children)) {
            $child_query = "";
            $parents = array();
            
            foreach ($children as $child) {
                $child_id = $child['oid'];
                $child_name = $child['name'];
                $processed_children[$child_id] = $child_name;
                $parents[] = $child_id; 
            }
            
            $parents_string = join(',', $parents);
            $children = $this->db->query("SELECT oid, name, parent_oid FROM Organization WHERE parent_oid IN ($parents_string)");
            
        }
        
        $child_objects = array();
        foreach (array_keys($processed_children) as $child_id) {
            $child_objects[] = new Organization($this->db, $child_id);
        }
        return $child_objects;
    }
    
    public function get_tags() {
        $result = $this->db->query("SELECT tag.name FROM tag_membership as tm JOIN tag on tm.tid = tag.tid WHERE tm.oid = $this->id ");
        $tags = array();
        foreach($result as $tag) {
            $tags[] = $tag['name'];
        }
        
        return $tags;
    }
    
    public static function search_abbreviation($abbreviation) {
        global $db;
        $query = "SELECT * FROM organization WHERE abbreviation = :abbreviation LIMIT 1";
        $params = array('abbreviation' => $abbreviation);
        $result = $db->query($query, $params);
        
        if(!empty($result)) {
            return new Organization($db, $result['0']['oid']);
        }
        else {
            return '';
        }
    }
    
    public function save() {
        if($this->name == "" || $this->abbreviation == "" || $this->description == "" || $this->parent == $this->id) {
            return FALSE;
        }
        
        $params = array(
            'name' => $this->name,
            'abbreviation' => $this->abbreviation,
            'description' => $this->description,
            'parent_oid' => $this->parent,
            'membership_requestable' => $this->requestable,
        );
        
        // If no id assigned
        if($this->id == 0) {
            $query = 'INSERT INTO Organization (name, abbreviation, description, parent_oid, membership_requestable) VALUES (:name, :abbreviation, :description, :parent_oid, :membership_requestable)';
            $this->db->query($query, $params);
            $this->id = $this->db->last_id();
            if(!$this->add_user(session('user'))) {
                return false;
            }
        }
        
        // update organization
        else {
            $updated = $this->update_parent_record();
            $oid = $this->id;
            $query = "UPDATE Organization SET name = :name, abbreviation = :abbreviation, description = :description, parent_oid = :parent_oid, membership_requestable = :membership_requestable WHERE oid = $oid";
            $this->db->query($query, $params);   
            
            if($updated) {
                $this->send_parent_request();
            }
        }
        return TRUE;    
    }
    
    private function send_parent_request() {
        $query = "INSERT INTO relationship_request (oid, parent_oid) VALUES(:oid, :parent_oid)";
        $params = array(
            'oid' => $this->id,
            'parent_oid' => $this->parent
        );
        $this->db->query($query, $params);
    }
    
    private function update_parent_record() {
        // Query current data
        $query = "SELECT parent_oid FROM Organization WHERE oid = $this->id";
        $result = $this->db->query($query);
        
        // If no parent or equals new parent return FALSE
        if(empty($result) || $result[0]['parent_oid'] == $this->parent) {
            return false;
        }
        // ELSE return TRUE delete requests and reset organization approved
        else {
            $query = "DELETE FROM relationship_request WHERE oid = :oid AND parent_oid = :parent_oid";
            $params = array(
                'oid' => $this->id,
                'parent_oid' => $result[0]['parent_oid']
            );
            $this->db->query($query, $params);
            
            $query = "UPDATE Organization SET confirmed_parent = 'FALSE' WHERE oid = :oid";
            $params = array(
                'oid' => $this->id
            );
            $this->db->query($query, $params);
        }
        return TRUE;
    }
    
    public function check_abbreviation() {
        $query = 'SELECT abbreviation FROM Organization WHERE abbreviation = :abbreviation LIMIT 1';
        $params = array('abbreviation' => $this->abbreviation);
        $existing = $this->db->query($query, $params);
        
        if(!empty($existing)) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function add_user($user_id) {
        if(!User::exists($user_id)) {
            return false;
        }
        
        // Add user to organization
        $query = 'INSERT INTO membership (oid, uid) VALUES(:oid, :uid)';
        $params = array(
                'oid' => $this->id,
                'uid' => $user_id,
        );
        $this->db->query($query, $params); 
        
        // Assign admin role to organization
        $query = 'INSERT INTO role_membership (oid, rid) VALUES(:oid, :rid)';
        $params = array(
                'oid' => $this->id,
                'rid' => '1',
        );
        $this->db->query($query, $params);
        
        // Assign admin role to user 
        $query = 'INSERT INTO user_role (uid, rid) VALUES(:uid, :rid)';
        $params = array(
                'uid' => $user_id,
                'rid' => '1',
        );
        $this->db->query($query, $params); 
        return true;
    }
}

?>
