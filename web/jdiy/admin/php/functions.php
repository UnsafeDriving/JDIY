<?php
	session_start();
	
	if(!isset($_SESSION['userFirstName'])) {
		$_SESSION['userFirstName'] = "Invité";
		$_SESSION['userLastName'] = "";
		$_SESSION['userCreated'] = "";
		$_SESSION['userGroup'] = "";
		$_SESSION['userId'] = "";
	}
	
	connect();
	
 	/*==========================================================================*/
	/*	Function connect to database
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output
 	/*==========================================================================*/
	function connect() {
		global $pdo;
		global $crysession;
		global $cryip;
		global $salt;
		
		$salt = '#mf_sr#';
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '69MFUN69';
		$dbname = 'jdiy';
		
		$GLOBALS['crysession'] = md5(session_id());
		$GLOBALS['cryip'] = md5($_SERVER["REMOTE_ADDR"]);
		
		if($pdo == null) {
			$dsn = 'mysql:host='.$dbhost.';dbname='.$dbname;
			$pdo = new PDO($dsn,$dbuser,$dbpass);
			
			/* Correction du bug de caractères spéciaux dans la base de données */
			$pdo->exec('SET NAMES utf8');
			
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
	}
	
	/*==========================================================================*/
	/*	Function check user
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*			- $email	: user's email address
	/*			- $pass	: user's password
	/*		- Output
	/*			- return 'id' if user and password ok
	/*			- return -1 if not privileges
	/*			- else return false
 	/*==========================================================================*/
	function checkUser($email, $pass) {		
		$crypass = sha1(strrev($GLOBALS['salt'].$pass));
	
		$sql = 'SELECT useId, groType 
				FROM users
					INNER JOIN groups
						ON users.useGroup = groups.groId
				WHERE useEmail = ? AND usePassword = ?';
		$sqlp = $GLOBALS["pdo"]->prepare($sql);
		$fields = array($email,$crypass);
		$sqlp->execute($fields);
		
		if($sqlp->rowCount() == 1) {
			$userTmp = $sqlp->fetch();
			if($userTmp['groType'] == 'SuperAdmin' || $userTmp['groType'] == 'Admin') {
				return $userTmp['useId'];
			}else {
				return -1;
			}
		}else {
			return false;
		}
	}
	
	/*==========================================================================*/
	/*	Function login (update sessionid)
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*			- $userid	: user's id
	/*		- Output
 	/*==========================================================================*/
	function setLogged($userId) {
		$sql = 'UPDATE users SET useSession = ?, useIp = ? WHERE useId = ?';
		$sqlp = $GLOBALS["pdo"]->prepare($sql);
		$fields = array($GLOBALS['crysession'],$GLOBALS['cryip'],$userId);
		$sqlp->execute($fields);
		
		$sql = 'SELECT useFirstName, useLastName, useDateCreation, groType
				FROM users 
					INNER JOIN groups
						ON users.useGroup = groups.groId
				WHERE useId = ?';
				
		$sqlp = $GLOBALS["pdo"]->prepare($sql);
		$fields = array($userId);
		$sqlp->execute($fields);
		
		if($sqlp->rowCount() == 1) {
			$userTmp = $sqlp->fetch();		
			$_SESSION['userId'] = $userId;
			$_SESSION['userGroup'] = $userTmp['groType'];
			$_SESSION['userFirstName'] = $userTmp['useFirstName'];
			$_SESSION['userLastName'] = $userTmp['useLastName'];
			$datetime = new DateTime($userTmp['useDateCreation']);
			$_SESSION['userCreated'] = $datetime->getTimestamp();
		}
	}
	
	
	/*==========================================================================*/
	/*	Function check connected
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output
	/*			- return true if connected
	/*			- else return false
 	/*==========================================================================*/
	function loggedIn() {		
		$sql = 'SELECT useId FROM users WHERE useSession = ? AND useIp = ? AND (useGroup = ? || useGroup = ?)';
		$sqlp = $GLOBALS["pdo"]->prepare($sql);
		$fields = array($GLOBALS['crysession'],$GLOBALS['cryip'], 1, 2);
		$sqlp->execute($fields);
		
		if($sqlp->rowCount() == 1) {
			return true;
		}else {
			return false;
		}
	}
	
	/*==========================================================================*/
	/*	Function logout
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output
 	/*==========================================================================*/
	function logout () {
		$sql = 'UPDATE users SET useSession = NULL, useIp = NULL WHERE useSession = ? AND useIp = ?';
		$sqlp = $GLOBALS["pdo"]->prepare($sql);
		$fields = array($GLOBALS['crysession'],$GLOBALS['cryip']);
		$sqlp->execute($fields);
		
		session_unset(); 
		
		session_destroy();
		
		return true;
	}
		
	/*==========================================================================*/
	/*	Function contrôle syntaxe e-mail
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output
 	/*==========================================================================*/
	function isEmailValidRegex($email) {
		if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
			return true;
		}else {
			return false;
		}
	}
	
	/*==========================================================================*/
	/*	Function contrôle filtre e-mail php
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output
 	/*==========================================================================*/
	function isEmailValidFilter($email) {
		if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
			return false;
		}else {
			return true;
		}
	}
	
	/*==========================================================================*/
	/*	Function contrôle dns domaine e-mail
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output
 	/*==========================================================================*/
	function isEmailValidDomain($email) {
		list($user,$domain) = split('@',$email);
		return checkdnsrr($domain,'MX');
	}
	
	/*==========================================================================*/
	/*	Function qui recupere le menu
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output les pages du menu
 	/*==========================================================================*/
	function getMenu() {			
		$sql = 'SELECT pagId, pagTitle FROM pages';
		$listepage = $GLOBALS["pdo"]->query($sql);
		while($page = $listepage->fetch()) {
			$pages[] = '<a href="index.php?id='.$page['pagId'].'">'.$page['pagTitle'].'</a>';
		}
		
		return $pages;
	}
	
	/*==========================================================================*/
	/*	Function qui recupere les pages
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output les pages
 	/*==========================================================================*/
	function getPages() {
		$sql = 'SELECT pagId, pagTitle, pagContent FROM pages';
		$resSql = $GLOBALS["pdo"]->query($sql);
		
		$pages = array();
		foreach($resSql AS $page) {
			$pages[] = array('pagId' => $page['pagId'], 'pagTitle' => $page['pagTitle'], 'pagContent' => $page['pagContent']);
		}
		
		return $pages;
	}
	
	/*==========================================================================*/
	/*	Function qui recupere les utilisateurs
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output les utilisateurs
 	/*==========================================================================*/
	function getUsers() {
		$sql = 'SELECT * FROM displayUsers';
		$resSql = $GLOBALS["pdo"]->query($sql);
		
		$users = array();
		foreach($resSql AS $user) {
			$users[] = array('useId' => $user['useId'], 'useFirstName' => $user['useFirstName'], 'useLastName' => $user['useLastName'], 'useEmail' => $user['useEmail'], 'useGroup' => $user['useGroup'], 'useGroupId' => $user['useGroupId']);
		}
		
		return $users;
	}
	
	/*==========================================================================*/
	/*	Function qui recupere les groups
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output les groups
 	/*==========================================================================*/
	function getGroups() {
		$sql = 'SELECT groId, groType FROM groups';
		$resSql = $GLOBALS["pdo"]->query($sql);
		
		$groups = array();
		foreach($resSql AS $group) {
			$groups[] = array('groId' => $group['groId'], 'groType' => $group['groType']);
		}
		
		return $groups;
	}
	
	/*==========================================================================*/
	/*	Function qui recupere les plugins
	/*		- Author(s) : Mario Ferreira & Thibaud Duchoud
	/*		- Input
	/*		- Output les plugins
 	/*==========================================================================*/
	function getPlugins() {
		$sql = 'SELECT * FROM plugins';
		$resSql = $GLOBALS["pdo"]->query($sql);
		
		$plugins = array();
		foreach($resSql AS $group) {
			$plugins[] = array('pluName' => $group['pluName'], 'pluDescription' => $group['pluDescription'], 'pluVersion' => $group['pluVersion'], 'pluActive' => $group['pluActive']);
		}
		
		return $plugins;
	}
?>
