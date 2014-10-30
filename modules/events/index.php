<?php
$event_id = empty(get('event')) ? '0' : get('event');
$org_id = empty(get('org')) ? '0' : get('org');
$action = get('action');

if($event_id != 0) { 
    $event = Event::get_event($db, $event_id);
    include($module_location . 'views/event.content.php'); 
}

elseif ($org_id != 0 && $user->is_member($org_id)) {
    $organization = Organization::get_organization($db,$org_id);
    $events = $organization->get_events();
    include($module_location . 'views/all.content.php');  
}

else {
    $events = $user->get_events();
    include($module_location . 'views/all.content.php');  
}


?>