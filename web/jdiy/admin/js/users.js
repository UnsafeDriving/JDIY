// Charger un utilisateur
function loadUser(useId, useFirstName, useLastName, useEmail, useGroupId) {
	$('.modal-title').text('Modifier l\'utilisateur');
	$('#useFirstName').val(useFirstName);
	$('#useLastName').val(useLastName);
	$('#useEmail').val(useEmail);
	$('#useGroup option[value="'+useGroupId+'"]').prop('selected', true);
	$('#dialog-save').attr('onclick', 'modifyUser("'+useId+'", "'+useGroupId+'")');
}

// Ajouter un utilisateur
function addUser() {
	if($('#useFirstNameAdd').val() == "" || $('#useLastNameAdd').val() == "" || $('#useEmailAdd').val() == "" || $('#usePasswordAdd').val() == "") {
		$.fn.jAlert({
			'title':'Ajout utilisateur',
			'message': "Veuillez remplir tous les champs!",
			'theme': 'error'
		});
		return -1;
	}
	$.ajax({
        async: false,
        url: "php/sqlUsers.php",
        type: "POST",
        data: 'useFirstName='+$('#useFirstNameAdd').val()+'&useLastName='+$('#useLastNameAdd').val()+'&useEmail='+$('#useEmailAdd').val()+'&usePassword='+$('#usePasswordAdd').val()+'&useGroupId='+$('#useGroupAdd').val()+'&useAction=add',
        success: function(data) {
			if(data == 1) {
				$.fn.jAlert({
					'title':'Ajout utilisateur',
					'message': "L'utilisateur a été ajouté correctement.",
					'theme': 'success',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}else if(data == -1) {
				$.fn.jAlert({
					'title':'Ajout utilisateur',
					'message': "Erreur d'ajout, vous n'avez pas les droits.",
					'theme': 'error',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}else {
				$.fn.jAlert({
					'title':'Ajout utilisateur',
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
				'title':'Ajout utilisateur',
				'message': "An error occured: " + xhr.status + " " + xhr.statusText,
				'theme': 'error',
				'onClose': function(elem){
					location.reload(true);
				}
			});
		}
	});
}

// Supprimer un utilisateur
function deleteUser(useId) {
	$.ajax({
        async: false,
        url: "php/sqlUsers.php",
        type: "POST",
        data: 'useId='+useId+'&useAction=del',
        success: function(data) {
			if(data == 1) {
				$.fn.jAlert({
					'title':'Suppression utilisateur',
					'message': "L'utilisateur a été supprimé correctement.",
					'theme': 'success',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}else if(data == -1) {
				$.fn.jAlert({
					'title':'Suppression utilisateur',
					'message': "Erreur de suppression, vous n'avez pas les droits.",
					'theme': 'error',
					'onClose': function(elem){
						location.reload(true);
					}
				});
			}else {
				$.fn.jAlert({
					'title':'Suppression utilisateur',
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
				'title':'Suppression utilisateur',
				'message': "An error occured: " + xhr.status + " " + xhr.statusText,
				'theme': 'error',
				'onClose': function(elem){
					location.reload(true);
				}
			});
		}
	});
}
// Modifier un utilisateur
function modifyUser(useId, oldGroupId) {
	useFirstName = $('#useFirstName').val();
	useLastName = $('#useLastName').val();
	useEmail = $('#useEmail').val();
	useGroupId = $('#useGroup').val();
	
	$.ajax({
        async: false,
        url: "php/sqlUsers.php",
        type: "POST",
        data: 'useId='+useId+'&useFirstName='+useFirstName+'&useLastName='+useLastName+'&useEmail='+useEmail+'&useGroupId='+useGroupId+'&oldGroupId='+oldGroupId+'&useAction=edit',
        success: function(data) {
			if(data == 1) {
				$('#dialog-save').addClass('disabled');
				$('#dialog-save').text("Utilisateur modifiéé.");
				$('#dialog-save').removeClass('btn-primary');
				$('#dialog-save').addClass('btn-success');		
			}else if(data == -1) {
				$('#dialog-save').addClass('disabled');
				$('#dialog-save').text("Erreur de modification, vous n'avez pas les droits.");
				$('#dialog-save').removeClass('btn-primary');
				$('#dialog-save').addClass('btn-danger');
			}else {
				$('#dialog-save').addClass('disabled');
				$('#dialog-save').text("Erreur de sauvegarde, réessayez plus tard.");
				$('#dialog-save').removeClass('btn-primary');
				$('#dialog-save').addClass('btn-danger');
			}
		},
		error: function(xhr){
			$.fn.jAlert({
				'title':'Modification utilisateur',
				'message': "An error occured: " + xhr.status + " " + xhr.statusText,
				'theme': 'error',
				'onClose': function(elem){
					location.reload(true);
				}
			});
		}
	});
}