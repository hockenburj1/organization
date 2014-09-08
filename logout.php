<?php
include 'config.php';

$_SESSION['user']->logout();
header("location: index.php");
?>
