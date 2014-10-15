<?php
include('config.php');
$page = new Template();
$page->setContent('title', 'Events');
$page->addModule('content', 'events');
$page->display();

?>