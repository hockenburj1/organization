<div class="container-fluid">
    <div class="row" style="background-color:#dcdddf;">
        <div class="decorative-border"></div>
        <div class="col-xs-12 col-sm-3 col-md-3 right-nav">
            <h1 id="user-greeting" class="hidden-xs">Organizations</h1>
            <ul>
                <li>
                    <a href="dashboard.php">
                        <img src="templates/default/images/layout/thumb-home.png" alt="Dashboard" height="40" width="40" class="icon hidden-xs">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="organizations.php">
                        <img src="templates/default/images/layout/thumb-organizations.png" alt="Search Organization" height="40" width="40" class="icon hidden-xs">
                        Organizations
                    </a>
                </li>
                <li class="active">
                    <a href="event.php">
                        <img src="templates/default/images/layout/thumb-events.png" alt="Search Events" height="40" width="40" class="icon hidden-xs">
                        Events
                    </a>
                </li>
                <li>
                    <a href="membership.php?action=update">
                        <img src="templates/default/images/layout/thumb-edit.png" alt="Make Edits" height="40" width="40" class="icon hidden-xs">
                        Edit User
                    </a>
                </li>
                <li>
                    <a href="organization.php?action=add_organization">
                        <img src="templates/default/images/layout/thumb-add.png" alt="Add Organization" height="40" width="40" class="icon hidden-xs">
                        Add Organization
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 content-wrap">
        <?php
            $event_id = empty(get('event')) ? '0' : get('event');
            $org_id = empty(get('org')) ? '0' : get('org');
            $action = get('action');

            // If a specific event is indicated
            if($event_id != 0) { 
                $event = Event::get_event($db, $event_id);

                // Check event existence and organization membership
                if(empty($event) || !$user->is_member($event->oid)) {
                    $events = $user->get_events();
                    include($module_location . 'views/all.content.php');
                }

                // Handle Registration
                elseif ($action == 'register' || $action == 'unregister') {  
                    if ($action == 'register') {
                        $event->register();
                    }

                    else {
                        $event->unregister();
                    }

                    $attendees = $event->get_attendees();
                    include($module_location . 'views/event.content.php'); 
                }

                // Verify user permissions
                elseif(!$user->has_permission($event->oid, $action) ) {
                    $attendees = $event->get_attendees();
                    include($module_location . 'views/event.content.php'); 
                }

                // If all requirements are met
                else {
                    switch ($action) {
                        case 'edit_event' :
                            if(!empty($_POST)) {
                                // Check dates
                                if(!Event::check_date(post('event-start')) || !Event::check_date(post('event-end'))) {
                                    header('location: event.php');
                                }

                                // Account for AM or PM
                                if(post('event-start-meridiem') == 'PM') {
                                    $_POST['event-start-hours'] += 12;     
                                }

                                if(post('event-end-meridiem') == 'PM') {
                                    $_POST['event-end-hours'] += 12;     
                                }

                                // Create start date object
                                $start_date_string = post('event-start') . " " . post('event-start-hours') . ':' . post('event-start-minutes');
                                $start = new DateTime($start_date_string);

                                // Create end date object
                                $end_date_string = post('event-end') . " " . post('event-end-hours') . ':' . post('event-end-minutes');
                                $end = new DateTime($end_date_string);

                                // Define event properties
                                $event->name = post('event-name');
                                $event->description = post('event-description');
                                $event->start = $start;
                                $event->finish = $end;
                                $event->location = post('event-location');

                                if ($event->save()) {
                                    header("location: event.php?org=" . $event->oid);
                                }
                            }

                            include($module_location . 'views/event.form.php'); 
                            break;
                        case 'cancel_event':
                            $event->delete();
                            header('location: event.php?org=' . $event->oid);
                            break;
                        default :
                            include($module_location . 'views/event.content.php'); 
                            break;
                    }
                }  
            }

            // Handle events specific to an organization
            elseif ($org_id != 0 && $user->is_member($org_id)) {
                if($action == 'add_event' && $user->has_permission($org_id, 'add_event')) {
                    $event = new Event($org_id);

                    // If new event form submitted
                    if(!empty($_POST)) {
                        // Check dates
                        if(!Event::check_date(post('event-start')) || !Event::check_date(post('event-end'))) {
                            header('location: event.php');
                        }

                        // Account for AM or PM
                        if(post('event-start-meridiem') == 'PM') {
                            $_POST['event-start-hours'] += 12;     
                        }

                        if(post('event-end-meridiem') == 'PM') {
                            $_POST['event-end-hours'] += 12;     
                        }

                        // Create start date object
                        $start_date_string = post('event-start') . " " . post('event-start-hours') . ':' . post('event-start-minutes');
                        $start = new DateTime($start_date_string);

                        // Create end date object
                        $end_date_string = post('event-end') . " " . post('event-end-hours') . ':' . post('event-end-minutes');
                        $end = new DateTime($end_date_string);

                        // Define event properties
                        $event->oid = $org_id;
                        $event->name = post('event-name');
                        $event->description = post('event-description');
                        $event->start = $start;
                        $event->finish = $end;
                        $event->location = post('event-location');

                        if ($event->save()) {
                            header("location: event.php?org=" . $event->oid);
                        }

                    }

                    include($module_location . 'views/event.form.php'); 
                }

                // Show list of events for organization
                else {
                    $organization = Organization::get_organization($db,$org_id);
                    $events = $organization->get_events();
                    include($module_location . 'views/all.content.php');
                }  
            }

            // Show all events available to a user
            else {
                $events = $user->get_events();
                include($module_location . 'views/all.content.php');  
            }
            ?>
        </div>
    </div>
</div>