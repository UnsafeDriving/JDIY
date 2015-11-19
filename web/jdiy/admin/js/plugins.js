// Changer l'état des plugins (on/off)
function changePlugin(name, option) {

	if(option == 'on') {
		option = 1;
	}else if(option == 'off') {
		option = 0;
	}
	
	$.ajax({
        async: false,
        url: "php/sqlPlugins.php",
        type: "POST",
        data: 'pluName='+name+'&pluActive='+option+'&pluAction=edit',
        success: function(data) {
			if(data == 1) {
				alert("Plugin modifié.");
				location.reload(true);
			}else {
				alert("Erreur de modification, réessayez plus tard.");
			}
		},
		error: function(xhr){
			alert("An error occured: " + xhr.status + " " + xhr.statusText);
		}
	});
}