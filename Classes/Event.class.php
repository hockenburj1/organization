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
    public $id;
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
            'SELECT event.id,
                event.oid,
                organization.name as organization,
                event.name,
                event.description,
                event.start,
                event.finish
            FROM event
            JOIN Organization ON organization.id = event.oid 
            WHERE event.id = :event_id 
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

    public function save() {
        // Perform data validation
        if(empty($this->name) || empty($this->description) || empty($this->start) || empty($this->finish)) {
            echo "1";
            return false;
        }

        if(!is_a($this->start, 'DateTime') || !is_a($this->finish, 'DateTime')) {
            echo "1";
            return false;
        }

        $start_date_string = $this->start->format('m/d/Y');
        $finish_date_string = $this->start->format('m/d/Y');
        
        if(!$this->check_date($start_date_string) || !$this->check_date($start_date_string) || !strtotime($start_date_string) || !strtotime($finish_date_string)) {
            echo "2";
            return false;
        }

        // Determin if Add or Update
        $update = false;

        if($this->id != 0) {
            $query = "SELECT id FROM Event WHERE id = :id";
            $params = array('id' => $this->id);
            $events = $this->db->query($query, $params);

            if(!empty($events)) {
                $update = true;
            }
        }

        // Add Event
        if ($update == false) {
            $query = "INSERT INTO Event ('oid', 'name', 'description', 'start', 'finish') VALUES(:oid, :name, :description, :start, :finish)";
            $params = 
            array(
                'oid' => $this->oid,
                'name' => $this->name,
                'description' => $this->description,
                'start' => $this->start->format('Y-m-d H:i:00'),
                'finish' => $this->finish->format('Y-m-d H:i:00')
            );
            $this->db->query($query, $params);
        }

        // Update Event
        else {
            $query = 
                "UPDATE Event SET 
                    name = :name,
                    description = :description,
                    start = :start,
                    finish = :finish
                WHERE id = :id"; 
            $params = 
            array(
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'start' => $this->start->format('Y-m-d H:i:00'),
                'finish' => $this->finish->format('Y-m-d H:i:00')
            );
            $this->db->query($query, $params);
        }

        return true;
    }
    
    public static function check_date($date_string) {
        if(strlen($date_string) != 10) {
            return false;
        }

        $date = explode('/', $date_string);
        
        if(checkdate($date[0], $date[1], $date[1])) {
            return true;
        }

        return false;
    }
}
