<div class="container-fluid">
    <div id="login-form" class="row max-width">
<h1>New User Registration</h1>

<div class="form">
    <div>
    <?php if(isset($error)) : ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>
    <form method="POST">
        <p>
            <label>First Name: </label>
            <input name="register-first-name" type="text" value="<?php echo post('register-first-name') ?>" autofocus/>
        </p>
        <p>
            <label>Last Name: </label>
            <input name="register-last-name" type="text" value="<?php echo post('register-last-name') ?>" />
        </p>
        <p>
            <label>E-Mail: </label>
            <input name="register-user" type="text" value="<?php echo post('register-user') ?>" />
        </p>
        
            <div class="form-right">This username is currently available</div>
        
        <p>
            <label>Password: </label>
            <input name="register-password" type="password" />
        </p>

        <p>
            <input class="button" type="submit" value="Register" />    
        </p>  
    </form>
</div>
<div class="form-extra">
    <h3>Disclaimer</h3>
    <span>This information will be solely used for the purposes of sending you important updates about the organization you have selected. If at any point you choose to discontinue receiving e-mails this option will be provided at the end of each email.</span>
</div>
            </div>
</div>
