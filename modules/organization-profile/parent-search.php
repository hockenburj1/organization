<?php
require '../../config.php';

$parent_list = array();
$term = get('term');

$parent_query = "SELECT oid, name FROM organization WHERE name LIKE :term";
$parent_params = array('term' => "$term%");

$parents = $db->query($parent_query, $parent_params);

foreach ($parents as $parent) {
    //$parent_list[] = array('id' => $parent['oid'], 'value' => $parent['name']);
    $parent_list[] = $parent['name'];
}

echo json_encode($parent_list);
?>
