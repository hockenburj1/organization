<?php
$action = isset($_GET['action']) ? $_GET['action'] : '';

//check if already logged in
if(isset($_SESSION['user'])) {
    //if action is logout
    if($action == 'logout') {
        unset($_SESSION['user']);
        header("location: index.php");
    }
    
    //if action is update
    elseif($action == 'update') {
        $user = get_user();

        //Update form submitted
        if (!empty($_POST)) {
            if( !empty(post('register-password')) ) {
                $user->password = password(post('register-password'));
            }
            
            $user->first_name = post('register-first-name');
            $user->last_name = post('register-last-name');
            
            if($user->save()) {
                header('location: dashboard.php');
            }
            
            else {
                $error = 'An error occured while updating your information.';
            }
        }

        include($module_location . 'views/update.form.php');
    }
    
    else {
        //if user is logged in and not logging out
        header("location: dashboard.php");
    }
        
}

// if action is login
if($action == 'login') {
    $login = new Login($db);

    //if login attempted
    if (!empty($_POST)) {
        $email = post('user');
        $password = post('password');
        
        $result = $login->attempt($email, $password);
        
        if ($result != FALSE) {
            $_SESSION['user'] = $result;
            
            header("location: dashboard.php");    
        }
        else {
            $error = "The credentials provided were invalid.";
        }
    }

    include($module_location . 'views/login.form.php');
}

//if action is registration
if($action == 'register') {
    $new_user = new User($db);
    
    //Registration form submitted
    if (!empty($_POST)) {
        $new_user->email = post('register-user');
        $new_user->password = password(post('register-password'));
        $new_user->first_name = post('register-first-name');
        $new_user->last_name = post('register-last-name');
        
        if($new_user->save()) {
            //$_SESSION['user'] = $new_user->id;
            header("location: dashboard.php"); 
        }
        
        else {
            $error = 'An error occured while processing your request.';
        }
    }
    
    include($module_location . 'views/register.form.php');
}


?>
