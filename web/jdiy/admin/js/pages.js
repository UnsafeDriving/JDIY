// Charger une page dans les cases respectives
function loadPage(pageId, pageTitle, pageContent) {
	$('.modal-title').text('Modifier la page');
	$('#pageTitle').val(pageTitle);
	$('#pageContent').val(pageContent);
	$('#dialog-save').attr('onclick', 'modifyPage("'+pageId+'")');
	$("#pageContent").wysihtml5();
}

// AJouter une nouvelle page
function addPage() {
	if($('#pagTitleAdd').val() == "" || $('#pagContentAdd').val() == "") {
		$.fn.jAlert({
			'title':'Ajout page',
			'message': "Veuillez remplir tous les champs!",
			'theme': 'error'
		});
		return -1;
	}
	$.ajax({
        async: false,
        url: "php/sqlPages.php",
        type: "POST",
        data: 'pageTitle='+$('#pagTitleAdd').val()+'&pageContent='+$('#pagContentAdd').val()+'&pageAction=add',
        success: function(data) {
			if(data == 1) {
				$.fn.jAlert({
					'title':'Ajout page',
					'message': "La page a été ajoutée correctement.",
					'theme': 'success',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}else {
				$.fn.jAlert({
					'title':'Ajout page',
					'message': "Erreur d'ajout, réessayez plus tard.",
					'theme': 'error',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}
		},
		error: function(xhr){
			$.fn.jAlert({
				'title':'Ajout page',
				'message': "An error occured: " + xhr.status + " " + xhr.statusText,
				'theme': 'error',
				'onClose': function(elem){
					location.reload(true);
				}
			});
		}
	});
}

// Supprimer un page
function deletePage(pageId) {
	$.ajax({
        async: false,
        url: "php/sqlPages.php",
        type: "POST",
        data: 'pageId='+pageId+'&pageAction=del',
        success: function(data) {
			if(data == 1) {
				$.fn.jAlert({
					'title':'Suppression page',
					'message': "La page a été supprimée correctement.",
					'theme': 'success',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}else {
				$.fn.jAlert({
					'title':'Suppression page',
					'message': "Erreur de suppression, réessayez plus tard.",
					'theme': 'error',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}
		},
		error: function(xhr){
			$.fn.jAlert({
				'title':'Suppression page',
				'message': "An error occured: " + xhr.status + " " + xhr.statusText,
				'theme': 'error',
				'onClose': function(elem){
					location.reload(true);
				}
			});
		}
	});
}

// Modifer une page
function modifyPage(pageId) {
	pageTitle = $('#pageTitle').val();
	pageContent = $('#pageContent').val();
	
	$.ajax({
        async: false,
        url: "php/sqlPages.php",
        type: "POST",
        data: 'pageId='+pageId+'&pageTitle='+pageTitle+'&pageContent='+pageContent+'&pageAction=edit',
        success: function(data) {
			if(data == 1) {
				$('#dialog-save').addClass('disabled');
				$('#dialog-save').text("Page modifiéé.");
				$('#dialog-save').removeClass('btn-primary');
				$('#dialog-save').addClass('btn-success');		
			}else {
				$('#dialog-save').addClass('disabled');
				$('#dialog-save').text("Erreur de sauvegarde, réessayez plus tard.");
				$('#dialog-save').removeClass('btn-primary');
				$('#dialog-save').addClass('btn-danger');
			}
		},
		error: function(xhr){
			$.fn.jAlert({
				'title':'Modification page',
				'message': "An error occured: " + xhr.status + " " + xhr.statusText,
				'theme': 'error',
				'onClose': function(elem){
					location.reload(true);
				}
			});
		}
	});
}