// Javascript functions
jQuery.noConflict();
jQuery( document ).ready(function() {
    /****************************AFFICHAGE DES UTILISATEURS**********************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/
    jQuery.post(
	    ajaxurl,
	    {
	        'action': 'users_manage',
	    },
	    function(response){

            var data_ret = JSON.parse(response);

            if(data_ret && data_ret.length != 0){
            	for (var i = 0; i < data_ret.length; i++) {
            		var nom = data_ret[i]['Nom'];
            		var prenom = data_ret[i]['Prenom'];
            		var email = data_ret[i]['Email'];
            		var adresse = (data_ret[i]['Adresse'] ===null) ? "" : data_ret[i]['Adresse'];
            		var codepostal = (data_ret[i]['CodePostal'] ===null) ? "" : data_ret[i]['CodePostal'];
            		var ville = (data_ret[i]['Ville'] ===null) ? "" : data_ret[i]['Ville'];
            		var telephoneProfessionnel = (data_ret[i]['TelephoneProfessionnel'] ===null) ? "" : data_ret[i]['TelephoneProfessionnel'];
            		var date_inscription = (data_ret[i]['DateInscription'] ===null) ? "" : data_ret[i]['DateInscription'];
            		var pays = (data_ret[i]['Pays'] ===null) ? "" : data_ret[i]['Pays'];
            		var profil = (data_ret[i]['Profil'] ===null) ? "" : data_ret[i]['Profil'];
            		var userFile = (data_ret[i]['userFile'] ===null) ? "" : data_ret[i]['userFile'];

            		var data =

            		"<tr>"
					+   "<td class='details-control'><i class='fa fa-plus-square' aria-hidden='true'></i></td>"
					+   "<td>"+nom+"</td>"
					+   "<td>"+prenom+"</td>"
					+   "<td>"+email+"</td>"
					+   "<td>"+adresse+"</td>"
					+   "<td>"+codepostal+"</td>"
					+   "<td>"+ville+"</td>"
					+   "<td>"+pays+"</td>"
					+   "<td>"+telephoneProfessionnel+"</td>"
					+   "<td>"+date_inscription+"</td>"
					+   "<td>"+profil+"</td>"
					+   "<td style='display:none;'>"+userFile+"</td>"
					+"</tr>";
            		jQuery('#bodyUser').append(data);
            	}
            }
	        
            var table = jQuery('#manage_users').DataTable({
		        "order": [1, "asc"],
				responsive: true,
				"lengthMenu": [25, 50, 75, 100, 150],
				"language": {
					"sProcessing":     "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucune inscription",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ inscrits)",
					"infoEmpty": "0 à 0 (0 inscription)",
				},
		    });
            
            jQuery("#manage_users").show();
	        jQuery("#loadingUsers").hide();

		    jQuery("#bodyUser").on("click", "td.details-control", function () {
		        var tr = jQuery(this).closest("tr");
		        var tdi = tr.find("i.fa");
		        var row = table.row(tr);

		        if (row.child.isShown()) {
		            // This row is already open - close it
		            row.child.hide();
		            tr.removeClass("shown");
		            tdi.first().removeClass("fa-minus-square");
		            tdi.first().addClass("fa-plus-square");
		        }
		        else{
		            // Open this row
		            row.child(user_format(row.data())).show();
		            tr.addClass("shown");
		            tdi.first().removeClass("fa-plus-square");
		            tdi.first().addClass("fa-minus-square");
		        }
		    });
	    }
    );


    /****************************LISTE DES EVENEMENTS****************************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/

    jQuery.post(
	    ajaxurl,
	    {
	        'action': 'events_manage',
	    },
	    function(response){

            var data_ret = JSON.parse(response);
            //console.log(response);

            if(data_ret && data_ret.length != 0){
            	for (var i = 0; i < data_ret.length; i++) {
            		var organisateur = data_ret[i]['organisateur'];
            		var titre = data_ret[i]['titre'];
            		var specialite = data_ret[i]['specialite'];
            		var pays = (data_ret[i]['pays'] ===null) ? "" : data_ret[i]['pays'];
            		var adresse = (data_ret[i]['adresse'] ===null) ? "" : data_ret[i]['adresse'];
            		var codepostal = (data_ret[i]['codepostal'] ===null) ? "" : data_ret[i]['codepostal'];
            		var ville = (data_ret[i]['ville'] ===null) ? "" : data_ret[i]['ville'];
            		var date_evenement = (data_ret[i]['date_evenement'] ===null) ? "" : data_ret[i]['date_evenement'];

            		var data =

            		"<tr>"
					+   "<td class='details-control'><i class='fa fa-plus-square' aria-hidden='true'></i></td>"
					+   "<td>"+titre+"</td>"
					+   "<td>"+specialite+"</td>"
					+   "<td>"+date_evenement+"</td>"
					+   "<td>"+ville+"</td>"
					+   "<td>"+adresse+"</td>"
					+   "<td>"+codepostal+"</td>"
					+   "<td>"+ville+"</td>"
					+   "<td>"+pays+"</td>"
					+"</tr>";
            		jQuery('#bodyEvent').append(data);
            	}
            }
	        
            var table = jQuery('#list_events').DataTable({
		        "order": [1, "asc"],
				responsive: true,
				"lengthMenu": [25, 50, 75, 100, 150],
				"language": {
					"sProcessing":     "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucun évenement",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ évenement(s))",
					"infoEmpty": " 0 ( Evenement )",
				},
		    });
            
            jQuery("#list_events").show();
	        jQuery("#loadingEvents").hide();

		    jQuery("#bodyEvent").on("click", "td.details-control", function () {
		        var tr = jQuery(this).closest("tr");
		        var tdi = tr.find("i.fa");
		        var row = table.row(tr);

		        if (row.child.isShown()) {
		            // This row is already open - close it
		            row.child.hide();
		            tr.removeClass("shown");
		            tdi.first().removeClass("fa-minus-square");
		            tdi.first().addClass("fa-plus-square");
		        }
		        else{
		            // Open this row
		            row.child(event_format(row.data())).show();
		            tr.addClass("shown");
		            tdi.first().removeClass("fa-plus-square");
		            tdi.first().addClass("fa-minus-square");
		        }
		    });
	    }
    );


    /****************************LISTE DES PARTICIPANTS**************************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/
    jQuery.post(
	    ajaxurl,
	    {
	        'action': 'user_events',
	    },
	    function(response){
            
            var data_ret = JSON.parse(response);
            if(data_ret && data_ret.length != 0){
            	for(var i in data_ret){
            		var evenement = data_ret[i]['evenement'];
            		var nom = data_ret[i]['nom'];
            		var prenom = data_ret[i]['prenom'];
            		var email = data_ret[i]['email'];
            		var adresse = (data_ret[i]['adresseUser'] ===null) ? "" : data_ret[i]['adresseUser'];
            		var codepostal = (data_ret[i]['codepostalUser'] ===null) ? "" : data_ret[i]['codepostalUser'];
            		var ville = (data_ret[i]['villeUser'] ===null) ? "" : data_ret[i]['villeUser'];
            		var pays = (data_ret[i]['paysUser'] ===null) ? "" : data_ret[i]['paysUser'];
            		var telephone = (data_ret[i]['telephone'] ===null) ? "" : data_ret[i]['telephone'];
            		var transaction_id = (data_ret[i]['transaction_id'] ===null) ? "" : data_ret[i]['transaction_id'];
            		var payment_status = (data_ret[i]['payment_status'] ===null) ? "" : data_ret[i]['payment_status'];
            		var entry_id = data_ret[i]['entry_id'];
            		var form_id = data_ret[i]['form_id'];
            		var status = (data_ret[i]['status'] ===null) ? "" : data_ret[i]['status'];
            		var modeReglement = (data_ret[i]['payment_mode'] ===null) ? "" : data_ret[i]['payment_mode']; //todo
            		var datePaiement = (data_ret[i]['payment_date'] ===null) ? "" : data_ret[i]['payment_date']; //todo

            		var data =

            		"<tr>"
					+   "<td class='details-control'><i class='fa fa-plus-square' aria-hidden='true'></i></td>"
					+   "<td>"+evenement+"</td>"
					+   "<td>"+nom+"</td>"
					+   "<td>"+prenom+"</td>"
					+   "<td>"+email+"</td>"
					+   "<td>"+adresse+"</td>"
					+   "<td>"+codepostal+"</td>"
					+   "<td>"+ville+"</td>"
					+   "<td>"+pays+"</td>"
					+   "<td>"+telephone+"</td>"
					+   "<td>"+transaction_id+"</td>"
					+   "<td>"+payment_status+"</td>"
					+   "<td style='display:none;'>"+entry_id+"</td>" 
					+   "<td style='display:none;'>"+form_id+"</td>"
					+   "<td>"+status+"</td>"
					+   "<td>"+modeReglement+"</td>"
					+   "<td>"+datePaiement+"</td>"
					+"</tr>";
            		jQuery('#bodyUserEvent').append(data);
            	}
            }
	        
            var tableParticipant = jQuery('#tableParticipant').DataTable({
		        "order": [1, "asc"],
				"lengthMenu": [25, 50, 75, 100, 150],
				"language": {
					"sProcessing":     "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucun participant",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ participant(s))",
					"infoEmpty": " 0 ( Participant )",
					"sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
				},
		    });
            
            
	        jQuery("#loadingParticipant").hide();
	        jQuery(".list_participant").show();

		    jQuery("#bodyUserEvent").on("click", "td.details-control", function () {
		        var tr = jQuery(this).closest("tr");
		        var tdi = tr.find("i.fa");
		        var row = tableParticipant.row(tr);

		        if (row.child.isShown()) {
		            // This row is already open - close it
		            row.child.hide();
		            tr.removeClass("shown");
		            tdi.first().removeClass("fa-minus-square");
		            tdi.first().addClass("fa-plus-square");
		        }
		        else{
		            // Open this row
		            row.child(user_event_format(row.data())).show();
		            tr.addClass("shown");
		            tdi.first().removeClass("fa-plus-square");
		            tdi.first().addClass("fa-minus-square");
		        }
		    });

		    jQuery("#exportExcelListeParticipant").click(function() {
		    	var donnee = tableParticipant.rows( {page:'current'} ).data();
		    	var donneeTab = [];
		    	for(var i=0; i<donnee.length; i++){
                    donneeTab.push(donnee[i]);
		    	}
		    	donneeTab = JSON.stringify(donneeTab);
		    	exportDataExcel("", donneeTab, "exportExcelListeParticipant");
		    });
	    }
    );

    /****************************AFFICHAGE FACTURE PARTICIPANTS******************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/

    var jqxhr = jQuery.post(
        ajaxurl,
	    {
	        'action': 'getFacture',
	        'data': 'participant',
	    },
	    function(response){
	    	var response = JSON.parse(response);
	    	if(response !=""){
	            var data = response;
	            if(Object.keys(data).length != 0){
	            	for(var i in data){
	            		var id = data[i]['id'];
	            		var periode = data[i]['periode'];
	            		var numero = data[i]['numero'];
	            		var date_facture = data[i]['date_facture'];
	            		var destinataire = data[i]['destinataire'];
	            		var intitule = data[i]['intitule'];
	            		var annee = data[i]['annee'];
	            		var montantHT = data[i]['montantHT']
	            		var aka_tauxTVA = data[i]['aka_tauxTVA'];
	            		var montantTVA = data[i]['montantTVA'];
	            		var montantTTC = data[i]['montantTTC'];
	            		var montantNET = data[i]['montantNET'];
	            		var total = data[i]['total'];
	            		var accompte = data[i]['accompte'];
	            		var restedu = data[i]['restedu'];
	            		var paye = data[i]['paye'];
	            		var encaisse = data[i]['encaisse'];
	            		var date_reglement = data[i]['date_reglement'];
	            		var commentaire = data[i]['commentaire'];
	            		var concerne = data[i]['concerne'];

	            		var dataTable =

	            		"<tr>"
						+   "<td class='details-control'><input type='checkbox' class='checkForExport' value='"+id+"'</td>"
						+   "<td>"+periode+"</td>"
						+   "<td>"+numero+"</td>"
						+   "<td>"+date_facture+"</td>"
						+   "<td>"+destinataire+"</td>"
						+   "<td>"+intitule+"</td>"
						+   "<td>"+annee+"</td>"
						+   "<td>"+montantHT+"</td>"
						+   "<td>"+aka_tauxTVA+"</td>"
						+   "<td>"+montantTVA+"</td>"
						+   "<td>"+montantTTC+"</td>"
						+   "<td>"+montantNET+"</td>"
						+   "<td>"+total+"</td>"
						+   "<td>"+accompte+"</td>"
						+   "<td>"+restedu+"</td>"
						+   "<td>"+paye+"</td>"
						+   "<td>"+encaisse+"</td>"
						+   "<td>"+date_reglement+"</td>"
						+   "<td>"+commentaire+"</td>"
						+   "<td>"+concerne+"</td>"
						+"</tr>";
	            		jQuery('#tableFactureParticipant').append(dataTable);
	            	}
	            }	    		
	    	}
            // On stocke les colonnes dans un champs caché
            setColumns('columnParticipant');

            var tableParticipant = jQuery('#factureParticipant').DataTable({
			    "order": [1, "asc"],
				responsive: true,
				"lengthMenu": [25, 50, 75, 100, 150],
				"processing": true,
				"language": {
					"processing": "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucune facture disponible",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ facture(s)",
					"infoEmpty": " 0 ( Facture(s) )",
				},
		    });

		    jQuery('a.toggle-vis-participant').on( 'click', function (e) {
		        e.preventDefault();
		        // Mise à jour des colonnes
		        addRemoveColumns(jQuery(this).text(), 'columnParticipant');
		        // Get the column API object
		        var column = tableParticipant.column( jQuery(this).attr('data-column') );

		        // Toggle the visibility
		        column.visible( ! column.visible() );
		    });
		    // Cacher le loading
		    jQuery('#loadingFacture').hide();
		    jQuery('#manage_facture').show();
	    }
	);

	jqxhr.always(function() {
	    jQuery('.facture_participant').show(); 
	    jQuery('#loadingFacture').hide();
		jQuery('#manage_facture').show();
    });

    /****************************CREATION D'UN BON DE COMMANDE******************* 
    *                                                                           *
    *                                                                           *
    *****************************************************************************/

    jQuery('#formBonDeCommande').submit( function(event) {
        event.preventDefault();
        // On change le libéllé du bouton pendant la création de la facture
        jQuery( "#btnBC" ).attr("disabled", true);
    	jQuery( "#btnBC" ).html(" <i class='fa fa-circle-o-notch fa-spin'></i> Création Bon de Commande ");
        // On serialize le formulaire
    	var data = jQuery( "#formBonDeCommande" ).serialize();
    	jQuery.post(
		    ajaxurl,
		    {
		        'action': 'createFactureViaBC',
		        'data': data
		    },
		    function(response){
		    	var response = JSON.parse(response);
		    	jQuery( "#btnBC" ).attr("disabled", false);
		    	jQuery( "#btnBC" ).html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Enregistrer ');
		    	
                if(response==="success"){
                    jQuery(".successBC").html("Facture créée avec succès et transmis par mail au participant.").show().delay(5000).fadeOut();
                    setTimeout(document.location.reload(),5000);
                }
                
                if(response==="errorDB"){
                    jQuery(".errorBC").html("Erreur lors de la création de la facture dans la Base.").show().delay(8000).fadeOut();
                }

                if(response==="errorMail"){
                    jQuery(".infoBC").html("La facture a été générée, mais n'a pas été envoyée par mail : Une erreur sur le serveur de mail").show().delay(8000).fadeOut();
                }

                if(response==="error"){
                    jQuery(".infoBC").html("La facture a été créé en base, mais n'a pas été générée en PDF.").show().delay(8000).fadeOut();
                }

                if(response==="errorData"){
                    jQuery(".errorBC").html("Facture non générée, aucune insertion en base. Problème de données.").show().delay(8000).fadeOut();
                }
		    }
		);
    });
    


    /****************************CREATION D'UN SPONSOR***************************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/
    // Afficher sponsor
    jQuery('#showSponsor').click( function(event) {
    	jQuery('.createSponsor').hide();

        if( jQuery("#isLoadShow").val() != "Ok" ){
        	if( jQuery("#loadingFactureSponsor:hidden").length > 0){
                jQuery('#loadingFactureSponsor').show();
        	}	
    	}
    	jQuery('.showSponsor').show();
    });
    

    // Affichage du formulaire de création du sponsor
    jQuery('#createSponsor').click( function(event) {
    	jQuery('.showSponsor').hide();

    	/*if( jQuery("#isLoadCreate").val() != "Ok" ){
        	if( jQuery("#loadingFactureSponsor:hidden").length > 0){
                jQuery('#loadingFactureSponsor').show();
        	}	
    	}*/
    	jQuery('.createSponsor').show();
    });

    // Ajouter un contact sponsor
    jQuery('#addContactSoponsor').click( function(event) {
    	var old_indice = parseInt(jQuery('#contact_id').val());
    	var indice = old_indice + 1;
    	//add new contact
    	addContactSoponsor(old_indice, indice);
    });

    // Supprimer un contact sponsor
    jQuery('#deleteContactSponsor').click( function(event) {
    	var indice = parseInt(jQuery('#contact_id').val());
    	//Don't hide contact number 0
    	if(indice > 0){
    		jQuery(".div_"+indice).remove();
    		//update contact_id with the new indice
    		var new_indice = indice - 1;
	    	jQuery("#contact_id").val(new_indice);
    	}
    });

    // Fonction d'ajour d'une nouvelle ligne de contact
    function addContactSoponsor(old_indice, indice){
    	var divContactSponsor =

		'<div class="col-sm-3 div_'+indice+'">'+
	        '<label for="contact_nom_'+indice+'" class="col-form-label-lg labelSponsor">Nom</label>'+
	        '<input type="text" name="contact_nom_'+indice+'" class="form-control form-control-lg" id="contact_nom_'+indice+'" placeholder="Nom">'+
	    '</div>'+

	    '<div class="col-sm-3 div_'+indice+'">'+
	        '<label for="contact_prenom_'+indice+'" class="col-form-label-lg labelSponsor">Prénom</label>'+
	        '<input type="text" name="contact_prenom_'+indice+'" class="form-control form-control-lg" id="contact_prenom_'+indice+'" placeholder="Prénom">'+
	    '</div>'+

	    '<div class="col-sm-3 div_'+indice+'">'+
	        '<label for="contact_email_'+indice+'" class="col-form-label-lg labelSponsor">Email</label>'+
	        '<input type="text" name="contact_email_'+indice+'" class="form-control form-control-lg" id="contact_email_'+indice+'" placeholder="Email">'+
	    '</div>'+

	    '<div class="col-sm-3 div_'+indice+'">'+
	        '<label for="contact_telephone_'+indice+'" class="col-form-label-lg labelSponsor">Téléphone</label>'+
	        '<input type="number" name="contact_telephone_'+indice+'" class="form-control form-control-lg" id="contact_telephone_'+indice+'" placeholder="Téléphone">'+
	    '</div>';
	    //append new contact to the laste
	    jQuery(".indice_0").append(divContactSponsor);
	    //update new indice
	    jQuery("#contact_id").val(indice);
    }

    // Appel ajax pour la création du sponsor
    jQuery("#target-createSponsor").submit(function( event ) {
    	event.preventDefault();
    	jQuery( "#enregistrerSponsor" ).attr("disabled", true);
    	jQuery( "#enregistrerSponsor" ).html(" <i class='fa fa-circle-o-notch fa-spin'></i> Création sponsor ");
    	var data = jQuery( "#target-createSponsor" ).serialize();
    	console.log(data);
    	jQuery.post(
		    ajaxurl,
		    {
		        'action': 'createSponsor',
		        'data': data
		    },
		    function(response){
		    	var response = JSON.parse(response);
		    	jQuery( "#enregistrerSponsor" ).attr("disabled", false);
		    	jQuery( "#enregistrerSponsor" ).html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Enregistrer ');
		    	
                if(response==="success"){
                    jQuery(".successSponsor").html("Sponsor créé avec succès").show().delay(5000).fadeOut();
                    setTimeout(document.location.reload(),5000);

                }
                
                if(response==="errorDB"){
                    jQuery(".errorSponsor").html("Erreur lors de la création du sponsor dans la Base.").show().delay(8000).fadeOut();
                }

                if(response==="errorMail"){
                    jQuery(".errorSponsor").html("Le sponsor a été créé, sa facture a aussi été générée, mais la facture n'a pas été envoyée par mail.").show().delay(8000).fadeOut();
                }

                if(response==="errorFacture"){
                    jQuery(".errorSponsor").html("Le sponsor a été créé, mais la facture n'a pas été générée.").show().delay(8000).fadeOut();
                }
		    }
		);
        
    });

    /****************************CHARGEMENT LISTE DES EVENEMENTS*****************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/

        // Selection d'un évenement de la liste
    jQuery( "#evenementList" ).change(function() {
        var valueEvent = jQuery( "#evenementList" ).val(); 
        var n = valueEvent.indexOf(",");
        var data = JSON.parse( valueEvent.substring(n+1) );

        var dataEvent = data[0];
        
        if( jQuery( ".facture_type" ).val() ==="sponsor" || jQuery( ".facture_type" ).val() ==="participant"){
        	jQuery( "#specialiteEvent" ).val( dataEvent["Specialite Evenement"] );
        	jQuery( "#dateDebut" ).val( dataEvent["Date Debut Evenement"] );
	        jQuery( "#dateFin" ).val( dataEvent["Date Fin Evenement"] );
	        jQuery( "#codepostalEvent" ).val( dataEvent["Code postal Evenement"] );
	        jQuery( "#adresseEvent" ).val( dataEvent["Adresse Evenement"] );
	        jQuery( "#villeEvent" ).val( dataEvent["Ville Evenement"] );
	        jQuery( "#paysEvent" ).val( dataEvent["Pays Evenement"] );
	        jQuery( "#contactAdresse" ).val( dataEvent["Contact Adresse"] );
	        jQuery( "#contactNom" ).val( dataEvent["Contact Nom"] );
        }else{
            jQuery( "#dateEvenement" ).val( dataEvent["Date Debut Evenement"] );
        }
		
    });
    /****************************FACTURE SPONSOR*********************************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/
    var jqxhr = jQuery.post(
        ajaxurl,
	    {
	        'action': 'getFacture',
	        'data': 'Sponsor',
	    },
	    function(response){
	    	var response = JSON.parse(response);
	    	if(response !=""){
	            var data = response;
	            if(Object.keys(data).length != 0){
	            	for(var i in data){
	            		var id = data[i]['id'];
	            		var periode = data[i]['periode'];
	            		var numero = data[i]['numero'];
	            		var date_facture = data[i]['date_facture'];
	            		var destinataire = data[i]['destinataire'];
	            		var intitule = data[i]['intitule'];
	            		var specialite = data[i]['specialite'];
	            		var annee = data[i]['annee'];
	            		var montantHT = data[i]['montantHT']
	            		var aka_tauxTVA = data[i]['aka_tauxTVA'];
	            		var montantTVA = data[i]['montantTVA'];
	            		var montantTTC = data[i]['montantTTC'];
	            		var montantNET = data[i]['montantNET'];
	            		var total = data[i]['total'];
	            		var accompte = data[i]['accompte'];
	            		var restedu = data[i]['restedu'];
	            		var paye = data[i]['paye'];
	            		var encaisse = data[i]['encaisse'];
	            		var date_reglement = data[i]['date_reglement'];
	            		var commentaire = data[i]['commentaire'];
	            		var concerne = data[i]['concerne'];
	            		var contacts = data[i]['contacts'];

	            		var dataTable =

	            		"<tr>"
						+   "<td class='details-control'><input type='checkbox' class='checkForExport' value='"+id+"'</td>"
						+   "<td>"+periode+"</td>"
						+   "<td>"+numero+"</td>"
						+   "<td>"+date_facture+"</td>"
						+   "<td>"+destinataire+"</td>"
						+   "<td>"+intitule+"</td>"
						+   "<td>"+specialite+"</td>"
						+   "<td>"+annee+"</td>"
						+   "<td>"+montantHT+"</td>"
						+   "<td>"+aka_tauxTVA+"</td>"
						+   "<td>"+montantTVA+"</td>"
						+   "<td>"+montantTTC+"</td>"
						+   "<td>"+montantNET+"</td>"
						+   "<td>"+total+"</td>"
						+   "<td>"+accompte+"</td>"
						+   "<td>"+restedu+"</td>"
						+   "<td>"+paye+"</td>"
						+   "<td>"+encaisse+"</td>"
						+   "<td>"+date_reglement+"</td>"
						+   "<td>"+commentaire+"</td>"
						+   "<td>"+concerne+"</td>"
						+"</tr>";
	            		jQuery('#bodyFactureSponsor').append(dataTable);
	            	}
	            }
	            // On indique que les données ont été chargées   		
	    	}
            // On stocke les colonnes dans un champs caché
            setColumns('columnSponsor');

            var tableSponsor = jQuery('#manage_factureSponsor').DataTable({
			    "order": [1, "asc"],
				responsive: true,
				"lengthMenu": [25, 50, 75, 100, 150],
				"processing": true,
				"language": {
					"processing":     "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucune facture disponible",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ facture(s)",
					"infoEmpty": " 0 ( Facture(s) )",
				},
		    });

		    jQuery('a.toggle-vis-sponsor').on( 'click', function (e) {
		        e.preventDefault();
		        //Modifier la liste des colonnes visibles/invisible
		        addRemoveColumns(jQuery(this).text(), 'columnSponsor');
		        // Get the column API object
		        var column = tableSponsor.column( jQuery(this).attr('data-column') );

		        // Toggle the visibility
		        column.visible( ! column.visible() );
		    });
	    }
	);
	jqxhr.always(function() {
        jQuery("#isLoadShow").val("Ok");
	    jQuery('.facture_sponsor').show(); 
	    jQuery('#loadingFactureSponsor').hide();
    });


    /****************************Intervenants************************************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/
    // Gestion des boutons
     
    jQuery('#afficherIntervenant').click( function(event) {
    	jQuery('.creerIntervenant').hide();
    	jQuery('.afficherIntervenant').show();
    	jQuery('#afficherIntervenant').hide();
    	jQuery('#creerIntervenant').show();
    });
    
    // Créer un intervenant
    jQuery('#creerIntervenant').click( function(event) {
    	jQuery('.afficherIntervenant').hide();
    	jQuery('.creerIntervenant').show();
    	jQuery('#creerIntervenant').hide();
    	jQuery('#afficherIntervenant').show();
    });

    //Création d'un intervenant
    jQuery( "#target-creerIntervenant" ).submit(function( event ) {
    	event.preventDefault();
    	jQuery( "#enregistrerIntervenant" ).attr("disabled", true);
    	jQuery( "#enregistrerIntervenant" ).html(" <i class='fa fa-circle-o-notch fa-spin'></i> Création Intervenant ");
    	var data = jQuery( "#target-creerIntervenant" ).serialize();
    	jQuery.post(
		    ajaxurl,
		    {
		        'action': 'createIntervenant',
		        'data': data
		    },
		    function(response){
		    	var response = JSON.parse(response);
		    	jQuery( "#enregistrerIntervenant" ).attr("disabled", false);
		    	jQuery( "#enregistrerIntervenant" ).html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Enregistrer ');
		    	
                if(response.substring(0, 7) === "success"){
                    jQuery(".success").html("Intervenant créé avec succès. Mot de passe : " + response.substring(7)).show();
                    //setTimeout(document.location.reload(),5000);
                }

                if(response === "errorDB"){
                    jQuery(".erreur").html("Erreur lors de la création de l'intervenant.").show().delay(8000).fadeOut();
                }

                if(response === "exist"){
                    jQuery(".erreur").html("L'intervenant a déjà été créé.").show().delay(8000).fadeOut();
                }
		    }
		);
    });
    

    //Affichage des intervenants
    var jqxhr = jQuery.post(
        ajaxurl,
	    {
	        'action': 'getIntervenants',
	    },
	    function(response){
	    	var fromIntervenant = JSON.parse(response);
	    		            
            if( fromIntervenant.length != 0){
            	for(var i in fromIntervenant){
            		var id = fromIntervenant[i]['id'];
            		var dataTable =

            		"<tr>"
					+   "<td class='details-control'><input type='checkbox' class='checkForExport' value='"+id+"'</td>"
					+   "<td>"+fromIntervenant[i]['evenement']+"</td>"
					+   "<td>"+fromIntervenant[i]['date_evenement']+"</td>"
					+   "<td>"+fromIntervenant[i]['nom']+"</td>"
					+   "<td>"+fromIntervenant[i]['prenom']+"</td>"
					+   "<td>"+fromIntervenant[i]['email']+"</td>"
					+   "<td>"+fromIntervenant[i]['telephone_professionnel']+"</td>"
					+   "<td>"+fromIntervenant[i]['adresse']+"</td>"
					+   "<td>"+fromIntervenant[i]['codepostal']+"</td>"
					+   "<td>"+fromIntervenant[i]['ville']+"</td>"
					+   "<td>"+fromIntervenant[i]['pays']+"</td>"
					+"</tr>";
            		jQuery('#bodyTableIntervenant').append(dataTable);
            	}
            }
	        // On indique que les données ont été chargées   		


            var tableIntervenant = jQuery('#tableIntervenant').DataTable({
			    "order": [1, "asc"],
				responsive: true,
				"lengthMenu": [25, 50, 75, 100, 150],
				"processing": true,
				"language": {
					"processing":     "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucun intervenant",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ intervenant(s)",
					"infoEmpty": " 0 ( Intervenant(s) )",
				},
		    });
	    }
	);


    /***********************AFFICHAGE DES FATURES GLOBALES***********************
    *                                                                           *
    *                                                                           *
    *****************************************************************************/

    var jqxhr = jQuery.post(
        ajaxurl,
	    {
	        'action': 'getFacture',
	        'data': 'all',
	    },
	    function(response){
	    	var response = JSON.parse(response);
	    	if(response !=""){
	            var data = response;
	            if(Object.keys(data).length != 0){
	            	for(var i in data){
	            		var id = data[i]['id'];
	            		var periode = data[i]['periode'];
	            		var numero = data[i]['numero'];
	            		var date_facture = data[i]['date_facture'];
	            		var destinataire = data[i]['destinataire'];
	            		var intitule = data[i]['intitule'];
	            		var annee = data[i]['annee'];
	            		var montantHT = data[i]['montantHT']
	            		var aka_tauxTVA = data[i]['aka_tauxTVA'];
	            		var montantTVA = data[i]['montantTVA'];
	            		var montantTTC = data[i]['montantTTC'];
	            		var montantNET = data[i]['montantNET'];
	            		var total = data[i]['total'];
	            		var accompte = data[i]['accompte'];
	            		var restedu = data[i]['restedu'];
	            		var paye = data[i]['paye'];
	            		var encaisse = data[i]['encaisse'];
	            		var date_reglement = data[i]['date_reglement'];
	            		var commentaire = data[i]['commentaire'];
	            		var concerne = data[i]['concerne'];

	            		var dataTable =

	            		"<tr>"
						+   "<td class='details-control'><input type='checkbox' class='checkForExport' value='"+id+"'</td>"
						+   "<td>"+periode+"</td>"
						+   "<td>"+numero+"</td>"
						+   "<td>"+date_facture+"</td>"
						+   "<td>"+destinataire+"</td>"
						+   "<td>"+intitule+"</td>"
						+   "<td>"+annee+"</td>"
						+   "<td>"+montantHT+"</td>"
						+   "<td>"+aka_tauxTVA+"</td>"
						+   "<td>"+montantTVA+"</td>"
						+   "<td>"+montantTTC+"</td>"
						+   "<td>"+montantNET+"</td>"
						+   "<td>"+total+"</td>"
						+   "<td>"+accompte+"</td>"
						+   "<td>"+restedu+"</td>"
						+   "<td>"+paye+"</td>"
						+   "<td>"+encaisse+"</td>"
						+   "<td>"+date_reglement+"</td>"
						+   "<td>"+commentaire+"</td>"
						+   "<td>"+concerne+"</td>"
						+"</tr>";
	            		jQuery('#bodyFactureGlobale').append(dataTable);
	            	}
	            }
	            // On indique que les données ont été chargées   		
	    	}
            
            // On stocke les colonnes dans un champs caché
            setColumns("columnGlobal");

            var tableGlobal = jQuery('#manage_factureGloable').DataTable({
			    "order": [1, "asc"],
				responsive: true,
				"lengthMenu": [25, 50, 75, 100, 150],
				"processing": true,
				"language": {
					"processing":     "Traitement en cours...",
				 	"search":"_INPUT_",
					"searchPlaceholder": "Rechercher...",
					"lengthMenu": "_MENU_",
					"zeroRecords": "Aucune facture disponible",
					"emptyTable": "",
					"paginate": {
						"first":    "Premier",
						"last":     "Dernier",
						"next":     "Suivant",
						"previous": "Précédent"
					},
					"info":      "_START_ à _END_ (_TOTAL_ facture(s)",
					"infoEmpty": " 0 ( Facture(s) )",
				},
		    });

		    jQuery('a.toggle-vis-global').on( 'click', function (e) {
		        e.preventDefault();
		        // Mise à jour des colonnes
		        addRemoveColumns(jQuery(this).text(), 'columnGlobal');
		        // Get the column API object
		        var column = tableGlobal.column( jQuery(this).attr('data-column') );

		        // Toggle the visibility
		        column.visible( ! column.visible() );
		    });
	    }
	);
	jqxhr.always(function() {
	    jQuery('.facture_globale').show(); 
	    jQuery('#loadingFactureGlobale').hide();
    });
});

// Affichage du tableau  miniature d'un user
function user_format(d){
	var data_file = JSON.parse(d[11]);

	if (data_file.length != 0) {
		var href = window.location.href;
        var index = href.indexOf('/wp-admin');
        var homeUrl = href.substring(0, index);
		var url = homeUrl+'/wp-content/plugins/atoutcom-users/app/public/uploads/';
		
		var dataFile = 
		'<div class="col-sm-8">';
		for (var i = 0;  i < data_file.length; i++) {
			var email = data_file[i]["email"];
			var chemin = url+email+'/'+data_file[i]["chemin"];
			dataFile2 = 
			
            '<div class="row">'+
	    		'<div class="col-sm-6">'+
	    			data_file[i]["fichier"]+
	    		'</div>'+
	    	    '<div class="col-sm-2">'+
	    			'<a href='+chemin+' download='+data_file[i]["fichier"]+' class="btn btn-primary">Telecharger</a>'+
	    		'</div>'+
	    	'</div><br>';
	    	dataFile = dataFile + dataFile2;
		}
		var dataFile3 = 
	    '</div>';
	    data_file = dataFile + dataFile3;
	}
    var data = 
    '<div class="row">'+
        '<div class="col-sm-2">'+
		    '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
		        '<tr>' +
		            '<td><strong>Nom</strong></td>' +
		            '<td>' + d[1] + '</td>' +
		        '</tr>' +
		        '<tr>' +
		            '<td><strong>Email</strong></td>' +
		            '<td>' + d[2] + '</td>' +
		        '</tr>' +
		    '</table>'+
	    '</div>'+
         data_file+
    '</div>';  
    return data;
}

// Dérouler du tableau affichage miniature d'un evement
function event_format(d){
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
            '<td><strong>Nom de l\événement</strong></td>' +
            '<td>' + d[1] + '</td>' +
        '</tr>' +
        '<tr>' +
            '<td><strong>Spécialité</strong></td>' +
            '<td>' + d[2] + '</td>' +
        '</tr>' +
     '</table>';  
}


// Dérouler du tableau affichage miniature d'un participant
function user_event_format(d){
    //if( d[9] ==="" || d[10] === ""){
	//	var optionDisable = "disabled";
	//}
    var status = d[14];
	if( status === "Validé" && d[10] === "" ){
		var optionDisable = "none";
	}else{
		var optionDisable = "block";
	}
    
    var chemin = window.location.origin+"/wordpress/wp-admin/images/loading.gif";

    
	if(status === "En attente"){
		var optionData =       
        '<option value="En attente" selected>En attente</option>'+
        '<option value="Annulé">Annulé</option>'+
        '<option value="Validé">Validé</option>';
	}
	else if(status === "Validé"){
		var optionData =       
        '<option value="Validé" selected>Validé</option>'+
        '<option value="Annulé">Annulé</option>'+
        '<option value="En attente">En attente</option>';
	}
	else if(status === "Annulé"){
		var optionData =       
        '<option value="Annulé" selected>Annulé</option>'+
        '<option value="En attente">En attente</option>'+
        '<option value="Validé">Validé</option>';
	}else {
		var optionData =       
        '<option value="En attente">En attente</option>'+
        '<option value="Annulé">Annulé</option>'+
        '<option value="Validé">Validé</option>';
	}
    
    var dataForm = 
    '<form method="post" onsubmit="return changeStatus();">'+
        '<div class="alert alert-success text-center successStatus" style="display: none;"></div>'+
        '<div class="alert alert-danger text-center errorStatus" style="display: none;"></div>'+
        '<div class="alert alert-info text-center infoStatus" style="display: none;"></div>'+
        '<div class="container">'+
	        '<div class="row">'+
	            '<div class="col-sm-6">'+
	                '<input type="hidden" value='+d[4]+' class="userId">'+
	                '<input type="hidden" value='+d[13]+' class="formID">'+
	                '<input type="hidden" value='+d[12]+' class="entryID">'+
	                '<input type="hidden" value='+d[10]+'  class="transactionID">'+
			        '<select class="form-control statut">'+
			            optionData+
			        '</select>'+
			        
			    '</div>'+

			    '<div class="col-sm-6">'+
			        '<select class="form-control langue">'+
			            '<option value="" selected>Langue</option>'+
			            '<option value="fr">Français</option>'+
			            '<option value="en">Anglais</option>'+
			        '</select>'+
			    '</div>'+
			    
			    '<div class="col-sm-6" style="margin-top:5px;">'+
			        '<input type="number" class="form-control" placeholder="montant reçu" id="montantRecu" style="width:250px; font-size: inherit;">'+
			    '</div>'+

			    '<div class="col-sm-6" style="margin-top:5px;">'+
			        '<input type="date" class="form-control" placeholder="Date" id="date_paiement" style="width:250px; font-size: inherit;">'+
			    '</div>'+

			    

			    '<div class="col-sm-2" style="margin-top:5px;">'+
			        '<input type="submit" value="Ok" style="cursor:pointer;">'+
			    '</div>'+
			    '<div class="col-sm-1" style="margin-top:5px;">'+
	                '<img id="loading" src="'+chemin+'" style="display: none;">'+
			    '</div>'+
	        '</div>'+
        '</div>'+
    '</form>';

    var dataDocument=
    '<form method="post" id="formFichierUser" onsubmit="return sendFileToUser();" enctype="multipart/form-data">'+
        '<div class="alert alert-success text-center successUserFile" style="display: none;"></div>'+
        '<div class="alert alert-danger text-center errorUserFile" style="display: none;"></div>'+
        '<div class="row">'+
            '<div class="col-sm-10">'+
                '<input type="hidden" value='+d[4]+' class="userId">'+
                '<input type="hidden" value='+d[13]+' class="formID">'+
                '<input type="hidden" value='+d[12]+' class="entryID">'+
		        '<input type="file"  name="fichier">'+
		    '</div>'+
		    '<div class="col-sm-3" style="margin-top: 7px;">'+
		        '<input type="submit" value="Envoyer" style="cursor:pointer;">'+
		    '</div>'+
		    '<div class="col-sm-1">'+
                '<img id="loadingFileUser" src="'+chemin+'" style="display: none;">'+
		    '</div>'+
        '</div>'+
    '</form>';

	var data = 
    '<div class="row">'+
        '<div class="col-sm-10">'+
		    '<table cellspacing="0" border="1" style="padding-left:50px; width:inherit;">' +
			    '<thead>'+
			        '<tr>'+
			            '<th>Evenement</th>'+
			            '<th>Participant</th>'+
			            '<th>Statut</th>'+
			            '<th>Document</th>'+
			        '</tr>'+
			    '</thead>'+
			    '<tbody>'+
			        '<tr>'+
			            '<td>'+ d[1] +'</td>'+
			            '<td>' + d[2] +' '+ d[3]+ '</td>'+
			            '<td>'+ dataForm +'</td>'+
			            '<td>'+ dataDocument +'</td>'+
			        '</tr>'+
			    '</tbody>'+
		    '</table>'+
        '</div>'+
    '</div>'
    ; 
    return data;
}

// Fonction declencheur du changement de statut
function changeStatus(){
	jQuery('#loading').show();
	var dataStatus = jQuery('.statut').val();
	var date_paiement = jQuery('#date_paiement').val();
	var userId = jQuery('.userId').val();
	var transactionID = jQuery('.transactionID').val();
	var langue = jQuery('.langue').val();
	var formId = jQuery('.formID').val();
	var montantRecu = jQuery('#montantRecu').val();


	jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        data: {
            "action": "updateUserStatus",
            "dataStatus": dataStatus,
            "date_paiement": date_paiement,
            "userId": userId,
            "formId": formId,
            "transactionID": transactionID,
            "participation" : montantRecu,
            "langue": langue,
        },
        success: function(response){
        	//console.log(response)
        	var response = JSON.parse(response);
            jQuery('#loading').hide();
            
            // Statut ok (différent de validé)
            if(response==="successStatus"){
                jQuery('.successStatus').html("Statut mis à jour avec succès").show().delay(15000).fadeOut();
                setTimeout(document.location.reload(),15000);
            }
            
            // Statut Ok, facture générée et envoyée par mail
            if(response==="successFactureMail"){
                jQuery('.successStatus').html("Statut mis à jour avec succès. La facture a aussi été envoyée au participant.").show().delay(15000).fadeOut();
                setTimeout(document.location.reload(),15000);
            }
            
            // Statut Ok, facture générée mais pas envoyée par mail
            if(response==="errorMail"){
                jQuery('.infoStatus').html("Statut mis à jour avec succès. La facture a été générée mais n'a pas été envoyée").show().delay(15000).fadeOut();
            }
            
            // Statut Ok mais facture non générée
            if(response==="error" || response==="errorUserNotFoundEmail" || response==="errorUserNotFoundEvent"){
                jQuery('.infoStatus').html("Statut mis à jour avec succès. Mais la facture n'a pas été générée").show().delay(15000).fadeOut();
            }
            
            //
            if(response==="errorDBStatus"){
                jQuery('.error').html("Une erreur s'est produite lors de la mise à jour du statut. Veuillez ressayer.").show().delay(15000).fadeOut();
            }
	    }
	});
	
	return false;
}


// Fonction qui permet de transmettre un document à un utilisateur
function sendFileToUser(){
	jQuery('#loadingFileUser').show();
	var dataStatus = jQuery('.statut').val();
	var userId = jQuery('.userId').val();
	//var entryId = jQuery('.entryID').val();
	var formId = jQuery('.formID').val();
	var myForm = document.getElementById('formFichierUser');
    var formdata = new FormData(myForm);

    formdata.append("action", "form_file");
    formdata.append("fichier", "fichier");
    formdata.append("type", "attestation");
    formdata.append("email", userId);
    formdata.append("formId", formId);
	jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        contentType: false,
        processData: false,
        data: formdata,
        success: function(response){
        	var response = JSON.parse(response);
            jQuery('#loadingFileUser').hide();
            if(response==="success"){
                jQuery('.successUserFile').html("Le fichier a été uploadé avec success").show().delay(5000).fadeOut();
                setTimeout(document.location.reload(),5000);
            }

            if(response==="error"){
                jQuery('.errorUserFile').html("Une erreur s'est produite. Veuillez ressayer.").show().delay(5000).fadeOut();
            }

            if(response==="errorDB"){
                jQuery('.errorUserFile').html("Une erreur DB s'est produite. Veuillez ressayer.").show().delay(5000).fadeOut();
            }
	    }
	});
	
	return false;
}

// Mettre le taleau des colonnes dans un champs caché
function setColumns(param){
    var cols = [
		"PERIODE", 
		"NUMÉRO", 
		"DATE_CREATION", 
		"DESTINATAIRE", 
		"INTITULÉ",
		"SPECIALITÉ", 
		"ANNÉE", 
		"MontantHT", 
		"Ak_TauxTVA", 
		"MontantTVA", 
		"MontantTTC", 
		"MontantNet€", 
		"TOTAL", 
		"ACCOMPTE", 
		"RESTEDÛ", 
		"PAYÉ", 
		"ENCAISSÉ", 
		"Ak_DateReglement", 
		"COMMENTAIRE", 
		"CONCERNE"
	];
	//Encoder le tableau afin de le stoker
	var colsJson = JSON.stringify(cols);
    jQuery("#"+param).val(colsJson);
}

// Ajouter ou enlever une colonne pour l'import excel Sponsor
function addRemoveColumns(column, param){
    
	var x = jQuery("#"+param).val();
	x = JSON.parse(x);
	//Si la colonne existe, on supprime, sinon on ajoute
	if(x.indexOf(column) > -1){
		x.splice( x.indexOf(column), 1 );
	}else{
		x.push(column);
	}
    var xJSON = JSON.stringify(x);
    jQuery("#"+param).val(xJSON);
    //return param;
}

// Fonction d'export Excel
function exportDataExcel(param, tab, id){
    jQuery( "#"+id ).attr("disabled", true);
	jQuery( "#"+id ).html(" <i class='fa fa-circle-o-notch fa-spin'></i> Export Excel ");
    var typeFacture = jQuery('.facture_type').val();
	
	// Distinguer les listes classiques des exports facture
	if(typeFacture ==="Liste_Participant"){
		var tabId = JSON.parse(tab);
		var colonneVisible =["Evénement", "Nom", "Prénom", "Email", "Adresse", "Code Postal", "Ville", "Pays", "Téléphone Professionnel", "TransactionID", "Statut Paiement", "Etat du règlement", "Mode de règlement", "Date du paiement"];
	}else{
		var idChecked = jQuery('.checkForExport:checked');
		var colonneVisible = JSON.parse(jQuery('#'+param).val());
		var tabId=[];

		if(idChecked.length===0){
	        jQuery('.checkForExport').each(function() {
	            tabId.push(""+jQuery(this).val()+"");
	        });
		}else{
			
			idChecked.each(function(){
				tabId.push(""+jQuery(this).val()+"");
			});
		}
	}

	var jqxhr = jQuery.post(
        ajaxurl,
	    {
	        'action': 'exportExcel',
	        'data': tabId,
	        'type': typeFacture,
	        'colonneVisible': colonneVisible,
	    },
	    function(response){
            jQuery( "#"+id ).attr("disabled", false);
	        jQuery( "#"+id ).html(' <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel');

	        var href = window.location.href;
	        var index = href.indexOf('/wp-admin');
	        var homeUrl = href.substring(0, index);
			var downloadUrl = homeUrl+'/wp-content/plugins/atoutcom-users/app/public/uploads/Export_Excel/Export_Atoutcom_'+typeFacture+'.xlsx';
            var a = document.createElement("a");
            a.href = downloadUrl;
            a.download = 'Export_Atoutcom_'+typeFacture+'.xlsx';
            document.body.appendChild(a);
            a.click();
	    }
    );
}

// Fonction d'export Excel pour les listes
function exportListeExcel(){
    jQuery( "#exportExcel" ).attr("disabled", true);
	jQuery( "#exportExcel" ).html(" <i class='fa fa-circle-o-notch fa-spin'></i> Export Excel ");

	var jqxhr = jQuery.post(
        ajaxurl,
	    {
	        'action': 'exportExcel',
	        'type': typeFacture,
	    },
	    function(response){
            jQuery( "#exportExcel" ).attr("disabled", false);
	        jQuery( "#exportExcel" ).html(' <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export Excel');
	        var href = window.location.href;
	        var index = href.indexOf('/wp-admin');
	        var homeUrl = href.substring(0, index);
			var downloadUrl = homeUrl+'/wp-content/plugins/atoutcom-users/app/public/uploads/Export_Excel/Export_Atoutcom_'+typeFacture+'.xlsx';
            var a = document.createElement("a");
            a.href = downloadUrl;
            a.download = 'Export_Atoutcom_'+typeFacture+'.xlsx';
            document.body.appendChild(a);
            a.click();
	    }
    );
}