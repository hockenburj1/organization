<?php

Class Login {
    public $db;
    
    public function Login($db) {
        $this->db = $db; 
        if(!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = '0';
        }
    }
    
    public function attempt($email, $password) { 
        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            return FALSE;
        }

        $password = password($password);
        $query = "SELECT * FROM user WHERE email = :email AND password = :password LIMIT 1";
        $params = array('email' => $email, 'password' => $password);
        $result = $this->db->query($query, $params);
        if (count($result) != 0) {
            return $result[0]['id'];
        }
        else {
            return FALSE;
        }
    }
}
?>
