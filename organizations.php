<?php
include('config.php');

$page = new Template();

$user = get_user();
$organizations = $user->get_organizations();
print_r($organizations);

$page->setContent('content', get_content('views/organizations.content.php'));
$page->setContent('title', 'Organizations');
$page->display();

?>