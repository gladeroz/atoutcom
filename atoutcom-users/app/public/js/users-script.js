// Javascript functions
jQuery.noConflict();
jQuery( document ).ready(function() {
    jQuery( "#loading" ).css("display", "none");

    jQuery( "#target-registration" ).submit(function( event ) {
    	jQuery( "#submit-registration" ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
    	jQuery( "#loading" ).show();
        var data = jQuery( "#target-registration" ).serialize();
        jQuery.post(
		    ajaxurl,
		    {
		        'action': 'registration',
		        'data': data
		    },
		    function(response){
                var response = JSON.parse(response);
		    	jQuery( "#submit-registration" ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
		        jQuery( "#loading" ).hide();
		        switch (response) { 
		        	case 'errorDB':
		        	    jQuery( ".error" ).html("Une erreur s'est produite lors de l'insertion des données en base. Veuillez ressayer ou contacter votre administrateur").show().delay(10000).fadeOut();

		        	    break;
		        	case 'errorPwd':
		        	    jQuery( ".error" ).html("Les mots de passe saisis ne sont pas identiques, veuillez ressayer.").show().delay(10000).fadeOut();
		        	    break;
                    case 'errorPwdCheck':
                        jQuery( ".error" ).html("Le mot de passe doit comporter au moins 8 caractères et doit inclure au moins une lettre majuscule, un chiffre et un caractère spécial").show().delay(10000).fadeOut();
                        break;
		        	case 'errorMail':
		        	    jQuery( ".info" ).html("L'adresse email que vous avez saisie existe déjà.").show().delay(10000).fadeOut();
		        	    break;
		        	default:
		        	    jQuery( ".success" ).html("Votre compte a bien été créé. Vous serez redirigés vers la page de connexion").show().delay(10000).fadeOut();
		        	    jQuery( "#target-registration" )[0].reset();
		        	    var redirection = response.substr(7);

		        	    if (redirection ==="") {
                            document.location.replace("login/");
		        	    }else{
		        	    	document.location.replace("login/?congres="+redirection);
		        	    }
		        }
		    }
        );
        event.preventDefault();
    });

    // Login function
    jQuery( "#target-login" ).submit(function( event ) {
        
        jQuery( "#submit-login" ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
    	jQuery( "#loading" ).show();
        var data = jQuery( "#target-login" ).serialize();
        jQuery.post(
		    ajaxurl,
		    {
		        'action': 'login',
		        'data': data
		    },
		    function(response){
                var response = JSON.parse(response);
		    	jQuery( "#submit-login" ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
		        jQuery( "#loading" ).hide();

		        switch (response) { 
		        	case 'errorDB':
		        	    jQuery( ".error" ).html("Une erreur inattendue s'est produite. Veuillez ressayer ou contacter votre administrateur").show().delay(8000).fadeOut();

		        	    break;
		        	case 'errorPwd':
		        	    jQuery( ".error" ).html("Votre mot de passe est erronné. Veuillez ressayer.").show().delay(8000).fadeOut();
		        	    break;
		        	case 'errorMail':
		        	    jQuery( ".info" ).html("L'adresse email que vous avez saisie n'existe pas.").show().delay(8000).fadeOut();
		        	    break;
		        	default:
		        	    jQuery( ".success" ).html("Connexion réussie. Vous serez redirigés sur le portail!").show().delay(8000).fadeOut();
		        	    jQuery( "#target-login" )[0].reset();
		        	    var redirection = response.substr(7);
		        	    if (redirection ==="") {
                            document.location.replace("portail/");
		        	    }else{
		        	    	document.location.replace(redirection);
		        	    }
		        }
		    }
        );
        event.preventDefault();
    });

    // Update user info
    jQuery( "#form_updateUserInfo" ).submit(function( event ) {
        event.preventDefault();
        //console.log("hello")
        
        jQuery( "#submit-update" ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
    	jQuery( "#loading" ).show();
        var data = jQuery( "#form_updateUserInfo" ).serialize();
        jQuery.post(
		    ajaxurl,
		    {
		        'action': 'updateUserInfo',
		        'data': data
		    },
		    function(response){
                var response = JSON.parse(response);
		    	jQuery( "#submit-update" ).prop('disabled', false).css({"background-color": "green", "cursor": "pointer"});
		        jQuery( "#loading" ).hide();
		        switch (response) { 
		        	case 'error':
		        	    jQuery( ".error" ).html("Une erreur s'est produite lors de la mise à jour de vos données. Veuillez ressayer.").show().delay(5000).fadeOut();
		        	    break;
		        	default:
		        	    jQuery( ".success" ).html("Vos données ont été mises à jours avec succès!").show().delay(3000).fadeOut();
                        document.location.reload();
		        }
		    }
        );
        
    });

    // Affichage de l'adresse de facturation
    jQuery('#blocAdresseFact').click(function(){
        if(jQuery(this).is(':checked')){
            jQuery( ".blocAdresseFacturation" ).show();
            // Set required fields
            jQuery( ".factRequired" ).prop('required',true);
        } else {
            jQuery( ".blocAdresseFacturation" ).hide();
            jQuery( ".factRequired" ).prop('required',false);
        }
    });
    // Resset password
    jQuery( "#submit-reset-password" ).click(function( event ) {
    	event.preventDefault();
        if( jQuery( "#email" ).val() != "" ){
	        jQuery( "#submit-reset-password" ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
	    	jQuery( "#loading" ).show();
	        var data = jQuery( "#target-reset-password" ).serialize();
	        jQuery.post(
			    ajaxurl,
			    {
			        'action': 'password_resset',
			        'data': data
			    },
			    function(response){
                    var response = JSON.parse(response);
			    	jQuery( "#submit-reset-password" ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
			        jQuery( "#loading" ).hide();
			        switch (response) { 
			        	case 'errorMail':
			        	    jQuery( ".info" ).html("L'identifiant saisi n'existe pas. Vous pouvez réssayer ou créer un nouveau compte.").show().delay(8000).fadeOut();
			        	    break;
			        	case 'errorPassword':
			        	    jQuery( ".info" ).html("Les mots de passe saisis ne sont pas identiques. Veuillez réssayer.").show().delay(8000).fadeOut();
			        	    break;
			        	case 'errorUpdatePassword':
			        	    jQuery( ".error" ).html("Une erreur inattendue s'est produite. Veuillez réssayer.").show().delay(8000).fadeOut();
			        	    break;
			        	case 'errorPasswordVide':
			        	    jQuery( ".error" ).html("Le mot de passe ne peut être vide. Veuillez saisir votre nouveau mot de passe.").show().delay(8000).fadeOut();
			        	    break;
			        	case 'errorRepeatPasswordVide':
			        	    jQuery( ".error" ).html("Veuillez re-saisir votre nouveau mot de passe.").show().delay(8000).fadeOut();
			        	    break;
			        	case 'successUpdatePassword':
			        	    jQuery( ".success" ).html("Votre mot de passe a été réinitialisé avec succès.").show().delay(8000).fadeOut();
			        	    jQuery( ".password" ).hide();
			        	    jQuery( ".login" ).hide();
			        	    jQuery( ".redirection" ).show();
			        	    jQuery( "#submit-reset-password" ).show();
			        	    break;
			        	default:
			        	    jQuery( ".password" ).show();
			        	    jQuery( ".login" ).hide();
			        	    jQuery( "#action" ).val("ok");
			        }
			    }
	        ); 	
        }else{
        	jQuery( ".error" ).html("Veuillez saisir votre adresse email.").show().delay(8000).fadeOut();
        }

    });

    // Resset login
    jQuery( "#target-reset-login" ).submit(function( event ) {
        jQuery( "#submit-reset-login" ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
    	jQuery( "#loading" ).show();
        var data = jQuery( "#target-reset-login" ).serialize();
        jQuery.post(
		    ajaxurl,
		    {
		        'action': 'login_resset',
		        'data': data
		    },
		    function(response){
                var response = JSON.parse(response);
		    	jQuery( "#submit-reset-login" ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
		        jQuery( "#loading" ).hide();
		        switch (response) { 
		        	case 'errorMail':
		        	    jQuery( ".info" ).html("L'identifiant saisi n'existe pas. Vous pouvez réssayer ou créer un nouveau compte.").show().delay(8000).fadeOut();
		        	    break;
		        	case 'errorPassword':
		        	    jQuery( ".info" ).html("Les mots de passe saisis ne sont pas identiques. Veuillez réssayer.").show().delay(8000).fadeOut();
		        	    break;
		        	case 'errorUpdatePassword':
		        	    jQuery( ".error" ).html("Une erreur inattendue s'est produite. Veuillez réssayer.").show().delay(8000).fadeOut();
		        	    break;
		        	case 'successUpdatePassword':
		        	    jQuery( ".success" ).html("Votre mot de passe a été réinitialisé avec succès.").show().delay(8000).fadeOut();
		        	    jQuery( ".password" ).hide();
		        	    jQuery( ".login" ).hide();
		        	    jQuery( ".redirection" ).show();
		        	    jQuery( "#submit-reset-password" ).show();
		        	    break;
		        	default:
		        	    jQuery( ".password" ).show();
		        	    jQuery( ".login" ).hide();
		        	    jQuery( "#action" ).val("ok");
		        }
		    }
        );
        event.preventDefault();
    });
    

    // Upluod fichier
    jQuery( "#submit-fichier1" ).click(function( event ) {
    	event.preventDefault();
    	var identifiant = jQuery(this).attr('id')
    	var indice = identifiant.substr(-1);

        jQuery( "#submit-fichier"+indice ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
    	jQuery( "#loading-fichier"+indice ).show();
 
        var formId = document.getElementById('form-fichier1');
        var formdata = new FormData(formId);

        formdata.append("action", "form_file");
        formdata.append("fichier", "fichier"+indice);
        formdata.append("type", "user");

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            contentType: false,
            processData: false,
            data: formdata,
            success: function(data){
                var data = JSON.parse(data);                  
                jQuery( "#submit-fichier"+indice ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
		        jQuery( "#loading-fichier"+indice ).hide();
                if(data === "success"){
                    jQuery( ".successFile" ).html("Votre fichier a bien été sauvegardé.").show().delay(5000).fadeOut();
                    setTimeout(reloadP(),5000);
                }

                if (data === "errorDB") {
                	jQuery( ".errorFile" ).html("Une erreur s'est produite lors de l'enregistrement de votre fichier. Veuillez réssayer.").show().delay(5000).fadeOut();
                }

                if (data === "UploadNok") {
                	jQuery( ".errorFile" ).html("Une erreur s'est produite lors de l'upload de votre fichier. Veuillez réssayer.").show().delay(5000).fadeOut();
                }

                if (data === "errorExtension") {
                	jQuery( ".errorFile" ).html("L'extension de votre fichier n'est pas valide. Sauf un fichier pdf n'est autorisé.").show().delay(5000).fadeOut();
                }

                if(data === "errorFichierVide") {
                	jQuery( ".errorFile" ).html("Veuillez choisir un fichier.").show().delay(5000).fadeOut();

                }
            }
        });  
    });
    
    // Deconnexion
    jQuery( "#disconnect-tab" ).click( function( event ){
        event.preventDefault();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                "action": "disconnectFunction",
            },
            success: function(response){
                var response = JSON.parse(response); 
                if(response==="success"){
                	document.location.replace("login/");
                }else{
                    document.location.reload();
                }
                
            }
        });

    });

    window.suppressionFichier = function( dataDel ) {
    	//event.preventDefault();
		

    	//var dataDel = jQuery(this).find('.fileDelete').val();
    	var dataDel = dataDel;
    	var n = dataDel.indexOf(",");
        var nomFichier = dataDel.substr(0,n);
    	var id = dataDel.substr(n+1);
    	jQuery('.loadFile'+n).hide();

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                "action": "deleteUserFiles",
                "fichier": nomFichier,
                "id": id,
            },
            success: function(response){
                var response = JSON.parse(response);
		        jQuery('.loadFile'+n).hide();

		        if(response === "success"){
                    jQuery( ".successFile" ).html("Votre fichier a bien été supprimé.").show().delay(5000).fadeOut();
                    setTimeout(reloadP(),5000);
                }

                if (response === "errorDelFile") {
                	jQuery( ".errorFile" ).html("Une erreur s'est produite lors de la suppression de votre fichier. Veuillez réssayer.").show().delay(5000).fadeOut();
                }

                if (response === "errorDB") {
                	jQuery( ".errorFile" ).html("Une erreur s'est produite lors de l'upload de votre fichier. Veuillez réssayer.").show().delay(5000).fadeOut();
                }

            }
        });
    	
    }
    lunchModal();

    // Deplier conférence
    window.deplier = function( id ) {
    	jQuery('.conf_expend_row_w'+id).show( "slow" );
    	jQuery('.moins'+id).show();
    	jQuery('.plus'+id).hide();

    }
    
    // Plier conférence
    window.plier = function( id ) {
    	jQuery('.conf_expend_row_w'+id).hide( "slow" );
    	jQuery('.plus'+id).show();
    	jQuery('.moins'+id).hide();

    }
    
    // Affichage des onglets events-tab documents-tab
    jQuery('#home-tab').click(function(event) {
        jQuery('#home').addClass( "active" );
        jQuery('#events').removeClass( "active" );
        jQuery('#documents').removeClass( "active" );
    });

    jQuery('#events-tab').click(function(event) {
        jQuery('#events').addClass( "active" );
        jQuery('#home').removeClass( "active" );
        jQuery('#documents').removeClass( "active" );
    });

    jQuery('#documents-tab').click(function(event) {
        jQuery('#documents').addClass( "active" );
        jQuery('#home').removeClass( "active" );
        jQuery('#events').removeClass( "active" );
    });
});

// Ouvrir le modal de mise à jour des informations en cas de première conx
function lunchModal() {
	// Vérifier si l'utilisateur a déjà mis à jour ses infos
	if( jQuery('#isUpdate').val() !="yes" ){
		jQuery('#modalProfil').modal('show');
	}
}

function activaTab() {
	jQuery('#documents-tab').trigger('click');
}


window.onload = function() {
    var reloading = sessionStorage.getItem("reloading");
    if (reloading) {
        sessionStorage.removeItem("reloading");
        activaTab();
    }
}

function reloadP() {
    sessionStorage.setItem("reloading", "true");
    document.location.reload();
}
