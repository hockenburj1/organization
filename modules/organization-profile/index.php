<?php
$abbreviation = get('org');
$action = get('action');
$user = session('user');

if(!empty($user)) {
    $user = new User($db, $user);
}

$organization = Organization::search_abbreviation($abbreviation);

if(empty($organization)) {
    if($action == 'add_organization' && !empty($user)) {
        if(!empty($_POST)) {
            $new_organization = new Organization($db);
            $new_organization->name = post('name');
            $new_organization->abbreviation = post('abbreviation');
            $new_organization->description = post('description');
            $new_organization->parent = post('parent_id');
            $new_organization->requestable = post('request');
            
            if($new_organization->save()) {
                header('location: organizations.php');
            }
            
            else {
                $error = 'An error occured while adding the organization.';
            }
        }
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
            case 'edit_organization':
                if(!empty($_POST)) {
                    $new_organization = new Organization($db, $organization->id);
                    $new_organization->name = post('name');
                    $new_organization->abbreviation = post('abbreviation');
                    $new_organization->description = post('description');
                    $new_organization->parent = post('parent_id');
                    $new_organization->requestable = post('request');

                    if($new_organization->save()) {
                        header('location: organizations.php');
                    }

                    else {
                        $error = 'An error occured while updating the organization.';
                    }
                }
                include($module_location . 'views/add.form.php');
                break;
            
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
