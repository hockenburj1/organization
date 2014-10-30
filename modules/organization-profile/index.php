<?php
$org_id = empty(get('org')) ? '0' : get('org');
$action = get('action');

//$organization = Organization::search_abbreviation($abbreviation);
$organization = Organization::get_organization($db, $org_id);

// If creating an organization
if($organization->id == 0) {
    if($action == 'add_organization' && isset($user)) {
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
        header("location: search.php");    
    }
}


// check permissions if organization permissions are required
if ($organization->id != 0) {
    if(!empty($user) && $action == 'request_membership') {
        if(!$user->is_member($organization->id)) {
            $user->send_membership_request($organization->id);    
        }     
    }
    
    elseif(empty($user) || !$user->has_permission($organization->id, $action) ) {
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
            case 'edit_role':
                $rid = get('rid');
                
                if(!empty(post('selected_permissions'))) {
                    $role_name = post('role_name');
                    $role_permissions = post('selected_permissions');

                    if($organization->update_role($rid, $role_name, $role_permissions)) {
                        header("location: organization.php?org=" . $organization->id);
                    }
                    else {
                        $error = "Could not update the role.";
                    }
                }
                
                if(!empty($rid)) {
                    $all_permissions = $organization->get_permissions_list();
                    $role = $organization->get_role($rid);
                    $role_permissions = $organization->get_role_permissions($rid);
                    include($module_location . 'views/role.content.php');
                }
                break;
            case 'add_role':
                if(!empty(post('selected_permissions')) && !empty(post('role_name'))) {
                    $role_name = post('role_name');
                    $role_permissions = post('selected_permissions');

                    if($organization->add_role($role_name, $role_permissions)) {
                        header("location: organization.php?org=" . $organization->id);
                    }
                    else {
                        $error = "Could not add the role.";
                    }
                }
                
                $all_permissions = $organization->get_permissions_list();
                $role_permissions = array();
                include($module_location . 'views/role.content.php');
                break;
            case 'view_roles':
                $roles = $organization->get_roles();
                include($module_location . 'views/roles.content.php');
                break;
            case 'delete_role':
                $rid = get('rid');
                $confirm = get('confirm');
                
                if(!empty($confirm)) {
                    if($confirm == 'TRUE') {
                        $organization->delete_role($rid);
                    }
                    
                    header('location: organization.php?org=' . $organization->id . '&action=view_roles');
                }
                
                if(!empty($rid) && $organization->has_role($rid)) {
                    $role = $organization->get_role($rid);
                    include($module_location . 'views/role.delete.php');
                }
                break;
        }
    }
}

?>
