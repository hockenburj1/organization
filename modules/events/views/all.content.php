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
            <li class="active">
                <a href="event.php">
                    <img src="templates/default/images/layout/thumb-events.png" alt="Search Events" height="40" width="40" class="icon hidden-xs">
                    Events
                </a>
            </li>
            <li>
                <a href="event.php?org=<?php echo $organization->id ?>&action=add_event">
                    <img src="templates/default/images/layout/thumb-add.png" alt="Add Event" height="40" width="40" class="icon hidden-xs">
                    Add Event
                </a>
            </li>
        </ul>
    <?php include('views/menu-end.php'); ?>
    <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">	
<h2>Events</h2>
<hr>
<?php if(!empty($events)) : ?>
    <?php foreach ($events as $event) : ?>
        <h4><a href="event.php?event=<?php echo $event->id ?>"><?php echo $event->name; ?></a></h4>
        <span><?php echo $event->start->format('Y-m-d h:i:s'); ?> - <?php echo $event->finish->format('Y-m-d h:i:s'); ?></span><br />
    <?php endforeach; ?>
<?php else : ?>
        <span>There are currently no upcoming events.</span>
<?php endif; ?>
</div>
</div>



