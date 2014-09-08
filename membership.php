<?php
include('config.php');
$page = new Template();
$page->setContent('title', 'Membership');
$page->addModule('content', 'membership');
$page->display();

?>
