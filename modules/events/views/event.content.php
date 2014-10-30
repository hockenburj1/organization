<?php if(!empty($event)) : ?>
    <h2><?php echo $event->name ?></h2>
    <hr>
    <span><?php echo $event->start->format('Y-m-d h:i:s'); ?> - <?php echo $event->finish->format('Y-m-d h:i:s'); ?></span><br />
    <span><?php echo $event->description; ?></span><br />
<?php else : ?>
    <h2>Event Not Found</h2>
    <hr>
    <span>The event you were searching for could not be found.</span>
<?php endif; ?>
   

