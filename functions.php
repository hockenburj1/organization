<?php

function get_content($file, $data = array()) {
    extract($GLOBALS);
    ob_start();
    extract($data);
    include($file);
    $content = ob_get_clean();
    return $content;
}

function password($password) {
    return sha1($password);
}

function get($key) {
    return isset($_GET[$key]) ? $_GET[$key] : '';
}

function post($key) {
    return isset($_POST[$key]) ? $_POST[$key] : '';
}

function session($key) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : '';
}

function get_user() {
    global $db;
    $user = new User($db, $_SESSION['user']);
    return $user;
}

function validate_required_post() {
    $keys = array_keys($_POST);

    foreach ($keys as $key) {
        if(substr_count($key, 'required') > 0) { 
            if(empty(post($key))) {
                return FALSE;
            }
        }
    }

    return TRUE;
}

function trace() {
    $included_files = get_included_files();
    $content = htmlspecialchars(file_get_contents('index.php'));
    
    $patterns = array();
    $patterns[] = '/include\s?\(\'[A-Za-z0-9_.]+\'\)\;/';
    $patterns[] = '/require\s?\(\'[A-Za-z0-9_.]+\'\)\;/';
    $patterns[] = '/include_once\s?\(\'[A-Za-z0-9_.]+\'\)\;/';
    $patterns[] = '/require_once\s?\(\'[A-Za-z0-9_.]+\'\)\;/';
    
    $new_content = "";
    
    while($content != $new_content) {
        $new_content = preg_replace($patterns, "jesse", $content);
    }
    
    echo $content;
}
?>
