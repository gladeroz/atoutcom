<?php
/*
Plugin Name: Atoutcom events
Plugin URI: http://eybios.fr/plugins/users
Description: Plugin de gestion d'évenements
Author: Harou Guindja
Version: 0.1
Author URI:
*/

// register activation hook for when the plugin is installed.
register_activation_hook(__FILE__, 'atoutcom_events_activate');
function atoutcom_events_activate($network_wide)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->activate($network_wide);
}

// register deactivation hook for when the plugin is uninstalled
register_deactivation_hook(__FILE__, 'atoutcom_events_deactivate');
function atoutcom_events_deactivate($network_wide)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->deactivate($network_wide);
}

// register an action handler for when a new blog is created in a multisite environment
add_action('wpmu_new_blog', 'atoutcom_events_on_create_blog');
function atoutcom_uevents_on_create_blog($blog_id)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->activate_blog($blog_id);
}

// register an action handler for when a blog is deleted in a multisite environent
add_action('deleted_blog', 'atoutcom_events_on_delete_blog');
function atoutcom_events_on_delete_blog($blog_id)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->deactivate_blog($blog_id);
}



// Affichage des évenements
// Source datatable events
function events_manage() {
    global $wpdb;
    $data = array();
    $datas = array();
    //$dataEvent = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."atoutcom_events", ARRAY_A);
    $dataEvent = atoutcomUser::formsEvents("listeEventsForUsers");
    $listEvt = array();
    // Filtré les évenements pour ne pas chopper des doublons
    foreach ($dataEvent as $data) {
        $event = $data["evenement"];
        if(empty($listEvt)){
            array_push($listEvt, $data);
        }else{
            foreach ($listEvt as $value) {
                if( !in_array($event, $value) ){
                    array_push($listEvt, $data);
                }
            }
        }
    }

    if( $listEvt === NULL || empty($listEvt) ){
        wp_die(json_encode(""));
    }else{
        foreach ($listEvt as $value) {
            $listEvt = $value["data"][0];
            $data["organisateur"] = $listEvt["Organisateur Evenement"];
            $data["titre"] = $value["evenement"];
            $data["specialite"] = $listEvt["Specialite Evenement"];
            $data["adresse"] = $listEvt["Adresse Evenement"];
            $data["codepostal"] = $listEvt["Code postal Evenement"];
            $data["ville"] = $listEvt["Ville Evenement"];
            $data["pays"] = $listEvt["Pays Evenement"];
            if( $listEvt["Date Debut Evenement"] === $listEvt["Date Fin Evenement"]){
                $data["date_evenement"] = $listEvt["Date Debut Evenement"];
            }else{
                $data["date_evenement"] = $listEvt["Date Debut Evenement"]." - ".$listEvt["Date Fin Evenement"];
            }
            
            $datas[]=$data;
        }

        wp_die(wp_json_encode($datas));
    }
}
add_action( 'wp_ajax_events_manage', 'events_manage' );
add_action( 'wp_ajax_nopriv_events_manage', 'events_manage' );


// Affichage des participants aux évenements

function user_events() {
    global $wpdb;
    $data = array();
    $datas = array();

    $datauUserEvents = atoutcomUser::formsEvents("listeEventsForUsers");

    if( $datauUserEvents===NULL ){
        wp_die(wp_json_encode(""));
    }else{
        foreach ($datauUserEvents as $datauUserEvent) {
            $dataUsr = $datauUserEvent["data"][0];
            $data["evenement"] = $datauUserEvent["evenement"];
            $data["form_id"] = $datauUserEvent["form_id"];
            $data["entry_id"] = $datauUserEvent["entry_id"];
            $data["nom"] = $dataUsr["Nom"];
            $data["prenom"] = $dataUsr["Prenom"];
            $data["email"] = $dataUsr["Email Professionnel"];
            $data["adresseUser"] = $dataUsr["Adresse"];
            $data["codepostalUser"] = $dataUsr["Code postal"];
            $data["villeUser"] = $dataUsr["Ville"];
            $data["paysUser"] = $dataUsr["Pays"];
            $data["telephone"] = $dataUsr["Telephone Professionnel"];
            $data["payment_status"] = $dataUsr["payment_status"];
            $data["transaction_id"] = $dataUsr["transaction_id"];
            $data["payment_mode"] = $dataUsr["paiement"];
            $data["status"] = events::getUsersEventsStatus($data["form_id"],  $data["email"]);
            $date = new DateTime(events::getUsersEventsDatePayment($data["form_id"],  $data["email"]));
            $data["payment_date"] = $date->format('d/m/Y');
            $datas[]=$data;
        }
        
        wp_die(wp_json_encode($datas));
    }
    wp_die();
}
add_action( 'wp_ajax_user_events', 'user_events' );
add_action( 'wp_ajax_nopriv_user_events', 'user_events' );


// Mise à jour du statut 
function updateUserStatus() {
    global $wpdb;
    $data = array();
    
    $userEmail = $_POST["userId"];
    $categorie = atoutcomUser::getCategorie($userEmail);
    $statut = $_POST["dataStatus"];
    $date_paiement = date('Y-m-d', strtotime(str_replace('-', '/', esc_sql($_POST["date_paiement"]))));
    $form_id = $_POST["formId"];
    $transactionID = $_POST["transactionID"];
    $participation = (int)$_POST["participation"];
    $langue = ($_POST["langue"] == "") ? "fr" : $_POST["langue"];
    //var_dump($transactionID, $statut);wp_die();

	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->base_prefix."atoutcom_users_events_status WHERE id_event = '".$form_id."' AND email = '".$userEmail."'");

    if( $rowcount == 0 ){
	    $updateStatus = $wpdb->insert( 
	        $wpdb->base_prefix."atoutcom_users_events_status",
            array( 
                'email'  => $userEmail,
                'id_event' => $form_id,
                'status'  => $statut,
                'date_paiement' => $date_paiement,
            ), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
            ) 
	    );
	}else{
		$updateStatus = $wpdb->update( 
	        $wpdb->base_prefix."atoutcom_users_events_status",
	        array( 
	            'status'  => $statut,
	            'date_paiement' => $date_paiement,
	        ), 
	        array(
	            'id_event' => $form_id,
	            'email' => $userEmail,
	        )
	    );
	}
	
	if( $updateStatus ){
        // On verifie le statut : S'il vaut valide, on envoie la facture
        if($statut === "Validé" && $transactionID === NULL ){
        	$dataUserEvents = atoutcomUser::formsEvents("listeEventsForUsers");
		    //retourner uniquement le tableau contenant les info du user connecté
		    
		    if( sizeof($dataUserEvents) != 0 ){
		    	//$conference = true;

		        foreach ($dataUserEvents as $dataUserEvent) {
		        	$tabUser = array();
		        	$tab = $dataUserEvent["data"][0];
		            if( $tab["Email Professionnel"] === $userEmail ){
			            $tabUser = 
			            array(
			            	"evenement" => $dataUserEvent["evenement"],
			            	"specialite" => $tab["Specialite Evenement"],
			                "participant" => $tab["Nom"]." ".$tab["Prenom"],
			                "adresse" => $tab["Adresse"],
			                "adresseEvt" => $tab["Adresse Evenement"],
			                "villeEvt" => $tab["Ville Evenement"],
			                "codepostalEvt" => $tab["Code postal Evenement"],
			                "paysEvt" => $tab["Pays Evenement"],
			                "codepostal" => $tab["Code postal"],
			                "ville" => $tab["Ville"],
			                "dateDebut"=>$tab["Date Debut Evenement"],
			                "dateFin"=>$tab["Date Fin Evenement"],
			                "contact_nom"=>$tab["Contact Nom"],
			                "contact_adresse"=>$tab["Contact Adresse"]
			            );
			            break; 
		            } 
		        }
                
                if( sizeof($tabUser) !=0 ){
                	// On insère les données de la facture dans la table
                	$maxID = atoutcomUser::getMaxIdFacture();
				    if($maxID === NULL || $maxID === ""){
				        $maxID = 0;
				    }
				    $numero = $maxID +1;
				    $jourEvenement = substr($tabUser["dateDebut"], 0, 2);
				    $moisEvenement = substr($tabUser["dateDebut"], 3, -5);
				    $periode = substr($tabUser["dateDebut"], 6);
				    $numeroFacture = $numero."".$periode."/".$jourEvenement."".$moisEvenement;
                    $quantite = "1";
				    $aka_tauxTVA = 10;
				    $montantTVA = round($participation*0.1, 2, PHP_ROUND_HALF_DOWN);
                    $montantHT = round($participation-$montantTVA, 2, PHP_ROUND_HALF_DOWN);
				    $montantTTC = $participation;
				    $montantNET = $participation;
				    $total = $participation;
				    $accompte = 0;
				    $restedu = 0;
				    $paye = $participation;
				    $encaisse = $participation;

                	$insertDataFacture =  $wpdb->insert( 
			        $wpdb->base_prefix."atoutcom_users_events_facture",
				        array( 
				            'periode'  => $periode,
				            'numero' => $numeroFacture,
				            'date_facture' => date("d/m/Y"),
				            'destinataire' => $tabUser["participant"],
				            'intitule' => $tabUser["evenement"],
				            'specialite' => $tabUser["specialite"],
				            'annee' => $periode,
				            'montantHT' => $montantHT,
				            'aka_tauxTVA' => $aka_tauxTVA,
				            'montantTVA' => $montantTVA,
				            'montantTTC' => $montantTTC,
				            'montantNET' => $montantNET,
				            'total' => $participation,
				            'accompte' => $accompte,
				            'restedu' => $restedu,
				            'paye' => $paye,
				            'encaisse' => $encaisse,
				            'date_reglement' => date("d/m/Y"),
				            'commentaire' => '',
				            'concerne' => $categorie,
				        ), 
				        array( 
				            '%s',
				            '%s',
				            '%s',
				            '%s',
				            '%s',
				            '%s',
				            '%s',
				            '%f',
				            '%d',
				            '%d',
				            '%d',
				            '%d',
				            '%d',
				            '%d',
				            '%d',
				            '%d',
				            '%d',
				            '%s',
				            '%s',
				            '%s',
				        )
				    );
				    // Si données insérées dans la table facture
				    if($insertDataFacture){
				    	//participant & adresse facturation
				    	$userInfo = atoutcomUser::adresseFacturation($userEmail, $categorie);

				    	$participant = $tabUser["participant"];
						$adresseParticiant = $tabUser["adresse"];
						$codePostalParticipant = $tabUser["codepostal"];
						$villeParticipant = $tabUser["ville"];
						$paysParticipant = $userInfo->pays;
						$emailParticipant = $userEmail;

						if($userInfo->organisme_facturation === "" || $userInfo->organisme_facturation === NULL){
							$emailContact = $emailParticipant;
							$destinataire = $participant;
							$adresseFacturation = $adresseParticiant;
							$codepostalFacturation = $codePostalParticipant;
							$villeFacturation = $villeParticipant;
							$paysFacturation =  $paysParticipant;
						}else{
					        $emailContact = $userInfo->email_facturation;
							$destinataire = $userInfo->organisme_facturation;
							$adresseFacturation = $userInfo->adresse_facturation;
							$codepostalFacturation = $userInfo->codepostal_facturation;
							$villeFacturation =  $userInfo->ville_facturation;
							$paysFacturation =  $userInfo->pays_facturation; 
						}
						// Date Evenement
						if($tabUser["dateDebut"] === $tabUser["dateFin"]){
				            $dateEvenement = atoutcomUser::dateFr($tabUser["dateDebut"], "");
				        }else{
				            $jrDebut = substr($tabUser["dateDebut"], 0, 2);
				            $moisDebut = atoutcomUser::dateFr("", substr($tabUser["dateFin"], 3, -5));
				            $anneeDebut = substr($tabUser["dateDebut"], 6);

				            
				            $jrFin = substr($tabUser["dateFin"], 0, 2);
				            $moisFin = atoutcomUser::dateFr("", substr($tabUser["dateFin"], 3, -5));
				            $anneeFin = substr($tabUser["dateFin"], 6);

				            //si les années sont identiques
				            if($anneeDebut === $anneeFin){
				                if( $moisDebut === $moisFin ){
				                    $dateEvenement = $jrDebut." - ".$jrFin." ".$moisDebut." ".$anneeDebut;
				                }else{
				                    $dateEvenement = $jrDebut." ".$moisDebut." - ".$jrFin." ".$moisFin." ".$anneeDebut;
				                }
				            }else{
				                $dateEvenement = atoutcomUser::dateFr($tabUser["dateDebut"], "")." - ".atoutcomUser::dateFr($tabUser["dateFin"], "");
				            }
				        }
				    	// On génère la facture
				    	$numBonDeCommande = "/"; 
				    	$descriptionDetail = "";
				    	$facture_acq = 'acquittée';
				    	$genererFacture = genererFacture(
						    $langue,
						    $destinataire, 
						    $adresseFacturation,
						    $codepostalFacturation.", ".$villeFacturation.", ".$paysFacturation,
						    $numeroFacture,
						    date("d/m/Y"),
						    $tabUser["evenement"],
						    $dateEvenement."<br>".$tabUser["villeEvt"],
						    $descriptionDetail,
						    $quantite,
						    $montantHT,
						    $montantTVA,
						    $montantTTC,
						    date("d/m/Y"),
						    $emailContact,
						    $tabUser["contact_nom"],
						    $tabUser["contact_adresse"],
						    $aka_tauxTVA,
						    $numBonDeCommande,
						    $facture_acq,
						    $participant,
						    $adresseParticiant,
						    $codePostalParticipant,
						    $villeParticipant,
						    $paysParticipant,
						    $emailParticipant
						);

						// Traitement des retours
						if( $genererFacture === "success" ){
							// On insère les données de la facture dans la table user_file
							$numFact = str_replace ("/", "_",  $numeroFacture);
							$insertDataUsersFile =  $wpdb->insert( 
								$wpdb->base_prefix."atoutcom_users_file",
								array( 
									'email'  => $userEmail,
									'fichier' => 'Facture_'.$numFact,
									'chemin' => 'Facture_'.$numFact.'.pdf',
									'date_enregistrement' => date("Y-m-d H:i:s"),
									'type_doc' => 'facture',
								), 
								array( 
									'%s',
									'%s',
									'%s',
									'%s',
									'%s',
								) 
							);
                            wp_die(wp_json_encode("successFactureMail"));
						}

						// Traitement des retours
						if( $genererFacture === "errorMail" ){
							wp_die(wp_json_encode("errorMail"));
						}

						// Traitement des retours
						if( $genererFacture === "error"){
							wp_die(wp_json_encode("errorGenFacture"));
						}
				    }else{
				    	// Erreur base de données Facture
				    	wp_die(wp_json_encode("errorDBFacture"));
				    }

                }else{
                    //User not found in events
                    wp_die(wp_json_encode("errorUserNotFoundEmail"));
                }
		    }else{
		    	wp_die(wp_json_encode("errorUserNotFoundEvent"));
		    }             
        }else{
           wp_die(wp_json_encode("successStatus")); 
       }	
	}else{
		wp_die(wp_json_encode("errorDBStatus"));
	}
    
    //wp_die();
}
add_action( 'wp_ajax_updateUserStatus', 'updateUserStatus' );
add_action( 'wp_ajax_nopriv_updateUserStatus', 'updateUserStatus' );