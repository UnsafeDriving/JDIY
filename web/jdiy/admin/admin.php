<?php
	require_once 'php/functions.php';
	require_once 'php/navigation.php';
	require_once 'php/display.php';
	require_once 'php/headers.php';
	require_once 'php/scripts.php';
	
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	$option = extractUrl($url);
	
	if($option == false) {
		header("Location:admin.php?p=404");
	}
	
	if(isset($_POST['logout'])) {
		logout();
	}
	
	if(loggedIn() == false) {
		header("Location:index.html");
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>JDIY | Tableau de bord</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<?php
			addHeader($option);
		?>        
        <!-- Theme style -->
		<link href="css/jAlert-v2.css" rel="stylesheet" type="text/css" />
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                JDIY
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $_SESSION['userFirstName']." ".$_SESSION['userLastName']; ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/avatar5.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $_SESSION['userFirstName']." ".$_SESSION['userLastName']; ?>
                                        <small><?php if($_SESSION['userCreated'] != "") { setlocale(LC_TIME, 'fra_fra'); echo "Membre depuis ".strftime('%B %Y',  $_SESSION['userCreated']); }?></small>
										<small><?php echo $_SESSION['userGroup'];?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                    </div>
                                    <div class="pull-right">
                                        <form action="#" method="post">
											<!--<a href="#" class="btn btn-default btn-flat">Se déconnecter</a>-->
                                            <button type="submit" name ="logout" class="btn btn-default btn-flat">Se déconnecter</button>
										</form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/avatar5.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Bonjour, <?php echo $_SESSION['userFirstName']; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> En ligne</a>
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="admin.php">
                                <i class="fa fa-dashboard"></i> <span>Tableau de bord</span>
                            </a>
                        </li>
						<li>
                            <a href="?p=pages">
                                <i class="fa fa-file-text"></i> <span>Pages</span>
                            </a>
                        </li>
						<li>
                            <a href="?p=users">
                                <i class="fa fa-user"></i> <span>Utilisateurs</span>
                            </a>
                        </li>
						<li>
                            <a href="?p=menu">
                                <i class="fa fa-th-list"></i> <span>Menu</span>
                            </a>
                        </li>
						<li>
                            <a href="?p=plugins">
                                <i class="fa fa-plug"></i> <span>Plugins</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
				<?php
					display($option);
				?>
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


        <!-- jQuery 2.0.2 -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
		<!--<script src="js/jquery-impromptu.js" type="text/javascript"></script>-->
		<script>
		</script>
		<?php
			addScript($option);
		?>
		
		<script src="js/jAlert-v2.js" type="text/javascript"></script>
    </body>
</html>
