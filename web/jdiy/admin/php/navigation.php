<?php
	// Fonction pour extraire les paramètres de l'url
	function extractUrl($url) {
		$pos = strpos($url, '?');
		if($pos != false) {
			$url = substr($url, $pos+1);
			$pos = strpos($url, '=');
			if($pos != false) {
				$param = substr($url, 0, $pos);
				$url = substr($url, $pos+1);
				switch($param ) {
					case 'p':
						return $url;
				}
			}
		}else {
			return 'admin';
		}
		
		return false;
	}
?>