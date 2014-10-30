<?php 
include('config.php');
$query = "SELECT * FROM User";
$result = $db->query($query);
$numbers = array();
$json = json_encode($result);
echo $json;