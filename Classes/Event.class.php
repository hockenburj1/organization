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

    public function __construct($db, $event_id = 0) {
        $query = 'SELECT * FROM event WHERE eid = :event_id LIMIT 1';
        $params = array('event_id' => $event_id);
        $result = $db->query($query, $params);
        
        if( !empty($result) ) {
            $this->name = $result[0]['name'];
            $this->description = $result[0]['description'];
            $this->start = date_create($result[0]['start']);
            $this->finish = date_create($result[0]['finish']);      
        }
    }
    
}
