<?php
require '../../config.php';

$tag_list = array();
$term = $_GET['term'];
//$tags = $db->query("SELECT DISTINCT tag.name FROM tag_membership as tm JOIN tag ON tm.tid = tag.tid WHERE name LIKE '$term%'");
$tag_query = "SELECT DISTINCT tag.name FROM tag_membership as tm JOIN tag ON tm.tid = tag.tid WHERE name LIKE :term && tm.oid IN(SELECT id from organization WHERE membership_requestable = 'TRUE')";
$tag_params = array('term' => "$term%");

$tags = $db->query($tag_query, $tag_params);

foreach ($tags as $tag_info) {
    $tag_list[] = $tag_info['name'];
}

echo json_encode($tag_list);
?>
