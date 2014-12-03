<div class="container-fluid">
    <div class="row" style="background-color:#dcdddf;">
    <?php include('views/menu-start.php'); ?>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <img src="templates/default/images/layout/thumb-home.png" alt="Dashboard" height="40" width="40" class="icon hidden-xs">
                        Dashboard
                    </a>
                </li>
                <?php if(isset($user) && $user->is_member($organization->id)) : ?>
                    <li>
                        <img src="templates/default/images/layout/thumb-events.png" alt="Search Events" height="40" width="40" class="icon hidden-xs">    
                        <a href="event.php?org=<?php echo $organization->id ?>">Events</a>
                    </li>
                    <?php if ( $user->has_permission($organization->id, 'edit_organization') ) : ?>
                    <li>
                        <a href="organizations.php">
                            <img src="templates/default/images/layout/thumb-organizations.png" alt="Search Organization" height="40" width="40" class="icon hidden-xs">
                            Organizations
                        </a>
                    </li>
                    <li>
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=edit_organization">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Edit Organization</a>
                    </li>
                    <?php endif; ?>
                    <?php if( $user->has_permission($organization->id, 'manage_requests') ) : ?>
                    <li>
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=manage_requests">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Manage Requests</a>
                    </li>
                    <?php endif; ?>
                    <?php if( $user->has_permission($organization->id, 'edit_role') ) : ?>       
                    <li class="active">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=view_roles">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Manage Roles</a>
                    </li>
                    <?php endif; ?>    
                <?php else : ?>
                    <li>
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=request_membership" class="button">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Request Membership</a></p>
                    </li>
                <?php endif; ?>
            </ul>
        <?php include('views/menu-end.php'); ?>
        <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">

<h2>Roles</h2>
<hr>
<?php foreach($roles as $role) : ?>
    <span><a href="organization.php?org=<?php echo $organization->id ?>&action=edit_role&rid=<?php echo $role['id'] ?>"><?php echo $role['title'] ?></span>
    <span><a href="organization.php?org=<?php echo $organization->id ?>&action=delete_role&rid=<?php echo $role['id'] ?>">Delete</a></span>
    <br/>
<?php endforeach; ?>
<span><a href="organization.php?org=<?php echo $organization->id ?>&action=add_role">Add Role</a></span>
        </div><!--/content wrap-->
    </div><!--/row-->   
</div><!--/container-->

