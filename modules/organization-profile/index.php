<?php

$abbreviation = get('org');
$action = get('action');
$user = session('user');

if(!empty($user)) {
    $user = new User($db, $user);
}

$organization = Organization::search_abbreviation($abbreviation);

if(empty($organization)) {
    if($action != 'add_organization') {
        header("location: search.php");
    }
}

// check permissions if organization permissions are required
if (!empty($organization)) {
    if ($action == 'request_info' || $action == 'add_organization') {
        do_action($action);
    }
    
    elseif(empty($user) || !$user->has_permission($organization->id, $action) ) {
        include($module_location . 'views/profile.content.php');
    }
    
    else {
        do_action($action);
    }
}

function do_action($action) {
    global $module_location;
    switch ($action) {
        case 'request_info':
            include($module_location . 'views/request-info.form.php');
            break;

        case 'add_organization':
            include($module_location . 'views/add.form.php');
            break;
    }
}
?>
