<?php

Class Organization {
    private $db;
    public $id;
    public $name;
    public $description;
    public $parents;
    public $tags;
    public $abbreviation;
    
    function __construct($db, $organization_id){
        $this->db = $db;
        $result = $this->db->query("SELECT name, description, abbreviation FROM Organization WHERE oid = $organization_id");
        
        $this->id = $organization_id;
        $this->name = $result['0']['name'];
        $this->description = $result['0']['description'];
        $this->parents = $this->get_parents();
        $this->tags = $this->get_tags();
        $this->abbreviation = $result['0']['abbreviation'];
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
    
    public static function add($name, $abbreviation, $description, $parent_id, $membership_requestable) {
        
    }
}

?>
