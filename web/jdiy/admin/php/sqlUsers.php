<?php
	require_once 'functions.php';

	// Effectuer des opérations dans la base selon l'action demandé
	switch($_POST['useAction']) {
		case 'edit':
			$userRights = false;
			$user1Group = -1;
			$user2Group = $_POST['oldGroupId'];
			
			$sql = 'SELECT useGroup FROM users WHERE useId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_SESSION['userId']);
			$sqlp->execute($fields);			
			
			if($sqlp->rowCount() == 1) {
				$user1Tmp = $sqlp->fetch();
				$user1Group = $user1Tmp['useGroup'];
			}
			
			if($user1Group > 0 && $user2Group > 0 && ($user1Group < $user2Group || ($user1Group == $user2Group && $_POST['useId'] == $_SESSION['userId']) && $_POST['useGroupId'] >= $user2Group)) {
				$userRights = true;
			}
			
			if($userRights == true) {
				$sql = 'UPDATE users SET useFirstName = ?, useLastName = ?, useEmail = ?, useGroup = ? WHERE useId = ?';
				$sqlp = $GLOBALS["pdo"]->prepare($sql);
				$fields = array($_POST['useFirstName'], $_POST['useLastName'], $_POST['useEmail'], $_POST['useGroupId'], $_POST['useId']);
				$sqlp->execute($fields);
				
				echo $sqlp->rowCount();
			}else {
				echo -1;
			}
			break;
		case 'del':
			$userRights = false;
			$user1Group = -1;
			$user2Group = -2;
			
			$sql = 'SELECT useGroup FROM users WHERE useId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_SESSION['userId']);
			$sqlp->execute($fields);			
			
			if($sqlp->rowCount() == 1) {
				$user1Tmp = $sqlp->fetch();
				$user1Group = $user1Tmp['useGroup'];
			}
			
			$sql = 'SELECT useGroup FROM users WHERE useId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_POST['useId']);
			$sqlp->execute($fields);			
			
			if($sqlp->rowCount() == 1) {
				$user2Tmp = $sqlp->fetch();
				$user2Group = $user2Tmp['useGroup'];
			}
			
			if($user1Group > 0 && $user2Group > 0 && $user1Group < $user2Group) {
				$userRights = true;
			}
			
			if($userRights == true) {
				$sql = 'UPDATE pages SET pagUser = ? WHERE pagUser = ?';
				$sqlp = $GLOBALS["pdo"]->prepare($sql);
				$fields = array($_SESSION['userId'], $_POST['useId']);
				$sqlp->execute($fields);
				
				$sql = 'DELETE FROM users WHERE useId = ?';
				$sqlp = $GLOBALS["pdo"]->prepare($sql);
				$fields = array($_POST['useId']);
				$sqlp->execute($fields);
				
				echo $sqlp->rowCount();
			}else {
				echo -1;
			}
			
			break;
		case 'add':	
			$userRights = false;
			$user1Group = -1;
			$user2Group = $_POST['useGroupId'];
			
			$sql = 'SELECT useGroup FROM users WHERE useId = ?';
			$sqlp = $GLOBALS["pdo"]->prepare($sql);
			$fields = array($_SESSION['userId']);
			$sqlp->execute($fields);			
			
			if($sqlp->rowCount() == 1) {
				$user1Tmp = $sqlp->fetch();
				$user1Group = $user1Tmp['useGroup'];
			}
			
			if($user1Group > 0 && $user2Group > 0 && $user1Group <= $user2Group) {
				$userRights = true;
			}
			
			if($userRights == true) {		
				$crypass = sha1(strrev($GLOBALS['salt'].$_POST['usePassword']));
				$sql = 'INSERT INTO users (useFirstName, useLastName, useEmail, usePassword, useGroup) VALUES(?, ?, ?, ?, ?)';
				$sqlp = $GLOBALS["pdo"]->prepare($sql);
				$fields = array($_POST['useFirstName'], $_POST['useLastName'], $_POST['useEmail'], $crypass, $_POST['useGroupId']);
				$sqlp->execute($fields);
				
				echo $sqlp->rowCount();
			}else {
				echo -1;
			}
			break;		
	}
?>