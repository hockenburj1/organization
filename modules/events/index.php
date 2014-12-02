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