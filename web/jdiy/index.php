<?php 
	require_once 'admin/php/functions.php';
	require_once 'php/functions.php';
	
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	$option = extractUrl($url);
	
	if($option == false) {
		header("Location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <title>JDIY - CMS</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="assets/js/modernizr.js"></script>
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">JDIY</a>
        </div>
        <div class="navbar-collapse collapse navbar-right">
          <ul class="nav navbar-nav">
			<?php
				$sql = 'SELECT menPage FROM menu WHERE menParent IS NULL ORDER BY menLevel';
				$sqlp = $GLOBALS["pdo"]->query($sql);
				$menusroot = $sqlp->fetchAll();
				
				$level1 = 1;
				$level2 = 1;
				$level3 = 1;
				
				$nbRows = 0;
				foreach($menusroot as $amenuroot){
					$i = 1;
					foreach($amenuroot as $menuroot){
						if($i&1) {
							$sql = 'SELECT pagTitle FROM pages WHERE pagId = '.$menuroot;
							$sqlp = $GLOBALS["pdo"]->query($sql);
							$name = $sqlp->fetch();
							
							$nbRows++;

							$sql = 'SELECT menPage FROM menu WHERE menParent = '.$menuroot.' ORDER BY menLevel';
							$sqlp = $GLOBALS["pdo"]->query($sql);
							$menuschild = $sqlp->fetchAll();
							
							if(count($menuschild) > 0) {
								echo '<li class="dropdown">';
								echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$name['pagTitle'].' <b class="caret"></b></a>';
								echo '<ul class="dropdown-menu">';
							}else {
								echo '<li><a href="?p='.$menuroot.'">'.$name['pagTitle'].'</a></li>';
							}
							
							foreach($menuschild as $amenuchild){
								$j = 1;
								foreach($amenuchild as $menuchild){
									if($j&1) {
										echo '<li><a href="?p='.$menuroot.'">'.$name['pagTitle'].'</a></li>';
										$sql = 'SELECT pagTitle FROM pages WHERE pagId = '.$menuchild;
										$sqlp = $GLOBALS["pdo"]->query($sql);
										$name = $sqlp->fetch();
										
										$nbRows++;
										echo '<li><a href="?p='.$menuchild.'">'.$name['pagTitle'].'</a></li>';
									}
									$j++;
								}
							}
							if(count($menuschild) > 0) {
								echo '</ul></li>';
							}
							
						}
						$i++;
						$level2++;
					}
				}
			?>
			</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	 
	<!-- *****************************************************************************************************************
	 BLOG CONTENT
	 ***************************************************************************************************************** -->

	 <div class="container mtb">
	 	<div class="row">
			<?php displayPlugins(); ?>
			<br>
			<?php displayPage($option); ?>
	 	</div><! --/row -->
	 </div><! --/container -->


	<!-- *****************************************************************************************************************
	 FOOTER
	 ***************************************************************************************************************** -->
	 <div id="footerwrap">
	 	<div class="container">
		 	<div class="row" style="text-align:center">
		 		<p>Copyright © 2015 JDIY. Tous droits réservés.</p>		 	
		 	</div><! --/row -->
	 	</div><! --/container -->
	 </div><! --/footerwrap -->
	 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/retina-1.1.0.js"></script>
	<script src="assets/js/jquery.hoverdir.js"></script>
	<script src="assets/js/jquery.hoverex.min.js"></script>
	<script src="assets/js/jquery.prettyPhoto.js"></script>
  	<script src="assets/js/jquery.isotope.min.js"></script>
  	<script src="assets/js/custom.js"></script>


  </body>
</html>
