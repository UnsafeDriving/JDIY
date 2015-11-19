<?php
	require_once 'functions.php';

	// Effectue des opérations sur les pages selon l'action demandé
	switch($_POST['pageAction']) {
		case 'edit':
			$sql = 'UPDATE pages SET pagTitle = ?, pagContent = ? WHERE pagId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['pageTitle'], $_POST['pageContent'], $_POST['pageId']);
			$sqlp->execute($fields);
			
			echo $sqlp->rowCount();
			break;
		case 'del':
			$sql = 'DELETE FROM pages WHERE pagId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['pageId']);
			$sqlp->execute($fields);
			
			echo $sqlp->rowCount();
			
			/*$sql = 'UPDATE menu SET menParent = 0 WHERE menParent = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['pageId']);
			$sqlp->execute($fields);
			
			$sql = 'DELETE FROM menu WHERE menPage = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['pageId']);
			$sqlp->execute($fields);*/
			break;
		case 'add':
			$sql = 'INSERT INTO pages (pagTitle, pagContent, pagUser) VALUES(?, ?, ?)';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['pageTitle'], $_POST['pageContent'], $_SESSION['userId']);
			$sqlp->execute($fields);
			
			echo $sqlp->rowCount();
			break;
		
	}
	
?>