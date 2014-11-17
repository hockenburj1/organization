<?php
$event_id = empty(get('event')) ? '0' : get('event');
$org_id = empty(get('org')) ? '0' : get('org');
$action = get('action');

if($event_id != 0) { 
    $event = Event::get_event($db, $event_id);
    if(empty($event) || !$user->is_member($event->oid)) {
        $events = $user->get_events();
        include($module_location . 'views/all.content.php');
    }
    
    elseif(!$user->has_permission($event->oid, $action) ) {
        include($module_location . 'views/event.content.php'); 
    }
    
    else {
        switch ($action) {
            case 'add_event' :
                $event = NULL;
                include($module_location . 'views/event.form.php'); 
                break;
            case 'edit_event' :
                include($module_location . 'views/event.form.php'); 
                break;
            default :
                include($module_location . 'views/event.content.php'); 
                break;
        }
    }
    
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