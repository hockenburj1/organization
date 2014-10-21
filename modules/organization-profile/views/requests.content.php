<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#accordion" ).accordion();
    });
</script>  
 
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