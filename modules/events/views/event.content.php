<?php if(!empty($event)) : ?>
    <div class="container-fluid">
    <div class="row" style="background-color:#dcdddf;">
    <?php include('views/menu-start.php'); ?>
        <ul>
            <li>
                <a href="event.php?event=<?php echo $event->id ?>&action=edit_event">
                    <img src="templates/default/images/layout/thumb-add.png" alt="Edit Event" height="40" width="40" class="icon hidden-xs">
                    Edit Event
                </a>
            </li>
        </ul>
    <?php include('views/menu-end.php'); ?>
    <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">  
    <h2><?php echo $event->name ?></h2>
    <hr>
    <span><b>When:</b> <?php echo $event->start->format('F d, Y h:i A'); ?> - <?php echo $event->finish->format('F d, Y h:i A'); ?></span><br />
    <span><b>Where:</b> <?php echo $event->location ?></span><br /><br />
    <span><?php echo $event->description; ?></span><br />
    <br />
    <span>
    	<b>Attendees</b> <br />
    	<?php if(!empty($attendees)) : ?>
    		<?php foreach ($attendees as $attendee) : ?>
    			<a href="#"><?php echo $attendee->name ?></a>
    		<?php endforeach; ?>
    	<?php else : ?>
    		Noone is currently attending this event.
    	<?php endif; ?>
    </span>
    <br />
    <br />

    <?php if(!$event->is_attending()) : ?>
        <a href="event.php?event=<?php echo $event->id ?>&action=register">Register</a>
    <?php else : ?>
        <a href="event.php?event=<?php echo $event->id ?>&action=unregister">Unregister</a>
    <?php endif; ?>
        
    <?php if($user->has_permission($event->oid, 'cancel_event')) : ?> <br />
        <a href="event.php?event=<?php echo $event->id ?>&action=cancel_event">Cancel Event</a>
    <?php endif; ?>
<?php else : ?>
    <h2>Event Not Found</h2>
    <hr>
    <span>The event you were searching for could not be found.</span>
<?php endif; ?>
   

