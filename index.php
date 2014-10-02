<?php
require('config.php');

if(!empty(session('user'))) {
    header("location: dashboard.php");
}

$page = new Template();
$page->setContent('title', 'Home | JS');
$page->addModule('content', 'organization-search');
$page->addContent('content', get_content('index.content.php'));
$page->display();

?>
