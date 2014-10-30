<?php

class MySQLiDB extends Database {
    private $con;
    
    function __construct($host, $user, $password, $name) {
        $dsn = "mysql:dbname=$name;host=$host";
        try {
            $this->con = new PDO($dsn, $user, $password);
        }
	catch(PDOException $ex) { 
            die("Failed to connect to the database: " . $ex->getMessage()); 
	} 
    }


    function query($query, $parameters = array()){
        $resultset = array();
        $statement = $this->con->prepare($query);
        $statement->execute($parameters);
        
        if(is_bool($statement) && $statement == TRUE) {
            return TRUE;
        }
        //echo $query . "<br />";
        while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $resultset[] = $row;
        }
        
        return $resultset;
    }
    
    function query_objects($query, $parameters, $class_name) {
        $statement = $this->con->prepare($query);
        $statement->execute($parameters);

        $objects = array();
        while ($object = $statement->fetchObject($class_name)) {
            $objects[] = $object;
        }

        return $objects;
    }
    
    public function last_id() {
        return $this->con->lastInsertId();
    }
}
?>
