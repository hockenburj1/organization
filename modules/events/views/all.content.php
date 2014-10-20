<h2>Events</h2>
<hr>

<?php foreach ($events as $event) : ?>
    <h4><?php echo $event->name; ?></h4>
    <span><?php echo $event->description; ?></span><br />
    <span><?php echo $event->start->format('Y-m-d h:i:s'); ?> - <?php echo $event->finish->format('Y-m-d h:i:s'); ?></span><br />
<?php endforeach; ?>

