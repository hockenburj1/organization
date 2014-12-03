<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#accordion" ).accordion();
    });
</script>  
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
                    <li class="active">
                        <a href="organization.php?org=<?php echo $organization->id ?>&action=manage_requests">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Manage Requests</a>
                    </li>
                    <?php endif; ?>
                    <?php if( $user->has_permission($organization->id, 'edit_role') ) : ?>       
                    <li>
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
<div id="accordion">
    <h3 class="accordion">Member Requests</h3>
    <div>
        <?php if(!empty($member_requesters)) : ?>
        <table>
            <?php foreach ($member_requesters as $requester) : ?>
            <tr class="request">
                <td class='request-content'><?php echo $requester->name ?></td> 
                <td class='approve_request'><a href='organization.php?org=<?php echo $organization->id ?>&action=manage_requests&type=member&decision=approve&member_id=<?php echo $requester->id ?>'>Approve</a></td> 
                <td class='deny_request'><a href='organization.php?org=<?php echo $organization->id ?>&action=manage_requests&type=member&decision=deny&member_id=<?php echo $requester->id ?>'>Deny</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else : ?>
                <span>No requests are pending.</span>
        <?php endif; ?>
    </div>
    <h3 class="accordion">Parent Requests</h3>
    <div>
        <?php if(!empty($parent_requesters)) : ?>
        <table>
            <?php foreach ($parent_requesters as $requester) : ?>
            <tr class="request">
                <td class='request-content'><a href="organization.php?org=<?php echo $requester->id ?>"><?php echo $requester->name ?></a></td> 
                <td class='approve_request'><a href='organization.php?org=<?php echo $organization->id ?>&action=manage_requests&type=parent&decision=approve&member_id=<?php echo $requester->id ?>'>Approve</a></td> 
                <td class='deny_request'><a href='organization.php?org=<?php echo $organization->id ?>&action=manage_requests&type=parent&decision=deny&member_id=<?php echo $requester->id ?>'>Deny</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else : ?>
                <span>No requests are pending.</span>
        <?php endif; ?>
    </div>
</div>
                    </div><!--/content wrap-->
    </div><!--/row-->   
</div><!--/container-->
