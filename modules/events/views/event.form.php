<!--add event-->
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
            <li>
                <a href="event.php">
                    <img src="templates/default/images/layout/thumb-events.png" alt="Search Events" height="40" width="40" class="icon hidden-xs">
                    Events
                </a>
            </li>
            <li class="active">
                <a href="event.php?org=<?php echo $organization->id ?>&action=add_event">
                    <img src="templates/default/images/layout/thumb-add.png" alt="Add Event" height="40" width="40" class="icon hidden-xs">
                    Add Event
                </a>
            </li>
            <!--
            <li>
                <a href="event.php?event=<?php echo $event->id ?>&action=edit_event">
                    <img src="templates/default/images/layout/thumb-add.png" alt="Edit Event" height="40" width="40" class="icon hidden-xs">
                    Calendar
                </a>
            </li>
-->
        </ul>
    <?php include('views/menu-end.php'); ?>
    <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">  

<?php 
$hours = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$minutes = array('00', '15', '30', '45');
$meridiem = array('AM', 'PM');
?>

<?php if($event->id != 0) : ?>
    <h2>Update Event</h2>
    <hr />
    <form method="post" action="event.php?event=<?php echo $event->id ?>&action=<?php echo $action ?>">
<?php else : ?>
    <h2>Add Event</h2>
    <hr />
    <form method="post" class="form form-horizontal" action="event.php?org=<?php echo $org_id ?>&action=<?php echo $action ?>">
<?php endif; ?>
    <div class="form-group">
        <label class="form-label col-xs-12 col-sm-2">Name: </label>
        <div class="col-xs-10 col-sm-10">
        <input name='event-name' type="text" class="form-control" value="<?php echo $event->name; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-xs-12 col-sm-2">Location: </label>
        <div class="col-xs-10">
        <input name='event-location' type="text" class="form-control" value="<?php echo $event->location; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-xs-12 col-sm-2">Start Date: </label>
        <div class="col-xs-10">
        <input name='event-start' type="text" class="col-xs-3" value="<?php if($event->id != 0) {echo $event->start->format('m/d/Y');} ?>"/>
        <select name='event-start-hours' class="col-xs-2 col-sm-1">
            <?php foreach ($hours as $hour) : ?>
                <?php if ($event->id != 0 && $hour == $event->start->format('h')) : ?>
                    <option selected="selected"><?php echo $hour ?></option>
                <?php else : ?>
                    <option><?php echo $hour ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select name='event-start-minutes' class="col-xs-2 col-sm-1">
            <?php foreach ($minutes as $minute) : ?>
                <?php if ($event->id != 0 && $minute == $event->start->format('i')) : ?>
                    <option selected="selected"><?php echo $minute ?></option>
                <?php else : ?>
                    <option><?php echo $minute ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select name='event-start-meridiem' class="col-xs-2 col-sm-1">
            <?php foreach ($meridiem as $m) : ?>
                <?php if ($event->id != 0 && $m == $event->start->format('A')) : ?>
                    <option selected="selected"><?php echo $m ?></option>
                <?php else : ?>
                    <option><?php echo $m ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-xs-12 col-sm-2">End Date: </label>
        <div class="col-xs-10">
            <input name='event-end' class="col-xs-3" type="text" value="<?php if($event->id != 0) {echo $event->finish->format('m/d/Y');} ?>"/>
            <select name='event-end-hours' class="col-xs-2 col-sm-1">
                <?php foreach ($hours as $hour) : ?>
                    <?php if ($event->id != 0 && $hour == $event->finish->format('h')) : ?>
                        <option selected="selected"><?php echo $hour ?></option>
                    <?php else : ?>
                        <option><?php echo $hour ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <select name='event-end-minutes' class="col-xs-2 col-sm-1">
                <?php foreach ($minutes as $minute) : ?>
                    <?php if ($event->id != 0 && $minute == $event->finish->format('i')) : ?>
                        <option selected="selected"><?php echo $minute ?></option>
                    <?php else : ?>
                        <option><?php echo $minute ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <select name='event-end-meridiem' class="col-xs-2 col-sm-1">
                <?php foreach ($meridiem as $m) : ?>
                    <?php if ($event->id != 0 && $m == $event->finish->format('A')) : ?>
                        <option selected="selected"><?php echo $m ?></option>
                    <?php else : ?>
                        <option><?php echo $m ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-xs-12 col-sm-2">Description: </label>
        <div class="col-xs-10">
            <textarea name='event-description' class="form-control" type="text"><?php echo $event->description; ?></textarea>
        </div>
    </div>
    <p>
        <?php if($event->id != 0 ): ?>
            <button>Update Event</button>
        <?php else : ?>
            <button>Add Event</button>
        <?php endif; ?>
    </p>   
</form>

