<?php
$org_id = empty(get('org')) ? '0' : get('org');
$action = get('action');
$user = session('user');

if(!empty($user)) {
    $user = new User($db, $user);
}

//$organization = Organization::search_abbreviation($abbreviation);
$organization = new Organization($db, $org_id);

// If creating an organization
if($organization->id == 0) {
    if($action == 'add_organization' && !empty($user)) {
        if(!empty(post('name'))) {
            $organization->name = post('name');
            $organization->abbreviation = post('abbreviation');
            $organization->description = post('description');
            $organization->parent = post('parent_id');
            $organization->requestable = empty(post('request')) ? 'FALSE' : 'TRUE';
            
            if($organization->save()) {
                header("location: organizations.php");
            }
            
            else {
                $error = 'An error occured while adding the organization.';
            }
        }
        include($module_location . 'views/add.form.php'); 
    }
    else {
        //header("location: search.php");    
    }
}


// check permissions if organization permissions are required
if ($organization->id != 0) {    
    if(empty($user) || !$user->has_permission($organization->id, $action) ) {
        include($module_location . 'views/profile.content.php');
    }
    
    else {
        switch ($action) {
            case 'edit_organization':
                if(!empty($_POST)) {
                    $organization->name = post('name');
                    $organization->abbreviation = post('abbreviation');
                    $organization->description = post('description');
                    $organization->parent = post('parent_id');
                    $organization->requestable = post('request');

                    if($organization->save()) {
                        header('location: organizations.php');
                    }

                    else {
                        $error = 'An error occured while updating the organization.';
                    }
                }
                include($module_location . 'views/edit.form.php');
                break;
            
            case 'request_info':
                include($module_location . 'views/request-info.form.php');
                break;

            case 'delete_organization':
                include($module_location . 'views/delete.form.php');
                break;
            case 'manage_requests':
                $type = get('type');
                $decision = get('decision');
                $member_id = get('member_id');
                if($type == 'member' && !empty($decision) && !empty($member_id)) {
                    $organization->member_request($member_id, $decision); 
                }
                if($type == 'parent' && !empty($decision)&& !empty($member_id)) {
                    $organization->parent_request($member_id, $decision);    
                } 
                
                $parent_requesters = $organization->get_parent_requests();
                $member_requesters = $organization->get_member_requests();
                include($module_location . 'views/requests.content.php');
                break;
        }
    }
}

?>
