<html>
    <head>
        <base href="<?php echo SITE_URL ?>">
        <title><?php echo $title ?></title>
        
        
        <!-- styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL ?>css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL ?>css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL ?>css/style.css" />
        
        <!-- script -->
        <script src="<?php echo TEMPLATE_URL ?>js/jquery-1.9.1.js" type='text/javascript'></script>
        <script>
            $(document).ready(function(){
                $("#showHide").click(function(){
                    $("#mobile-site-nav").toggleClass("show-right");
                });
            });
	   </script>
    </head>
    <body>
        <div id="pageWrapper">
            <div id="mobile-site-nav" class="is-right">
                <nav id="mobile-site-nav-inner">
                    <a href="#">1</a>
                    <?php if(isset($_SESSION['user'])) :?>
                        <a href="membership.php?action=logout">Log Out</a>
                    <?php else : ?>
                        <a href="membership.php?action=login">Log In</a>
                    <?php endif;?>
                </nav>
            </div>
             <header id="site-header">
                <div><h1 id="logo"><a href="http://www.thenortherner.com/">Organization Management</a></h1></div>
                    <nav id="site-nav">
                        <a href="#">1</a>
                        <?php if(isset($_SESSION['user'])) :?>
                            <a href="membership.php?action=logout">Log Out</a>
                        <?php else : ?>
                            <a href="membership.php?action=login">Log In</a>
                        <?php endif;?>
                    </nav>
                    <button id="showHide" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
            </header>
            <div id="site-header-holder"></div>
            <div id="info">
                <?php if(isset($content)) echo $content ?>
            </div>
        </div>
    </body>
</html>
