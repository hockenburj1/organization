<?php
include 'config.php';
$template = new Template();
$template->setContent('title', 'Organization Profile');
$template->addModule('content', 'organization-profile');
$template->display();
?>
