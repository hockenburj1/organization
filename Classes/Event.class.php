<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Create an event with a name, description, start and end date
 *
 * @author hocke_000
 */
class Event {
    public $name;
    public $description;
    public $start;
    public $finish;

    public function __construct($event_id = 0) {
        global $db;
        $this->db = $db;
        
        if( $this->id != 0 ) {
            $this->start = date_create($this->start);
            $this->finish = date_create($this->finish);      
        }
    }
    
    public static function get_event($db, $event_id) {
        $query = 
            'SELECT id,
                oid,
                name,
                description,
                start,
                finish
            FROM event 
            WHERE id = :event_id 
            LIMIT 1';
        $params = array('event_id' => $event_id);
        $events = $db->query_objects($query, $params, 'Event');
        
        if(!empty($events)) {
            return $events[0];
        }
        else {
            return NULL;
        }
    }
    
}
