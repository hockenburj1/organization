<?php
include('config.php');

$page = new Template();
$organizations = $user->get_organizations();

$page->setContent('content', get_content('views/organizations.content.php'));
$page->setContent('title', 'Organizations');
$page->display();

?>