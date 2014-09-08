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
}
?>
