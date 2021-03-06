<?php
   
    require(ABSPATH . 'wp-load.php');
	session_start();
	
	class atoutcomUser extends MvcModel
	{

	    public function dataUser($email, $categorie)
	    {
	    	global $wpdb;
	    	$dataUserInfo = $wpdb->get_row( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users WHERE email ='".$email."' and categorie='".$categorie."' ");
	    	return $dataUserInfo;
	    }

	    // Retourner la catégorie d'un utilisateur
	    public function getCategorie($email)
	    {
	    	global $wpdb;
	    	$categorie = $wpdb->get_var("SELECT categorie FROM ".$wpdb->base_prefix."atoutcom_users WHERE email ='".$email."'");
	    	return $categorie;
	    }

        // Récupérer l'adresse de facturation
        public function adresseFacturation($email, $categorie)
	    {
	    	global $wpdb;
	    	$userFacturation = $wpdb->get_row( "
				SELECT
				    pays,
				    organisme_facturation,
				    email_facturation,
				    adresse_facturation,
				    ville_facturation,
		            codepostal_facturation,
		            pays_facturation
			    FROM 
			        ".$wpdb->base_prefix."atoutcom_users 
			    WHERE 
			        email ='".$email."' 
			    AND
			        categorie ='".$categorie."'
			");
	    	return $userFacturation;
	    }

        public function getAllUsers()
        {
        	global $wpdb;
        	$dataUser = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users WHERE categorie IN('Participant', 'Intervenant')", ARRAY_A);
        	return $dataUser;
        }
	    public function dataUserFile($email, $type)
	    {
	    	global $wpdb;
            $dataUserFile = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users_file WHERE email ='".$email."' AND type_doc='".$type."'", ARRAY_A);
            return $dataUserFile;
	    }

	    public function dataUserFileForAdmin($email)
	    {
	    	global $wpdb;
            $dataUserFileForAdmin = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users_file WHERE email ='".$email."' AND type_doc='user' ", ARRAY_A);
            return $dataUserFileForAdmin;
	    }

        public function deleteUserFile($id)
	    {
	    	global $wpdb;
            //$dataUserDelete = $wpdb->get_results( "DELETE FROM ".$wpdb->prefix."atoutcom_users_file WHERE id ='".$id."' ");
            $dataUserDelete = $wpdb->delete( $wpdb->base_prefix.'atoutcom_users_file', array( 'id' => $id ) );
            return $dataUserDelete;
	    }
        
        //Selectionner l'évenement de l'utilisateur connecté 
	    public function getMyEvents($entry_id){
	    	global $wpdb;
            $dataMyEvents = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."gf_entry_meta WHERE entry_id =".$entry_id." ", ARRAY_A);
            return $dataMyEvents;
	    }
        
        // Selectionner tous les évenements  
	    /*public function getUsersEvents(){
	    	global $wpdb;
            $dataUsersEvents = $wpdb->get_results( "SELECT meta_value FROM ".$wpdb->prefix."gf_entry_meta WHERE form_id IN (2, 12, 13)", ARRAY_A);
            return $dataUsersEvents;
	    }*/

	    // Selectionner toutes les factures
	    public function getUsersEventsFacture($parametre){
	    	global $wpdb;
	    	if ($parametre === "all") {
	    		$dataUsersEventsFacture = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users_events_facture", ARRAY_A);
	    	}else{
	    		$dataUsersEventsFacture = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users_events_facture where concerne like '%".$parametre."%' ", ARRAY_A);
	    	}
            
            return $dataUsersEventsFacture;
	    }
        
        //getMaxIdFacture
        public function getMaxIdFacture(){
	    	global $wpdb;
            $dataMaxIdFacture = $wpdb->get_var("
                SELECT id
                FROM ".$wpdb->base_prefix."atoutcom_users_events_facture 
                ORDER BY id DESC limit 0,1
            "
            );
            return $dataMaxIdFacture;
	    }

	    // Chercher l'intervenant avec l'evenement
	    public function checkExistIntervenant($event, $email, $categorie){
	    	global $wpdb;
            $dataCheck = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users WHERE email='".$email."' AND evenement='".$event."' AND categorie='".$categorie."' ", ARRAY_A);
            return $dataCheck;
	    }

	    // Récupérer tous les intervenants
	    public function getAllIntervenants(){
	    	global $wpdb;

            $dataGetIntervenants = $wpdb->get_results( "SELECT nom, prenom, email, telephone_professionnel, adresse, codepostal, ville, pays, evenement, DATE_FORMAT(date_evenement, '%d/%m/%Y') AS date_evenement FROM ".$wpdb->base_prefix."atoutcom_users WHERE categorie = 'Intervenant'", ARRAY_A);

            return $dataGetIntervenants;
	    }

	    /* 
	     * Retourner toutes les entrées des formulaires
	     * $param : represente un paramètre qui permet de distinguer une liste sur la partie sponsor ou participant
	     * $email : represent l'email de la personne connectée, dans ce cas on renvoie le tableau des evenements de l'utilisateur connecté
	    */
	    public function formsEvents($param){
			global $wpdb;
				
			$base = $wpdb->base_prefix;
			$prefix = $wpdb->prefix;
			$wpsite = get_sites();
		
			//Tableau contenant tous les form_id des formulaires contenant un label clé appélé events_atoucom
			$tabFormId = array();
			//Tableau contenant les labels d'un formulaire
			$tabLabel = array();
			// Tableaux des labels des formulaires
			$tabForms = array();
			// Tableau contenant le label, le meta_key, le meta_value des fromulaire
			$tabLabelsKeyValue = array();
			
			$wpdb->prefix = $base;
			$forms = GFAPI::get_forms();
			// Chargement des données dans $tabFormId : on filtre les formulaire pour ne chopper que les form_id des events
			foreach ($forms as $form) {
				for ($i=0; $i < sizeof( $form ); $i++ ) {
					$label = $form['fields'][$i]['label'];
					if( $label === "events_atoutcom"){
						$form_id = $form['fields'][$i]['formId'];
						array_push($tabFormId, $form_id);
						break;
					}
				}
			}
			
			// A partir du tableau des form_id, on choppe les labels les meta_key et les form_id et on les mets dans le tableau des labels
			foreach( $tabFormId as $formid){
				$form = GFAPI::get_form( $formid );
				$entries = GFAPI::get_entries($formid);


				foreach ($entries as $entrie) {
					$tabLabel=array();
					$transaction_id = $entrie['transaction_id'];
					$payment_status = $entrie['payment_status']; 
					foreach ($form['fields'] as $field) {
						$label = $field['label'];
						$meta_key = $field['id'];
						$form_id = $field['formId'];

						if( $label != NULL){
							array_push(
								$tabLabel, 
								array( 
									$label => $entrie[$meta_key], 
									"blog_id" => 0, 
									"meta_key" =>$meta_key, 
									"entry_id" =>$entrie["id"], 
									"form_id" => $form_id,
									"payment_status" => $payment_status,
									"transaction_id" => $transaction_id
								)
							);
						}
					}
					$tabForms[0][$form_id][$entrie["id"]] = $tabLabel;
				}
			}
	
			foreach($wpsite as $blog) {
				$tabFormId = array();
			
		        $blog_id = (int)$blog->blog_id;
		        switch_to_blog($blog_id);
				$forms = GFAPI::get_forms();

				// Chargement des données dans $tabFormId : on filtre les formulaire pour ne chopper que les form_id des events
				foreach ($forms as $form) {
					for ($i=0; $i < sizeof( $form ); $i++ ) {
						$label = $form['fields'][$i]['label'];
						if( $label === "events_atoutcom"){
							$form_id = $form['fields'][$i]['formId'];
							array_push($tabFormId, $form_id);
							break;
						}
					}
				}
				
				// A partir du tableau des form_id, on choppe les labels les meta_key et les form_id et on les mets dans le tableau des labels
				foreach( $tabFormId as $formid){
					$form = GFAPI::get_form( $formid );
					$entries = GFAPI::get_entries($formid);
					
					foreach ($entries as $entrie) {
						$tabLabel=array();
						$transaction_id = $entrie['transaction_id'];
						$payment_status = $entrie['payment_status'];
						 
						foreach ($form['fields'] as $field) {
							$label = $field['label'];
							$meta_key = $field['id'];
							$form_id = $field['formId'];

							if( $label != NULL){
								array_push(
									$tabLabel, 
									array( 
										$label => $entrie[$meta_key], 
										"blog_id" =>$blog_id, 
										"meta_key" =>$meta_key, 
										"entry_id" =>$entrie["id"], 
										"form_id" => $form_id,
										"payment_status" => $payment_status,
										"transaction_id" => $transaction_id,
									)
								);
							}
						}
						$tabForms[$blog_id][$form_id][$entrie["id"]] = $tabLabel;
					}
				}
				
				restore_current_blog();
			}

		    /*
		    * Si param vaut listeEventsForSponsors on retourne la liste des évenements en encodant le tableau data pour le traitement JS
		    * Si param vaut listeEventsForUsers on retourne la liste des évenements sans encoder le tableau data pour le traitement PHP 
		    */
		    if( $param === "listeEventsForSponsors" || $param === "listeEventsForUsers" ){
		    	$blogs = $tabForms;
		    	$listEvents = array();
				foreach ($blogs as $blog) {
					foreach ($blog as $form) {
						$listEvent=array();
						foreach ($form as $entries) {
							foreach ($entries as  $entry) {
								$dataEvt = array();
								// evenement titre
								if($entry["Titre"]!=NULL){
									$evenement = $entry["Titre"];
									$form_id = $entry["form_id"];
									$entry_id = $entry["entry_id"];
									$blog_id = $entry["blog_id"];
									$total = $entry["total"];
									$payment_status = $entry["payment_status"];  
									$transaction_id = $entry["transaction_id"];        									
								}
								
								// Paiement
								if($entry["Paiement"] != NULL){
									$paiement = $entry["Paiement"];
								}

                                // Organisateur
								if($entry["Organisateur"] != NULL){
									$organisateur = $entry["Organisateur"];
								}

								// Spécialité
								if($entry["SpécialitéEvt"] != NULL){
									$specialite = $entry["SpécialitéEvt"];
								}
								
								// Date début
								if($entry["DateDebut"] != NULL){
									$dateDebut = $entry["DateDebut"];
								}
								
								// Date fin
								if($entry["DateFin"] != NULL){
									$dateFin = $entry["DateFin"];
								}

								// code Postal
								if($entry["CodePostalEvt"] != NULL){
									$codePostal = $entry["CodePostalEvt"]; 
								}

								// Adresse
								if($entry["AdresseEvt"] != NULL){
									$adresse = $entry["AdresseEvt"];
								}

								// Ville
								if($entry["VilleEvt"] != NULL){
									$ville = $entry["VilleEvt"];
								}

								// Pays
								if($entry["PaysEvt"] != NULL){
									$pays = $entry["PaysEvt"];
								}

								// Contact Nom
								if($entry["Contact Nom"] != NULL){
									$contact_nom = $entry["Contact Nom"];
								}

								// Contact Adresse
								if($entry["Contact Adresse"] != NULL){
									$contact_adresse = $entry["Contact Adresse"];
								}
								
								//Users
								// Nom
								if($entry["Nom"] != NULL || $entry["Last Name"] != NULL){
									$nom = ($entry["Nom"] != NULL)  ?  $entry["Nom"] : $entry["Last Name"];                
								}

								// Prénom
								if($entry["Prénom"] != NULL || $entry["First Name"] != NULL){
									$prenom = ($entry["Prénom"] != NULL)  ?  $entry["Prénom"] : $entry["First Name"];                    
								}

								// Email
								if($entry["Email Professionnel"] != NULL || $entry["Professional E-mail"] != NULL){
									$email = ($entry["Email Professionnel"] != NULL)  ?  $entry["Email Professionnel"] : $entry["Professional E-mail"];                  
								}

								// Adresse User
								if($entry["Adresse"] != NULL || $entry["Address"] != NULL){
									$adresseUser = ($entry["Adresse"] != NULL)  ?  $entry["Adresse"] : $entry["Adress"];                
								}

								// Code postal User
								if($entry["Code Postal"] != NULL || $entry["Zip Code"] != NULL){
									$codepostalUser = ($entry["Code Postal"] != NULL)  ?  $entry["Code Postal"] : $entry["Zip Code"];                  
								}

								// Ville User
								if($entry["Ville"] != NULL || $entry["City"] != NULL){
									$villeUser = ($entry["Ville"] != NULL)  ?  $entry["Ville"] : $entry["City"];                  
								}

								// Pays User
								if($entry["Pays"] != NULL || $entry["Country"] != NULL){
									$paysUser = ($entry["Pays"] != NULL)  ?  $entry["Pays"] : $entry["Country"];                  
								}

								// Tél. Professionnel
								if($entry["Téléphone Professionnel"] != NULL || $entry["Professional Phone"] != NULL){
									$telProfessionnel = ($entry["Téléphone Professionnel"] != NULL)  ?  $entry["Téléphone Professionnel"] : $entry["Professional Phone"];                  
								}

								// Stockage des datas  
								$dataEvt[] = 
								array(
									"Date Debut Evenement" => $dateDebut,
									"Date Fin Evenement" => $dateFin,
									"Code postal Evenement" => $codePostal,
									"Adresse Evenement" => $adresse,
									"Ville Evenement" => $ville,
									"Pays Evenement" => $pays,
									"Contact Nom" => $contact_nom,
									"Contact Adresse" => $contact_adresse,
									"Organisateur Evenement" => $organisateur,
									"Specialite Evenement" => $specialite,
									"Nom" => $nom,
									"Prenom" => $prenom,
									"Email Professionnel" => $email,
									"Adresse" => $adresseUser,
									"Code postal" => $codepostalUser,
									"Ville" => $villeUser,
									"Telephone Professionnel" => $telProfessionnel,
									"Pays" => $paysUser,
									"payment_status" => $payment_status,
									"transaction_id" => $transaction_id,
									"form_id" => $form_id,
									"paiement" => $paiement
								);
								
								// Distinguer sponsor (Jquery) et user (php). Les tableaux ne réagissent pas de la même façon
								if( $param === "listeEventsForUsers" ){
									$dataEvtFinal = $dataEvt;
								}else{
									$dataEvtFinal = wp_json_encode($dataEvt);
								}
								// Si $emailUserEvent n'est pas vide, on teste si l'email a été enregistré sur un evenement
								// Ici nous sommes sur une liste des evenements pour sponsors ou participants
								
								//pas de doublons
								$listEvent = array( 
									"evenement"=>$evenement, 
									"form_id"=>$form_id, 
									"entry_id"=>$entry_id, 
									"blog_id"=>$blog_id,
									"data"=>$dataEvtFinal 
								);
				
							} // Fin foreach entries
						    //si par de données dans le tableau $listEvent
							if( !empty($listEvent) ){
								array_push($listEvents, $listEvent);
								//continue;
							}
						} // Fin foreach form
					} // Fin foreach blog
				}
		    	return $listEvents;
		    }else{
                return $tabForms;
		    }
	    }

	    /*
		* Fonction dateFr
		* Sert à retourner le mois ou la date en français
		*/
		
		public function dateFrFacture($_date, $full){
			return DateTime::createFromFormat((($full == false) ? 'd/m/Y' :'Y-m-d H:m:s'), $_date);
		}
		
	    /*
		* Fonction dateFr
		* Sert à retourner le mois ou la date en français
		*/
		
		public function dateFr($_date, $mois){
		    $moisFr = "";
		    $dateFr = "";
		    if($_date ===""){
		        $_mois = $mois;
		    }else{
		        $_mois = substr($_date, 3, -5);
		    }

		    switch ($_mois) {
		        case '01':
		            $moisFr = "Janvier";
		            break;

		        case '02':
		            $moisFr = "Février";
		            break;

		        case '03':
		            $moisFr = "Mars";
		            break;
		        
		        case '04':
		            $moisFr = "Avril";
		            break;
		        
		        case '05':
		            $moisFr = "Mai";
		            break;
		        
		        case '06':
		            $moisFr = "Juin";
		            break;

		        case '07':
		            $moisFr = "Juillet";
		            break;

		        case '08':
		            $moisFr = "Août";
		            break;

		        case '09':
		            $moisFr = "Septembre";
		            break;

		        case '10':
		            $moisFr = "Octobre";
		            break;
		        
		        case '11':
		            $moisFr = "Novembre";
		            break;

		        default:
		            $moisFr = "Décembre";
		            break;        
		    }
		    // Si pas de date, on retourne le mois en Fr sinon la date en FR
		    if($_date ===""){
		        return $moisFr;
		    }else{
		        return substr($_date, 0, 2)." ".$moisFr." ".substr($_date, 6);
		    }
		}

		/*
		* Fonction dateEn
		* Sert à retourner le mois ou la date en anglais
		*/

		public function dateEn($_date, $mois){
		    $moisEn = "";
		    $dateEn = "";
		    if($_date ===""){
		        $_mois = $mois;
		    }else{
		        $_mois = substr($_date, 3, -5);
		    }

		    switch ($_mois) {
		        case '01':
		            $moisEn = "January";
		            break;

		        case '02':
		            $moisEn = "February";
		            break;

		        case '03':
		            $moisEn = "March";
		            break;
		        
		        case '04':
		            $moisEn = "April";
		            break;
		        
		        case '05':
		            $moisEn = "May";
		            break;
		        
		        case '06':
		            $moisEn = "June";
		            break;

		        case '07':
		            $moisEn = "July";
		            break;

		        case '08':
		            $moisEn = "August";
		            break;

		        case '09':
		            $moisEn = "September";
		            break;

		        case '10':
		            $moisEn = "October";
		            break;
		        
		        case '11':
		            $moisEn = "November";
		            break;

		        default:
		            $moisEn = "December";
		            break;       
		    }
		    // Si pas de date, on retourne le mois en Fr sinon la date en FR
		    if($_date ===""){
		        return $moisEn;
		    }else{
		        return substr($_date, 0, 2)." ".$moisEn." ".substr($_date, 6);
		    }
		}
	}