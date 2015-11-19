<?php
	// Function pour charger les entetes des fichiers
	function addHeader($header) {
		switch($header) {
			case 'pages':
				echo '<link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />';
				echo '<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />';
				break;
			case 'users':
				echo '<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />';
				break;
			case 'menu':
				echo '<link rel="stylesheet" type="text/css" href="css/styleMenu.css" />';
				break;
			case 'plugins':
				echo '<link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />';
				break;
			case 'admin':
				break;
		}
	}

?>