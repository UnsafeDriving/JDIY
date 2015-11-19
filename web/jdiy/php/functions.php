<?php
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
			return 1;
		}
		
		return false;
	}
	
	function displayPage($id) {
		
		$sql = 'SELECT * 
				FROM pages
				INNER JOIN users
					ON pages.pagUser = users.useId
				WHERE pagId = '.$id;
		$resSql = $GLOBALS["pdo"]->query($sql);
		
		$sqlComments = 'SELECT comText, comDateCreation
					   FROM comments
					   WHERE comPage = '.$id;
					   
		$resSqlComments = $GLOBALS["pdo"]->query($sqlComments);
		
		
		?>
		<! -- SINGLE POST -->
		<div class="col-lg-12" style="text-align:justify">
			<! -- Blog Post 1 -->
			<?php
				foreach($resSql AS $page) {
			?>
					<a href="single-post.html"><h3 class="ctitle"><?php echo $page['pagTitle']; ?></h3></a>
					<p><csmall>Posté: <?php setlocale(LC_TIME, 'fra_fra'); $datetime = new DateTime($page['pagDateCreation']); echo strftime('%d %B %Y',  $datetime->getTimestamp()); ?></csmall> | <csmall>Edité: <?php setlocale(LC_TIME, 'fra_fra'); $datetime = new DateTime($page['pagDateLastUpdate']); echo strftime('%d %B %Y',  $datetime->getTimestamp()); ?></csmall> | <csmall2>Par: <?php echo $page['useFirstName']." ".$page['useLastName'] ?> - <?php echo count($resSqlComments) -1; ?> Comments</csmall2></p>
			<?php
					echo $page['pagContent'];
				}
			?>
			<div class="spacing"></div>
		</div><! --/col-lg-8 -->
		<?php
	}
?>