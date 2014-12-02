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
    <form method="post" class="form" action="event.php?org=<?php echo $org_id ?>&action=<?php echo $action ?>">
<?php endif; ?>
    <div class="form-group">
        <label class="form-label col-xs-2">Name: </label>
        <div class="col-xs-10">
        <input name='event-name' type="text" class="form-control" value="<?php echo $event->name; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-xs-2">Location: </label>
        <div class="col-xs-10">
        <input name='event-location' type="text" class="form-control" value="<?php echo $event->location; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label col-xs-2">Start Date: </label>
        <div class="col-xs-10">
        <input name='event-start' type="text" class="col-xs-3" value="<?php if($event->id != 0) {echo $event->start->format('m/d/Y');} ?>"/>
        <select name='event-start-hours' class="col-xs-3">
            <?php foreach ($hours as $hour) : ?>
                <?php if ($event->id != 0 && $hour == $event->start->format('h')) : ?>
                    <option selected="selected"><?php echo $hour ?></option>
                <?php else : ?>
                    <option><?php echo $hour ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select name='event-start-minutes' class="col-xs-3">
            <?php foreach ($minutes as $minute) : ?>
                <?php if ($event->id != 0 && $minute == $event->start->format('i')) : ?>
                    <option selected="selected"><?php echo $minute ?></option>
                <?php else : ?>
                    <option><?php echo $minute ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select name='event-start-meridiem' class="col-xs-3">
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
    <p>
        <label>End Date: </label>
        <input name='event-end' type="text" value="<?php if($event->id != 0) {echo $event->finish->format('m/d/Y');} ?>"/>
        <select name='event-end-hours'>
            <?php foreach ($hours as $hour) : ?>
                <?php if ($event->id != 0 && $hour == $event->finish->format('h')) : ?>
                    <option selected="selected"><?php echo $hour ?></option>
                <?php else : ?>
                    <option><?php echo $hour ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select name='event-end-minutes'>
            <?php foreach ($minutes as $minute) : ?>
                <?php if ($event->id != 0 && $minute == $event->finish->format('i')) : ?>
                    <option selected="selected"><?php echo $minute ?></option>
                <?php else : ?>
                    <option><?php echo $minute ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select name='event-end-meridiem'>
            <?php foreach ($meridiem as $m) : ?>
                <?php if ($event->id != 0 && $m == $event->finish->format('A')) : ?>
                    <option selected="selected"><?php echo $m ?></option>
                <?php else : ?>
                    <option><?php echo $m ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label>Description: </label>
        <textarea name='event-description' type="text"><?php echo $event->description; ?></textarea>
    </p>
    <p>
        <?php if($event->id != 0 ): ?>
            <button>Update Event</button>
        <?php else : ?>
            <button>Add Event</button>
        <?php endif; ?>
    </p>   
</form>

