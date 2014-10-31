<?php
$organizations = '';

if (!empty($_GET)) {
    $query = '';
    
    $keyword = get('keyword');
    $tag = get('tag');
    
    // if no tag provided search against keywords only
    if(empty($tag)) {
        $query = "SELECT * FROM organization WHERE (name LIKE :keyword OR abbreviation LIKE :keyword OR description LIKE :keyword) AND membership_requestable = 'TRUE' ORDER BY name";
        $params = array('keyword' => "%$keyword%");
    }
    
    // if a tag was provided 
    else {
        $tag_query = "SELECT tid FROM tag WHERE name = :tag";
        $tag_params = array('tag' => "$tag");
        $tag_result = $db->query($tag_query, $tag_params);
        $tag_id;
        
        // if tag wasn't found in selection
        if(empty($tag_result)) {
            $query = "SELECT * FROM organization WHERE (name LIKE :keyword OR abbreviation LIKE :keyword OR description LIKE :keyword) AND membership_requestable = 'TRUE' ORDER BY name";
            $params = array('keyword' => "%$keyword%");
        }
        
        // tag was found
        else {
            $tag_id = $tag_result[0]['tid'];
            $query ="
                SELECT organization.*
                FROM organization
                JOIN tag_membership as tm ON organization.id = tm.oid
                WHERE tm.tid = :tag_id && (name LIKE :keyword OR abbreviation LIKE :keyword OR description LIKE :keyword) AND membership_requestable = 'TRUE'
                ORDER BY name";
            $params = array('tag_id' => $tag_id, 'keyword' => "%$keyword%");
        }
    }
    
    $organizations = $db->query_objects($query, $params, 'Organization');  
    $search_occured = TRUE;
}

include($module_location . 'views/search.content.php');
?>
