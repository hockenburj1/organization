<?php
include('config.php');

$page = new Template();

$organization = new Organization($db, "1");
$organizations = $organization->get_memberships();

$user = get_user();

$page->setContent('title', 'Dashboard');
$page->addContent('content', get_content('dashboard.content.php'));
$page->addModule('content', 'organization-search');
$page->display();

?>


