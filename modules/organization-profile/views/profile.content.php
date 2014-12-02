<div class="container-fluid">
    <div class="row" style="background-color:#dcdddf;">
    <?php include('views/menu-start.php'); ?>
            <ul>
                <?php if(isset($user) && $user->is_member($organization->id)) : ?>
                    <li>
                        <img src="templates/default/images/layout/thumb-events.png" alt="Search Events" height="40" width="40" class="icon hidden-xs">    
                        <a href="event.php?org=<?php echo $organization->id ?>">Events</a>
                    </li>
                    <?php if ( $user->has_permission($organization->id, 'edit_organization') ) : ?>
                    <li>
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=edit_organization">Edit Organization</a>
                    </li>
                    <?php endif; ?>
                    <?php if( $user->has_permission($organization->id, 'manage_requests') ) : ?>
                    <li>
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=manage_requests">Manage Requests</a>
                    </li>
                    <?php endif; ?><br/>
                    <?php if( $user->has_permission($organization->id, 'edit_role') ) : ?>       
                    <li>
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=view_roles">Manage Roles</a>
                    </li>
                    <?php endif; ?>    
                <?php else : ?>
                    <li>
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=request_membership" class="button">Request Membership</a></p>
                    </li>
                <?php endif; ?>
            </ul>
        <?php include('views/menu-end.php'); ?>
        <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">




<div class="primary">
    <div>
    <?php if(isset($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if(isset($success)) : ?>
        <!--<div class="error"></div>-->
    <?php endif; ?>
    </div>
    <h1><?php echo $organization->name ?></h1>
    <p><?php echo $organization->description ?></p>
</div>

<div class="form-extra">
    <?php if(isset($user) && $user->is_member($organization->id)) : ?>
        Cool! I am a member already!<br />
        <a href="event.php?org=<?php echo $organization->id ?>">Events</a><br />
        <?php if ( $user->has_permission($organization->id, 'edit_organization') ) : ?>
            <a href="organization.php?org=<?php echo $organization->id ?>&action=edit_organization">Edit Organization</a>
        <?php endif; ?><br/>
        <?php if( $user->has_permission($organization->id, 'manage_requests') ) : ?>
            <a href="organization.php?org=<?php echo $organization->id ?>&action=manage_requests">Manage Requests</a>
        <?php endif; ?><br/>
        <?php if( $user->has_permission($organization->id, 'edit_role') ) : ?>       
            <a href="organization.php?org=<?php echo $organization->id ?>&action=view_roles">Manage Roles</a>
        <?php endif; ?>    
    <?php else : ?>
        <h3>Request Membership</h3>
        <p>Interested in being a member of this organization?</p>
        <p><a href="organization.php?org=<?php echo $organization->id ?>&action=request_membership" class="button">Request Membership</a></p>
        <br />
    <?php endif; ?>
    <br/> 
</div>

    </div>
</div>









