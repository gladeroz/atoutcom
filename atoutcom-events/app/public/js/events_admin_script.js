// Javascript functions
/*jQuery.noConflict();
jQuery( document ).ready(function() {

    jQuery( "#loading" ).css("display", "none");

    jQuery( "#target-createEvent" ).submit(function( event ) {
    	jQuery( "#submit-createEvent" ).prop('disabled', true);
    	jQuery( "#loading" ).show();
        var data = jQuery( "#target-createEvent" ).serialize();
        jQuery.post(
		    ajaxurl,
		    {
		        'action': 'createEvent',
		        'data': data
		    },
		    function(response){
		    	jQuery( "#submit-createEvent" ).prop('disabled', false);
		        jQuery( "#loading" ).hide();
		        
		        if(response==="success"){
                    jQuery( ".success" ).html("Votre évenement a bien été crééé avec succès !").show().delay(5000).fadeOut();
		        }

		        if (response==="errorDB") {
		        	jQuery( ".error" ).html("Une erreur s'est produite lors de l'insertion des données. Veuillez ressayer.").show().delay(5000).fadeOut();
		        }

		        if (response==="errorEventExist") {
		        	jQuery( ".info" ).html("Cet évenement a déjà été crééé. Merci de créer un autre.").show().delay(5000).fadeOut();
		        }
		        jQuery( "#target-createEvent" )[0].reset();
		    }
        );
        event.preventDefault();
    });
    


});*/


