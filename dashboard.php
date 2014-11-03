<?php
include('config.php');
//$user = get_user();
$page = new Template();
$page->setContent('title', 'Dashboard');
$page->addContent('content', get_content('views/dashboard.content.php'));
$page->addModule('content', 'organization-search');
$page->display();
?>


