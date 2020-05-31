// Javascript functions
/*jQuery.noConflict();
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
		    	jQuery( "#submit-registration" ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
		        jQuery( "#loading" ).hide();
		        switch (response) { 
		        	case 'errorDB':
		        	    jQuery( ".error" ).html("Une erreur s'est produite lors de l'insertion des données en base. Veuillez ressayer ou contacter votre administrateur").show().delay(8000).fadeOut();

		        	    break;
		        	case 'errorPwd':
		        	    jQuery( ".error" ).html("Les mots de passe saisis ne sont pas identiques, veuillez ressayer.").show().delay(8000).fadeOut();
		        	    break;
		        	case 'errorMail':
		        	    jQuery( ".info" ).html("L'adresse email que vous avez saisie a existe déjà.").show().delay(8000).fadeOut();
		        	    break;
		        	default:
		        	    jQuery( ".success" ).html("Votre compte a bien été crééé !").show().delay(8000).fadeOut();
		        	    jQuery( "#target-registration" )[0].reset();
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
		        	    jQuery( ".success" ).html("Connexion réussie. Vous serez redirigé sur le portail!").show().delay(8000).fadeOut();
		        	    jQuery( "#target-login" )[0].reset();
		        	    document.location.replace("portail/");
		        }
		    }
        );
        event.preventDefault();
    });

    // Update user info
    jQuery( "#target-update" ).submit(function( event ) {
        jQuery( "#submit-update" ).prop('disabled', true).css({"background-color": "grey", "cursor": "default"});
    	jQuery( "#loading" ).show();
        var data = jQuery( "#target-update" ).serialize();
        jQuery.post(
		    ajaxurl,
		    {
		        'action': 'updateUserInfo',
		        'data': data
		    },
		    function(response){
		    	jQuery( "#submit-update" ).prop('disabled', false).css({"background-color": "black", "cursor": "pointer"});
		        jQuery( "#loading" ).hide();
		        switch (response) { 
		        	case 'error':
		        	    jQuery( ".error" ).html("Une erreur s'est produite lors de la mise à jour de vos données. Veuillez ressayer.").show().delay(8000).fadeOut();
		        	    break;
		        	default:
		        	    jQuery( ".success" ).html("Vos données ont été mises à jours avec succès!").show().delay(3000).fadeOut();
		        }
		    }
        );
        event.preventDefault();
    });

        // Resset password
    jQuery( "#target-reset-password" ).submit(function( event ) {
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
});

*/