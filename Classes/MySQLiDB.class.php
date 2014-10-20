<?php

class MySQLiDB extends Database {
    private $con;
    
    function __construct($host, $user, $password, $name) {
        $dsn = "mysql:dbname=$name;host=$host";
        $this->con = new PDO($dsn, $user, $password);
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
    
    function query_objects($query, $parameters = array(), $class_name) {
        $statement = $this->con->prepare($query);
        $statement->execute($parameters);
        
        $objects = array();
        while ($object = $statement->fetchObject("User")) {
            $objects[] = $object;
        }
        return $objects;
    }
    
    public function last_id() {
        return $this->con->lastInsertId();
    }
}
?>
