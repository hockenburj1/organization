<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo SITE_URL ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo TEMPLATE_URL ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo TEMPLATE_URL ?>css/shop-item.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p class="lead" style="color:#428BCA">
					<img src="images/fbla-pbl.gif" width="160" style="padding-left:20px;"/>
				</p>
                <div class="list-group">
                    <a href="index.php" class="list-group-item active">Home</a>
                    <a href="search.php" class="list-group-item">Search</a>
                    
					<?php if(isset($_SESSION['user'])) :?>
                        <a href="organizations.php" class="list-group-item">Organizations</a>
						<a href="event.php" class="list-group-item">Events</a>
						<a href="membership.php?action=logout" class="list-group-item">Log Out</a>
                    <?php else : ?>
                        <a href="#" class="list-group-item">About Us</a>
						<a href="membership.php?action=login" class="list-group-item">Log In</a>
                    <?php endif;?>
                </div>
            </div>

            <div class="col-md-9">
                <div class="col-md-9">
					<?php echo $content ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <hr>
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Jesse Hockenbury 2014</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="<?php echo TEMPLATE_URL ?>js/jquery-1.11.0.js"></script>
    <script src="<?php echo TEMPLATE_URL ?>js/bootstrap.min.js"></script>
</body>
</html>