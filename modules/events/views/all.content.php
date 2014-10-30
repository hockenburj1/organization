<h2>Events</h2>
<hr>
<?php if(!empty($events)) : ?>
    <?php foreach ($events as $event) : ?>
        <h4><a href="event.php?event=<?php echo $event->id ?>"><?php echo $event->name; ?></a></h4>
        <span><?php echo $event->description; ?></span><br />
        <span><?php echo $event->start->format('Y-m-d h:i:s'); ?> - <?php echo $event->finish->format('Y-m-d h:i:s'); ?></span><br />
    <?php endforeach; ?>
<?php else : ?>
        <span>There are currently no upcoming events.</span>
<?php endif; ?>



