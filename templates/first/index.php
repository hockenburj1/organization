
<html>
    <head>
        <base href="<?php echo SITE_URL ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL ?>css/style.css" />
        <title><?php echo $title ?></title>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <span id="logo"><a href="index.php"><img src="images/fbla-pbl.gif" /></a></span>
                <span id="logout">
                    <?php if(isset($_SESSION['user'])) :?>
                        <a href="membership.php?action=logout">Log Out</a>
                    <?php else : ?>
                        <a href="membership.php?action=login">Log In</a>
                    <?php endif;?>
                </span> 
            </div>
            
            <div id="info">
                <?php if(isset($content)) echo $content ?>
            </div>
            <div style="clear: both;"></div>
        </div>
    </body>
</html>
