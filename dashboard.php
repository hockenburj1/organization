<?php
include('config.php');
//$user = get_user();
$page = new Template();
$page->setContent('title', 'Dashboard');
$page->addContent('content', get_content('dashboard.content.php'));
$page->addModule('content', 'organization-search');
$page->display();
?>


