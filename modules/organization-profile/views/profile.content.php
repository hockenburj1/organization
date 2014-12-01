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









