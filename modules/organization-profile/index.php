<?php
$abbreviation = get('org');
$action = get('action');
$user = session('user');

if(!empty($user)) {
    $user = new User($db, $user);
}

$organization = Organization::search_abbreviation($abbreviation);

if(empty($organization)) {
    if($action == 'add_organization') {
        include($module_location . 'views/add.form.php'); 
    }
    else {
        header("location: search.php");    
    }
}


// check permissions if organization permissions are required
if (!empty($organization)) {    
    if(empty($user) || !$user->has_permission($organization->id, $action) ) {
        include($module_location . 'views/profile.content.php');
    }
    
    else {
        switch ($action) {
            case 'request_info':
                include($module_location . 'views/request-info.form.php');
                break;

            case 'delete_organization':
                include($module_location . 'views/delete.form.php');
                break;
        }
    }
}

?>
