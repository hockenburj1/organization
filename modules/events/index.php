<?php
$organizations = $user->get_organizations();

$oids = array();
foreach ($organizations as $organization) {
    if(is_numeric($organization->id)) {
        $oids[] = $organization->id;
    }   
}

$oids_string = implode(',', $oids);
$query = "SELECT eid from Event WHERE oid IN($oids_string)";
$result = $db->query($query);

$events = array();
foreach ($result as $event_row) {
    $event_id = $event_row['eid'];
    $event = new Event($db, $event_id);
    $events[] = $event;
}

include($module_location . 'views/all.content.php');

?>