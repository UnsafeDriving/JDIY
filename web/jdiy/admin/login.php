<?php 
	require_once 'php/functions.php';
	
	// Si connecé le renvoyer sur administration
	if(loggedIn() == true) {
		header("refresh:0;url=admin.php");
	}
	$error = -1;
		
	// Connecter utilisateur
	if(isset($_POST['email'])) {
		$userid = checkUser($_POST['email'], $_POST['password']);
		if($userid == -1) {
			$error = 2;
		}else if($userid) {					
			setLogged($userid);
			$error = 0;
		}else {
			$error = 1;
		}
	}
?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Administration</div>
            <form action="#" method="post">
                <div class="body bg-gray">
                	<?php
						if($error == 0) {
							echo '<div class="callout callout-success">
								<p>Connexion en cours...</p>
								</div>';
							header("refresh:2;url=admin.php");
						}else if($error == 1) {
							echo '<div class="callout callout-danger">
								<p>E-mail et/ou mot de passe incorrect(s).</p>
								</div>';
						}else if($error == 2) {
							echo '<div class="callout callout-danger">
								<p>Vous ne possédez pas les droits.</p>
								</div>';
						}
						
						if($error != 0) {
							echo '<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="E-mail"/>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control" placeholder="Mot de passe"/>
								</div>
								<!--<div class="form-group">
									<input type="checkbox" name="remember_me"/> Remember me
								</div>-->';
						}
					?>
                    
                </div>
				<?php
					if($error != 0) {                
						echo '<div class="footer">
							<button type="submit" class="btn bg-olive btn-block">Se connecter</button>

								<!--<p><a href="#">I forgot my password</a></p>-->

								<!--<a href="register.html" class="text-center">Register a new membership</a>-->
					
							</div>';
					}
				?>
            </form>

            <!--<div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div>-->
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
