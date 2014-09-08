<?php
include '../../config.php';

$query = 'SELECT * FROM User WHERE email = :email';
$params = array('email' => post('email'));
$results = $db->query($query, $params);

if(empty($results)) {
    echo 'This username is available';
}
else {
    echo 'This username is not available :(';
}

?>
