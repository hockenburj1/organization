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
    
    function __construct(){
        global $db;
        $this->db = $db;
        
        if (!isset($this->id) || empty($this->id)) {
            $this->id = 0;
        }
        
        if($this->id != 0) {
            $this->parents = $this->get_parents();
            $this->tags = $this->get_tags();
        }
    }
    
    public static function get_organization($db, $organization_id) {
        $query = 
            'SELECT *
            FROM organization
            WHERE id = :oid
            LIMIT 1';
        
        $params = array('oid' => $organization_id);
        $organizations = $db->query_objects($query, $params, 'Organization');
        
        if(!empty($organizations)) {
            return $organizations[0];
        }
        else {
            return NULL;
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
    
    function get_members() {
        $members = array();
        $result = $this->db->query("SELECT uid FROM Membership where oid = $this->id");
        
        foreach ($result as $user_row) {
            $members[] = new User($user_row['oid']); 
        }
        
        return $members;
    }
    
    function get_parent($organization_id) {
        $result = $this->db->query("SELECT parent_oid FROM Organization WHERE id = $organization_id AND confirmed_parent = TRUE");
            
        if(empty($result)) {
            return "";
        }
        $parent_id = $result[0]['parent_oid'];
        $result = $this->db->query("SELECT id, name FROM Organization WHERE id = $parent_id");
        return $result;
    }
    
    function get_parents() {
        $parents = array();
        $id = $this->id;
        $parent = $this->get_parent($id);

        while ( !empty($parent) ) {
            $parent_id = $parent[0]['id'];
            $parent_name = $parent[0]['name'];

            $parents[$parent_id] = $parent_name;
            $parent = $this->get_parent($parent_id);
        }
     
        $parent_objects = array();
        foreach(array_keys($parents) as $parent_id) {
            $parent_objects[] = Organization::get_organization($this->db, $parent_id);
        }
        
        return $parent_objects;
    }
    
    function get_memberships() {
        $memberships = array(Organization::get_organization($this->db, $this->id));
        
        if(!empty($this->parents)) {
            $memberships = array_merge($memberships, $this->parents);
        }

        return $memberships;
    }
    
    function get_children() {
        $processed_children = array();
        $children = $this->db->query("SELECT id, name, parent_oid FROM Organization WHERE parent_oid = $this->id");
        
        while(!empty($children)) {
            $child_query = "";
            $parents = array();
            
            foreach ($children as $child) {
                $child_id = $child['id'];
                $child_name = $child['name'];
                $processed_children[$child_id] = $child_name;
                $parents[] = $child_id; 
            }
            
            $parents_string = join(',', $parents);
            $children = $this->db->query("SELECT id, name, parent_oid FROM Organization WHERE parent_oid IN ($parents_string)");
            
        }
        
        $child_objects = array();
        foreach (array_keys($processed_children) as $child_id) {
            $child_objects[] = Organization::get_organization($this->db, $child_id);
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
            return Organization::get_organization($db, $result['0']['id']);
        }
        else {
            return '';
        }
    }
    
    public static function exists($parent_oid) {
        global $db;
        $query = "SELECT * FROM organization WHERE abbreviation = :abbreviation LIMIT 1";
        $params = array('abbreviation' => $abbreviation);
        $result = $db->query($query, $params);
        
        if(!empty($result)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }


    public function save() {
        if($this->name == "" || $this->abbreviation == "" || $this->description == "") {
            return FALSE;
        }
        
        if (!is_numeric($this->parent) && $this->parent != '') {
            return FALSE;
        }

        if($this->parent === $this->id) {
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
            if($this->parent != '' && $this->parent != $this->id) {
                $this->send_parent_request();
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
        $query = "SELECT parent_oid FROM Organization WHERE id = $this->id";
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
    
    public function get_parent_requests() {
        $query = 'SELECT oid
            FROM relationship_request
            WHERE relationship_request.parent_oid  = :parent_oid;';
        $params = array('parent_oid' => $this->id);
        $results = $this->db->query($query, $params);
        
        $organizations = array();
        foreach($results as $result) {
            $organizations[] = Organization::get_organization($this->db, $result['oid']);
        }
        
        return $organizations;
    }
    
    public function get_member_requests() {
        $query = 'SELECT uid
            FROM membership_request
            WHERE oid = :oid;';
        $params = array('oid' => $this->id);
        $results = $this->db->query($query, $params);
        
        $uids = array();
        foreach ($results as $result) {
            $uids[] = $result['uid'];
        }
        
        $users = User::get_users($this->db, $uids);
        
        return $users;
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
        $query = 'INSERT INTO user_role (uid, rid, oid) VALUES(:uid, :rid, :oid)';
        $params = array(
                'oid' => $this->id,
                'uid' => $user_id,
                'rid' => '1',
        );
        $this->db->query($query, $params); 
        return true;
    }
    
    public function parent_request($child_id, $decision) {
        $query = "SELECT *
            FROM relationship_request
            WHERE parent_oid = :oid AND oid = :child_id";
        $params = array(
                'oid' => $this->id,
                'child_id' => $child_id
        );
        $result = $this->db->query($query, $params);
        
        if(empty($result)) {
            return false;
        }
        
        //delete request
        $query = "DELETE FROM relationship_request
            WHERE parent_oid = :oid AND oid = :child_id";
        $params = array(
                'oid' => $this->id,
                'child_id' => $child_id
        );
        $result = $this->db->query($query, $params);
        
        if($decision == 'approve') {
            $query = "UPDATE organization
                SET confirmed_parent = TRUE
                WHERE id = :child_id";
            $params = array(
                    'child_id' => $child_id
            );
            $result = $this->db->query($query, $params);
        }
        
        return true;
    }
    
    public function member_request($member_id, $decision) {
        $query = "SELECT *
            FROM membership_request
            WHERE oid = :oid AND uid = :uid";
        $params = array(
                'oid' => $this->id,
                'uid' => $member_id
        );
        $result = $this->db->query($query, $params);
        
        if(empty($result)) {
            return false;
        }
        
        //delete request
        $query = "DELETE FROM membership_request
            WHERE oid = :oid AND uid = :uid";
        $params = array(
                'oid' => $this->id,
                'uid' => $member_id
        );
        $result = $this->db->query($query, $params);
        
        if($decision == 'approve') {
            $query = 'INSERT INTO membership (oid, uid) VALUES(:oid, :uid)';
            $params = array(
                'oid' => $this->id,
                'uid' => $member_id,
            );
            $this->db->query($query, $params); 
        }
        
        return true;
    }
    
    public function get_events() {
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
                oid = :oid";
        $params = array('oid' => $this->id);
        $result = $this->db->query_objects($query, $params, 'Event');
        return $result;
    }
    
    public function has_role($rid) {
        $query = 
            "SELECT rid, oid
            FROM role_membership
            WHERE oid = $this->id AND rid = :rid";
        $params = array("rid" => $rid);
        $roles = $this->db->query($query, $params);
        
        if(!empty($roles)) {
            return TRUE;
        }
        else {
            return FALSE;
        }       
    }
    
    public function get_roles() {
        $query = 
            "SELECT role.id, role.title
            FROM role_membership
            JOIN role on role_membership.rid = role.id
            WHERE oid = $this->id";
        $roles = $this->db->query($query);
        return $roles;
    }
    
    public function get_permissions_list() {
        $query = 
            "SELECT id, name FROM permission";
        $permissions = $this->db->query($query);
        
        $perm_array = array();
        foreach($permissions as $permission) {
            $perm_array[] = array("id" => $permission['id'], "name" => $permission['name']);
        }
        
        return $perm_array;
    }
    
    public function get_role($rid) {
        $query = "SELECT id, title from role WHERE id = :rid";
        $params = array("rid" => $rid);
        $roles = $this->db->query($query, $params);
        
        if(!empty($roles)) {
            return array("id" => $roles[0]['id'], "title" => $roles[0]['title']);
        }
        else {
            '';
        }
    }
    
    public function get_role_permissions($rid) {
        if(!$this->has_role($rid)) {
            return array();
        }
        $query =
            "SELECT role_permission.pid, permission.name
            FROM role_permission
            JOIN permission on permission.id = role_permission.pid
            WHERE role_permission.rid = :rid";
        $params = array("rid" => $rid);
        $permissions = $this->db->query($query, $params);
        $perm_array = array();
        foreach($permissions as $permission) {
            $perm_array[] = $permission['pid'];
        }
        
        return $perm_array;
    }
    
    public function add_role($role_name, $permissions) {
        if($this->id == 0) {
            return false;
        }
        
        if(empty($role_name) || empty($permissions)) {
            return false;
        }
        
        $role_names = array();
        $roles = $this->get_roles();
        foreach($roles as $role) {
            $role_names[] = $role['title'];
        }
        
        if(in_array($role_name, $role_names)) {
            return FALSE;
        }
        
        $valid_permissions = $this->get_permissions_list();
        $valid_permissions_ids = array();
        foreach ($valid_permissions as $permission) {
            $valid_permissions_ids[] = $permission['id']; 
        }
        
        foreach($permissions as $permission) {
            if(!in_array($permission, $valid_permissions_ids)) {
                return false;
            }
        }
        
        $query = "INSERT INTO role (title) VALUES(:title)";
        $params = array("title" => $role_name);
        $this->db->query($query, $params);
        
        $role_id = $this->db->last_id();
        
        $query = "INSERT INTO role_membership (oid, rid) VALUES(:oid, :rid)";
        $params = array("oid" => $this->id, "rid" => $role_id);
        $this->db->query($query, $params);
        
        foreach($permissions as $permission) {
            $query = "INSERT INTO role_permission (rid, pid) VALUES(:rid, :pid)";
            $params = array("rid" => $role_id, "pid" => $permission);
            $this->db->query($query, $params);
        }
        
        return TRUE;
    }
    
    public function update_role($role_id, $role_name, $permissions) {
        if($this->id == 0) {
            return false;
        }
        
        if(!$this->has_role($role_id) || empty($role_id) || empty($permissions)) {
            return false;
        }
        
        // Prevent changing the administrator role
        if($role_id == 1) {
            return FALSE;
        }
        
        $valid_permissions = $this->get_permissions_list();
        $valid_permissions_ids = array();
        foreach ($valid_permissions as $permission) {
            $valid_permissions_ids[] = $permission['id']; 
        }
        
        foreach($permissions as $permission) {
            if(!in_array($permission, $valid_permissions_ids)) {
                return false;
            }
        }

        $query = "DELETE FROM role_permission WHERE rid = :rid";
        $params = array("rid" => $role_id);
        $this->db->query($query, $params);
        
        foreach($permissions as $permission) {
            $query = "INSERT INTO role_permission (rid, pid) VALUES(:rid, :pid)";
            $params = array("rid" => $role_id, "pid" => $permission);
            $this->db->query($query, $params);
        }
        
        
        $query = "UPDATE role set title = :title WHERE id = :rid";
        $params = array("rid" => $role_id, "title" => $role_name);
        $this->db->query($query, $params);
        
        return TRUE;
    }
    
    public function delete_role($role_id) {
        if($role_id == 0 || $this->id == 0) {
            return false;
        }
        
        if(!$this->has_role($role_id) || empty($role_id)) {
            return false;
        }
        
        // Prevent changing the administrator role
        if($role_id == 1) {
            return FALSE;
        }
        
        
        
        $query = "DELETE FROM role WHERE id = :rid";
        $params = array('rid' => $role_id);
        $this->db->query($query, $params);
    }
}

?>
