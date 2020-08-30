<?php 
    global $wpdb;
    
    /*$alter = $wpdb->get_var( "ALTER TABLE ".$wpdb->base_prefix."atoutcom_users_events_facture MODIFY COLUMN montantTVA decimal(10,2)", ARRAY_A);*/
    var_dump(atoutcomUser::getCategorie('harouguindja@gmail.com'));die();

    $updateUser = $wpdb->update( 
	    $wpdb->base_prefix."atoutcom_users_events_facture",
	    array( 
	        'montantTVA'  => 3.50,
			'concerne' => 'participant'
	    ), 
	    array(
	        'destinataire' => 'Giga Florent',
	    )
	);
    
    //var_dump($updateUser);die();

	$dataUsersEventsFacture = $wpdb->get_results( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_users_events_facture WHERE destinataire = 'Giga Florent'", ARRAY_A);
    var_dump($dataUsersEventsFacture);die();

    $genererFacture = genererFacture(
	    'en',
	    'Harou Guindja', 
	    '510 Avenue de Bagatelle',
	    '13090, Aix en Procence, France',
	    '207099',
	    date("d/m/Y"),
	    'Nidcap',
	    '25 Septembre 2020<br>Marseille',
	    'Test',
	    '1',
	    '31,5',
	    '3,5',
	    '35',
	    date("d/m/Y"),
	    'harouguindja@gmail.com',
	    'Harou',
	    '510 Avenue de Bagatelle',
	    '10',
	    '',
	    'acquittée'
	);
	var_dump($genererFacture);
	die();
    /*$dataUserInfo = atoutcomUser::dataUser($email, "participant");
    var_dump($dataUserInfo->nom);die();
	$wpsite = get_sites();

	//Tableau contenant tous les form_id des formulaires contenant un label clé appélé events_atoucom
	$tabFormId = array();
	//Tableau contenant les labels d'un formulaire
	$tabLabel = array();
	// Tableaux des labels des formulaires
	$tabForms = array();
	// Tableau contenant le label, le meta_key, le meta_value des fromulaire
	$tabLabelsKeyValue = array();

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

	var_dump($tabForms);*/
?>

