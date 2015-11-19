<?php
	require_once 'functions.php';
	
	// Effectue des opérations sur les menus selon l'action demandé
	switch($_POST['menAction']) {
		case 'show':
			$sql = 'SELECT * FROM menu WHERE menId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['menId']);
			$sqlp->execute($fields);
			$page = $sqlp->fetch();
			
			echo json_encode($page);
			break;
		case 'edit':
			$parent = $_POST['menParent'];
			
			if($parent == "0") {
				$parent = null;
			}
			
			$sql = 'UPDATE menu SET menLevel = ?, menParent = ? WHERE menPage = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['menLevel'], $parent, $_POST['menPage']);
			$sqlp->execute($fields);
			
			echo $sqlp->rowCount();		

			break;
	}
?>