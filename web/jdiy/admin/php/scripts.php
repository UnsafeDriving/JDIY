<?php
	// Ajouter les fichiers javascript au fichier html selon la page
	function addScript($header) {
		switch($header) {
			case 'pages':
				?>
				<script src="js/pages.js" text="text/javascript"></script>
				<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
				<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
				<script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
				<!-- page script -->
				<script type="text/javascript">
					$(function() {
						$('#example2').dataTable({
							"bPaginate": true,
							"bLengthChange": false,
							"bFilter": false,
							"bSort": true,
							"bInfo": true,
							"bAutoWidth": false,
							"oLanguage": {
								"sProcessing":     "Traitement en cours...",
								"sSearch":         "Rechercher&nbsp;:",
								"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
								"sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
								"sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
								"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
								"sInfoPostFix":    "",
								"sLoadingRecords": "Chargement en cours...",
								"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
								"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
								"oPaginate": {
									"sFirst":      "Premier",
									"sPrevious":   "Pr&eacute;c&eacute;dent",
									"sNext":       "Suivant",
									"sLast":       "Dernier"
								},
								"oAria": {
									"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
									"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
								}
							}
						});
					});
					
					
					$("#pagContentAdd").wysihtml5();
					
					var modalTmp = $('#compose-modal').clone();
					
					$('#compose-modal').on('hidden.bs.modal', function (e) {
						$(this).remove();
						var myClone = modalTmp.clone();
						$('#toModal').append(myClone);
					})
				</script>
				<?php
				break;
			case 'users':
				?>
				<script src="js/users.js" text="text/javascript"></script>
				<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
				<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
				<!-- page script -->
				<script type="text/javascript">
					$(function() {
						$('#example2').dataTable({
							"bPaginate": true,
							"bLengthChange": false,
							"bFilter": false,
							"bSort": true,
							"bInfo": true,
							"bAutoWidth": false,
							"oLanguage": {
								"sProcessing":     "Traitement en cours...",
								"sSearch":         "Rechercher&nbsp;:",
								"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
								"sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
								"sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
								"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
								"sInfoPostFix":    "",
								"sLoadingRecords": "Chargement en cours...",
								"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
								"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
								"oPaginate": {
									"sFirst":      "Premier",
									"sPrevious":   "Pr&eacute;c&eacute;dent",
									"sNext":       "Suivant",
									"sLast":       "Dernier"
								},
								"oAria": {
									"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
									"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
								}
							}
						});
					});
				</script>
				<?php
				break;
			case 'menu':
				?>
				<script type="text/javascript" src="js/menudrag/jquery-ui.js"></script>	
				<script type="text/javascript" src="js/menudrag/jquery.js"></script>	
				<script type="text/javascript" src="js/menudrag/jquery-ui-1.8.20.custom.min.js"></script>
				<script type="text/javascript" src="js/menudrag/jquery.ui.nestedSortable.js"></script>
				<script type "text/javascript">
					$(document).ready(function(){
						$('ol.sortable').nestedSortable({
							disableNesting: 'no-nest',
							forcePlaceholderSize: true,
							handle: 'div',
							helper:	'clone',
							items: 'li',
							maxLevels: 2,
							opacity: .6,
							placeholder: 'placeholder',
							revert: 250,
							tabSize: 25,
							tolerance: 'pointer',
							toleranceElement: '> div'
						});
					});
					/*==========================================================================*/
					/* 	Function sérialiser le tableau qui contient le menu
					/*==========================================================================*/	
					function fSerialize() {
						$erreur = 0;
						serialized = $('ol.sortable').nestedSortable('serialize');

						serialized = serialized.split('&');
						nbr = serialized.length;
						
						for (i=0;i<=nbr-1;i++) {
							menPage = serialized[i].substring(serialized[i].indexOf('[')+1,serialized[i].indexOf(']'));
							menParent = serialized[i].substring(serialized[i].indexOf('=')+1);
							if(menParent === 'root') {
								menParent = 0;
							}
							
							$.ajax({
								async: false,
								url: "php/sqlMenu.php",
								type: "POST",
								data: 'menPage='+menPage+'&menParent='+menParent+'&menLevel='+(i+1)+'&menAction=edit',
								success: function(data) {
									if(data != 1 && data != 0) {
										$.fn.jAlert({
											'title':'Modification menu',
											'message': "Erreur de sauvegarde, réessayez plus tard.",
											'theme': 'error',
											'onClose': function(elem){
												location.reload(true);
											}
										});
										$erreur = 1;
									}
								},
								error: function(xhr){
									$.fn.jAlert({
										'title':'Modification menu',
										'message': "An error occured: " + xhr.status + " " + xhr.statusText,
										'theme': 'error',
										'onClose': function(elem){
											location.reload(true);
										}
									});
									$erreur = 1;
								}
							});
							
							if($erreur == 1) {
								break;
							}
						}
						
						if($erreur == 0) {
							$.fn.jAlert({
								'title':'Modification menu',
								'message': "Le menu a été modifié correctement.",
								'theme': 'success',
								'onClose': function(elem){
									location.reload(true);
								}
							});
						}
					}
				</script>
				<?php
				break;
			case 'plugins':
				?>
				<script src="js/plugins.js" text="text/javascript"></script>
				<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
				<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
				<!-- page script -->
				<script type="text/javascript">
					$(function() {
						$('#example2').dataTable({
							"bPaginate": true,
							"bLengthChange": false,
							"bFilter": false,
							"bSort": true,
							"bInfo": true,
							"bAutoWidth": false,
							"oLanguage": {
								"sProcessing":     "Traitement en cours...",
								"sSearch":         "Rechercher&nbsp;:",
								"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
								"sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
								"sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
								"sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
								"sInfoPostFix":    "",
								"sLoadingRecords": "Chargement en cours...",
								"sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
								"sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
								"oPaginate": {
									"sFirst":      "Premier",
									"sPrevious":   "Pr&eacute;c&eacute;dent",
									"sNext":       "Suivant",
									"sLast":       "Dernier"
								},
								"oAria": {
									"sSortAscending":  ": activer pour trier la colonne par ordre croissant",
									"sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
								}
							}
						});
					});
				</script>
				<?php
			case 'admin':
				break;
		}
	}
?>