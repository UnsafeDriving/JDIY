<?php
	// Afficher le contenu de la page selon l'url
	function display($toDisplay) {
		switch($toDisplay) {
			case 'pages':
				displayPages();
				break;
			case 'users':
				displayUsers();
				break;
			case 'admin':
				break;
			case 'menu':
				displayMenu();
				break;
			case 'plugins':
				displayPlugins();
				break;
			default:
				display404();
				break;
		}		
	}
	
	function displayPages() {
		?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1> Pages <small>Panneau de contrôle</small> </h1>
		  <ol class="breadcrumb">
			<li><a href="../admin.php"><i class="fa fa-dashboard"></i> Tableau de bord</a></li>
			<li class="active">Pages</li>
		  </ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
		
		
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Modifier une page</h3>
						</div><!-- /.box-header -->
						<div id="pageMessage"></div>
						<div class="box-body table-responsive">
							<table id="example2" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Titre</th>
										<th class="col-xs-1">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$pages = getPages();
										foreach($pages AS $page) {
											echo '<tr>';
											echo 	'<td>';
											echo 		$page['pagTitle'];
											echo 	'</td>';
											echo 	'<td>';
											echo		'<a class="btn btn-primary btn-flat col-xs-6" onclick="loadPage(\''.$page['pagId'].'\', \''.$page['pagTitle'].'\',\''.htmlspecialchars($page['pagContent']).'\')" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i></a>';
											echo		'<a class="btn btn-danger btn-flat col-xs-6" onclick="deletePage(\''.$page['pagId'].'\')"><i class="fa fa-close"></i></a>';
											//echo 		htmlspecialchars($page['pagContent']);
											echo 	'</td>';
											echo '</tr>';
										}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th>Titre</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Ajouter une page</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Titre:</span>
									<input name="pagTitleAdd" id="pagTitleAdd" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<textarea name="pagContentAdd" id="pagContentAdd" class="form-control" style="height: 310px;"></textarea>
							</div>
						</div>
						<div class="modal-footer clearfix">
							<button id="addUser-save" type="button" class="btn btn-flat btn-primary pull-left" onclick="addPage()"><i class="fa fa-plus"></i> Ajouter</button>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /.content --> 
		<!-- COMPOSE MESSAGE MODAL -->
		<div id="toModal">
			<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-envelope-o"></i> Modifier page</h4>
						</div>
						<form action="#" method="post">
							<div class="modal-body">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon">Title:</span>
										<input name="pageTitle" id="pageTitle" type="text" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<textarea name="pageContent" id="pageContent" class="form-control" style="height: 310px;"></textarea>
								</div>

							</div>
							<div class="modal-footer clearfix">

								<button id="dialog-close" type="button" class="btn btn-flat btn-danger" data-dismiss="modal" onclick="location.reload(true)"><i class="fa fa-times"></i> Fermer</button>
								<button id="dialog-save" type="button" class="btn btn-flat btn-primary pull-left"><i class="fa fa-save"></i> Sauvegarder</button>
							</div>
						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>

		<?php
	}
	
	function display404() {
		?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Page Introuvable
			</h1>
			<!--<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Examples</a></li>
				<li class="active">404 error</li>
			</ol>-->
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="error-page">
				<h2 class="headline text-info"> 404</h2>
				<div class="error-content">
					<h3><i class="fa fa-warning text-yellow"></i> Oops! Page introuvable!</h3>
					<p>
						La page que vous avez demandée n'existe pas.
						<a href='admin.php'>Revenir sur le tableau de bord.</a>								<!--or try using the search form. -->
					</p>
					<!--<form class='search-form'>
						<div class='input-group'>
							<input type="text" name="search" class='form-control' placeholder="Search"/>
							<div class="input-group-btn">
								<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
							</div>
						</div><!-- /.input-group -->
					<!--</form>-->
				</div><!-- /.error-content -->
			</div><!-- /.error-page -->

		</section><!-- /.content -->
		<?php
	}
	
	function displayMenu() {
		?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1> Menu <small>Panneau de contrôle</small> </h1>
			<ol class="breadcrumb">
				<li><a href="../admin.php"><i class="fa fa-dashboard"></i> Tableau de bord</a></li>
				<li class="active">Menu</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Modifier le menu</h3>
						</div><!-- /.box-header -->
						<div id="pageMessage"></div>
						<div class="box-body">
							<?php
								$sql = 'SELECT menPage FROM menu WHERE menParent IS NULL ORDER BY menLevel';
								$sqlp = $GLOBALS["pdo"]->query($sql);
								$menusroot = $sqlp->fetchAll();
								
								$level1 = 1;
								$level2 = 1;
								$level3 = 1;
								
								$nbRows = 0;
								
								if(count($menusroot) <= 0) {
									echo 'Aucune donnée disponible.';
								}
								
								echo '<ol class="sortable">';
								foreach($menusroot as $amenuroot){
									$i = 1;
									foreach($amenuroot as $menuroot){
										if($i&1) {
											$sql = 'SELECT pagTitle FROM pages WHERE pagId = '.$menuroot;
											$sqlp = $GLOBALS["pdo"]->query($sql);
											$name = $sqlp->fetch();
											
											$nbRows++;
											echo '<li id="list_'.$menuroot.'"><div>'.$name['pagTitle'].'</div>';
											echo '<ol>';

											$sql = 'SELECT menPage FROM menu WHERE menParent = '.$menuroot.' ORDER BY menLevel';
											$sqlp = $GLOBALS["pdo"]->query($sql);
											$menuschild = $sqlp->fetchAll();
											
											foreach($menuschild as $amenuchild){
												$j = 1;
												foreach($amenuchild as $menuchild){
													if($j&1) {
														$sql = 'SELECT pagTitle FROM pages WHERE pagId = '.$menuchild;
														$sqlp = $GLOBALS["pdo"]->query($sql);
														$name = $sqlp->fetch();
														
														$nbRows++;
														echo '<li id="list_'.$menuchild.'"><div>'.$name['pagTitle'].'</div>';
														echo '<ol>';
														
														$sql = 'SELECT menPage FROM menu WHERE menParent = '.$menuchild.' ORDER BY menLevel';
														$sqlp = $GLOBALS["pdo"]->query($sql);
														$menuschildchild = $sqlp->fetchAll();
														
														foreach($menuschildchild as $amenuchildchild){
															$k = 1;
															foreach($amenuchildchild as $menuchildchild){
																if($k&1) {
																	$sql = 'SELECT pagTitle FROM pages WHERE pagId = '.$menuchildchild;
																	$sqlp = $GLOBALS["pdo"]->query($sql);
																	$name = $sqlp->fetch();
																
																	$nbRows++;
																	echo '<li id="list_'.$menuchildchild.'"><div>'.$name['pagTitle'].'</div></li>';
																}
																$k++;
															}
														}
														echo '</ol></li>';
													}
													$j++;
												}
											}
											
											echo '</ol></li>';
											
										}
										$i++;
										$level2++;
									}
								}
								echo '</ol>';
							//==============================================================================================================
							?>
							<br>
						</div>
						<div class="modal-footer clearfix">
							<?php
							if(count($menusroot) > 0) {
							?>
								<button id="updateMenu" type="button" class="btn btn-flat btn-primary pull-left" onclick="javascript:fSerialize();"><i class="fa fa-save"></i> Sauvegarder</button>
							<?php
							}else {
							?>
								<button id="updateMenu" type="button" class="btn btn-flat btn-primary pull-left disabled"><i class="fa fa-save"></i> Sauvegarder</button>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>

		</section><!-- /.content -->
		<?php
	}
	
	function displayUsers() {
		?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1> Utilisateurs <small>Panneau de contrôle</small> </h1>
		  <ol class="breadcrumb">
			<li><a href="../admin.php"><i class="fa fa-dashboard"></i> Tableau de bord</a></li>
			<li class="active">Utilisateurs</li>
		  </ol>
		</section>
		
		<!-- Main content -->
		<section class="content">
		
		
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Modifier un utilisateur</h3>
						</div><!-- /.box-header -->
						<div id="pageMessage"></div>
						<div class="box-body table-responsive">
							<table id="example2" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Prénom</th>
                                        <th>Nom</th>
                                        <th>E-mail</th>
                                        <th>Groupe</th>
										<th class="col-xs-1">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$users = getUsers();
										foreach($users AS $user) {
											?>
											<tr>
												<td><?php echo $user['useFirstName']; ?></td>
                                                <td><?php echo $user['useLastName']; ?></td>
                                                <td><?php echo $user['useEmail']; ?></td>
                                                <td><?php echo $user['useGroup']; ?></td>
												<td>
													<a class="btn btn-primary btn-flat col-xs-6" onclick="loadUser('<?php echo $user['useId']; ?>','<?php echo $user['useFirstName']; ?>','<?php echo $user['useLastName']; ?>','<?php echo $user['useEmail']; ?>','<?php echo $user['useGroupId']; ?>')" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i></a>
													<?php
													if($_SESSION['userId'] != $user['useId']) {
														?>
															<a class="btn btn-danger btn-flat col-xs-6" onclick="deleteUser('<?php echo $user['useId']; ?>')"><i class="fa fa-close"></i></a>
														<?php
													}else {
														?>
															<a class="btn btn-danger btn-flat col-xs-6 disabled"><i class="fa fa-close"></i></a>
														<?php
													}
													?>
												</td>
											</tr>
                                            <?php
										}
									?>
								</tbody>
								<tfoot>
									<tr>
										<th>Prénom</th>
                                        <th>Nom</th>
                                        <th>E-mail</th>
                                        <th>Groupe</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Ajouter un utilisateur</h3>
						</div><!-- /.box-header -->
						<div class="box-body">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Prénom:</span>
									<input name="useFirstNameAdd" id="useFirstNameAdd" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Nom:</span>
									<input name="useLastNameAdd" id="useLastNameAdd" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">E-mail:</span>
									<input name="useEmailAdd" id="useEmailAdd" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Mot de passe:</span>
									<input name="usePasswordAdd" id="usePasswordAdd" type="password" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Groupe:</span>
									<select name="useGroupAdd" id="useGroupAdd" class="form-control">
										<?php
											$groups = getGroups();
											foreach($groups AS $group) {
										?>
										<option value="<?php echo $group['groId']; ?>"><?php echo $group['groType']; ?></option>
										<?php
											}
										?>
									</select>	
								</div>
							</div>
						</div>
						<div class="modal-footer clearfix">
							<button id="addUser-save" type="button" class="btn btn-flat btn-primary pull-left" onclick="addUser()"><i class="fa  fa-plus"></i> Ajouter</button>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- /.content --> 
		<!-- COMPOSE MESSAGE MODAL -->
		<div id="toModal">
			<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-envelope-o"></i> Modifier page</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Prénom:</span>
									<input name="useFirstName" id="useFirstName" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Nom:</span>
									<input name="useLastName" id="useLastName" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">E-mail:</span>
									<input name="useEmail" id="useEmail" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">Groupe:</span>
									<select name="useGroup" id="useGroup" class="form-control">
										<?php
											$groups = getGroups();
											foreach($groups AS $group) {
										?>
										<option value="<?php echo $group['groId']; ?>"><?php echo $group['groType']; ?></option>
										<?php
											}
										?>
									</select>	
								</div>
							</div>
						</div>
						<div class="modal-footer clearfix">

							<button id="dialog-close" type="button" class="btn btn-flat btn-danger" data-dismiss="modal" onclick="location.reload(true)"><i class="fa fa-times"></i> Fermer</button>
							<button id="dialog-save" type="button" class="btn btn-flat btn-primary pull-left"><i class="fa fa-save"></i> Sauvegarder</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>

		<?php
	}
	
	function displayPlugins() {
		?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1> Plugins <small>Panneau de contrôle</small> </h1>
			<ol class="breadcrumb">
				<li><a href="../admin.php"><i class="fa fa-dashboard"></i> Tableau de bord</a></li>
				<li class="active">Plugins</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Gérer les plugins</h3>
						</div><!-- /.box-header -->
						<div id="pageMessage"></div>
						<div class="box-body">
							<div class="box-body table-responsive">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th class="col-xs-2">Nom</th>
											<th class="col-xs-7">Description</th>
											<th class="col-xs-1">Version</th>
											<th class="col-xs-1">État</h1>
											<th class="col-xs-1">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$plugins = getPlugins();
											foreach($plugins AS $plugin) {
												?>
												<tr>
													<td><?php echo $plugin['pluName']; ?></td>
													<td><?php echo $plugin['pluDescription']; ?></td>
													<td><?php echo $plugin['pluVersion']; ?></td>
													<td>
														<?php
															if($plugin['pluActive'] == true) { echo 'Activé'; }
															else { echo 'Desactivé'; }
														?>
													</td>
													<td>
														<?php
															if($plugin['pluActive'] == true) {
																?>
																<a class="btn btn-danger btn-flat col-xs-12" onclick="changePlugin('<?php echo $plugin['pluName']; ?>','off')"><i class="fa fa-power-off"></i></a>
																<?php
															}else {
																?>
																<a class="btn btn-success btn-flat col-xs-12" onclick="changePlugin('<?php echo $plugin['pluName']; ?>','on')"><i class="fa fa-power-off"></i></a>
																<?php
															}
														?>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<th>Nom</th>
											<th>Description</th>
											<th>Version</th>
											<th>État</h1>
											<th class="col-xs-1">Actions</th>
										</tr>
									</tfoot>
								</table>
							</div><!-- /.box-body -->
						</div>
					</div>
				</div>
			</div>

		</section><!-- /.content -->
		<?php
	}
	
?>