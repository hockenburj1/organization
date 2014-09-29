<div class="primary">
    <h1><?php echo $organization->name ?></h1>
    <p><?php echo $organization->description ?></p>
</div>

<div class="form-extra">
    <h3>Request Membership</h3>
    <p>Interested in being a member of this organization?</p>
    <p><a href="organization-profile.php?org=<?php echo $organization->abbreviation ?>&action=request" class="button">Request Membership</a></p>
    
    <br />
    
    <?php if(!empty($user) && $user->has_permission($organization->id, 'edit_organization')) : ?>
        <a href="organization.php?org=<?php echo $organization->id ?>&action=edit_organization">Edit Organization</a>
    <?php endif; ?><br/>
    <?php if(!empty($user) && $user->has_permission($organization->id, 'manage_requests')) : ?>
        <a href="organization.php?org=<?php echo $organization->id ?>&action=manage_requests">Manage Requests</a>
    <?php endif; ?>
</div>









