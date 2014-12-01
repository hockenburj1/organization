<div class="container-fluid">
    <div id="login-form" class="row max-width">
        <h1>Log In</h1>
        <div class="form">
            <div>
            <?php if(isset($error)) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
            <form method="POST" onsubmit="return validate_login()">
                <p>
                    <label>Username: </label>
                    <input id="user-field" name="user" type="text" value="<?php if(!empty($email)) echo $email ?>" autofocus/>
                </p>
                <p>
                    <label>Password: </label>
                    <input id="password-field" name="password" type="password" />
                </p>
                <p>
                    <input class="button" type="submit" value="Log In" />
                    <a href="membership.php?action=register" class="button">Create Account</a>
                </p>  
            </form>
        </div>
        <div class="form-extra">
            <h3>Disclaimer</h3>
            <span>This information will be solely used for the purposes of sending you important updates about the organization you have selected. If at any point you choose to discontinue receiving e-mails this option will be provided at the end of each email.</span>
        </div>
    </div>
</div>

<script>
    function validate_login() {
        var status = true;
        
        var user = document.getElementById("user-field").value;
        var password = document.getElementById("password-field").value;
        
        if(user == "") {
            document.getElementById("user-field").className = "invalid-field";
            status = false
        }
        else {
            document.getElementById("user-field").className = "";
        }
        
        if(password == "") {
            document.getElementById("password-field").className = "invalid-field";
            status = false
        }
        else {
            document.getElementById("password-field").className = "";
        }
        
        return status;  
    }
</script>