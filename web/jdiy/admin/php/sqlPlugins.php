<?php
	require_once 'functions.php';
	
	// Effectue des opérations sur les plugins selon l'action demandé
	switch($_POST['pluAction']) {
		case 'edit':			
			$sql = 'UPDATE plugins SET pluActive = ? WHERE pluName = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['pluActive'], $_POST['pluName']);
			$sqlp->execute($fields);
			
			echo $sqlp->rowCount();		

			break;
	}
?>