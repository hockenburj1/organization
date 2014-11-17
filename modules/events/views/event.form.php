<?php 
$hours = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
$minutes = array('00', '15', '30', '45');
$meridiem = array('AM', 'PM');
?>

<?php if(isset($event)) : ?>
    <h2>Update Event</h2>
    <hr />
    <form method="post" action="event.php?event=<?php echo $event->id ?>&action=<?php echo $action ?>">
<?php else : ?>
    <h2>Add Event</h2>
    <hr />
    <form method="post" action="event.php?action=<?php echo $action ?>">
<?php endif; ?>
    <p>
        <label>Name: </label>
        <input type="text" value="<?php if(isset($event)) {echo $event->name;} ?>"/>
    </p>
    <p>
        <label>Description: </label>
        <textarea type="text"><?php if(isset($event)) {echo $event->description;} ?></textarea>
    </p>
    <p>
        <label>Start Date: </label>
        <input type="text" value="<?php if(isset($event)) {echo $event->start->format('m/d/Y');} ?>"/>
        <select>
            <?php foreach ($hours as $hour) : ?>
                <?php if (isset($event) && $hour == $event->start->format('h')) : ?>
                    <option selected="selected"><?php echo $hour ?></option>
                <?php else : ?>
                    <option><?php echo $hour ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select>
            <?php foreach ($minutes as $minute) : ?>
                <?php if (isset($event) && $minute == $event->start->format('i')) : ?>
                    <option selected="selected"><?php echo $minute ?></option>
                <?php else : ?>
                    <option><?php echo $minute ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select>
            <?php foreach ($meridiem as $m) : ?>
                <?php if (isset($event) && $m == $event->start->format('A')) : ?>
                    <option selected="selected"><?php echo $m ?></option>
                <?php else : ?>
                    <option><?php echo $m ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label>End Date: </label>
        <input type="text" value="<?php if(isset($event)) {echo $event->finish->format('m/d/Y');} ?>"/>
        <select>
            <?php foreach ($hours as $hour) : ?>
                <?php if (isset($event) && $hour == $event->finish->format('h')) : ?>
                    <option selected="selected"><?php echo $hour ?></option>
                <?php else : ?>
                    <option><?php echo $hour ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select>
            <?php foreach ($minutes as $minute) : ?>
                <?php if (isset($event) && $minute == $event->finish->format('i')) : ?>
                    <option selected="selected"><?php echo $minute ?></option>
                <?php else : ?>
                    <option><?php echo $minute ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <select>
            <?php foreach ($meridiem as $m) : ?>
                <?php if (isset($event) && $m == $event->finish->format('A')) : ?>
                    <option selected="selected"><?php echo $m ?></option>
                <?php else : ?>
                    <option><?php echo $m ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <?php if(isset($event)) : ?>
            <button>Update Event</button>
        <?php else : ?>
            <button>Add Event</button>
        <?php endif; ?>
    </p>
    
</form>

