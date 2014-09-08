<?php
include('config.php');
$page = new Template();
$page->setContent('title', 'Organization Search');
$page->addModule('content', 'organization-search');
$page->display();

?>
