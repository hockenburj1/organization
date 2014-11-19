<?php
error_reporting(E_ALL);
define('SITE_FOLDER', 'Organization/');
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . "/" . SITE_FOLDER;
define('SITE_URL', 'http://localhost/' . SITE_FOLDER);


define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('TEMPLATE_FOLDER', 'default/');

define('TEMPLATE_URL', SITE_URL . 'templates/' . TEMPLATE_FOLDER);

define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME', 'org_manager');

function my_autoloader($class) {
    include(ROOT . 'Classes/' . $class . '.class.php');
}

spl_autoload_register('my_autoloader');

$db = new MySQLiDB(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME) or die("jesse was here");

session_start();
$filename = strtok(basename($_SERVER["REQUEST_URI"]),'?');

$public_pages= array('index.php', 'search.php', 'search-processor.php', 'organization.php', 'request-info.php', 'membership.php');
if(!isset($_SESSION['user']) && !in_array($filename, $public_pages)) {
    header("location: index.php");
}

include('functions.php');

if( !empty(session('user')) ) {
    $user = User::get_user($db, session('user'));
}

$date_updated = new DateTime();
$db_last_updated = $date_updated->format('Y-m-d h:i:s');
?>
