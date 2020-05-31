<?php 
    global $wpdb;
    var_dump(atoutcomUser::formsEvents("listeEventsForUsers")); die;
    
//$subsites = get_sites();
//var_dump($subsites);die();
//foreach( $subsites as $subsite ) {
//  $subsite_id = get_object_vars($subsite)["blog_id"];
 // $site_id = get_object_vars($subsite)["site_id"];
  //$subsite_name = get_blog_details($subsite_id)->blogname;
  //$wpdb->set_blog_id( $subsite_id, $site_id);
  //$forms = GFAPI::get_forms();
  //echo 'Site ID/Name: ' . $subsite_id . ' / ' . $subsite_name . ' Site ID : ' . $site_id . '<br>';

//}
    //var_dump("test");
    /*$attachments = array();
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $subject = 'Invoice';
    $body = 'Mail de test depuis atoutcom';
    $to = 'harouguindja@gmail.com';
    var_dump(wp_mail( $to, $subject, $body, $headers, $attachments ));die();
    $mailResult = wp_mail( $to, $subject, $body, $headers, $attachments );
    echo $mailResult;*/
    /*var_dump( trailingslashit( ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/Export_Atoutcom_'.$type.'.xlsx') );die();
    $retour = "Hello test d'ecriture\n";
    $cheminDuFichier = ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/passerelle_retour.txt';
    $fichierRetour = fopen($cheminDuFichier, 'a+') or die("Unable to open file!");
    if(fwrite($fichierRetour, $retour)){
        echo "Ok";
    }else{
        echo "Nok";
    }

    fclose($fichierRetour);*/
    /*$dataUser = atoutcomUser::formsEvents("listeEventsForUsers");
    $entry_id = 12;
    $form_id = 2;
    foreach ($dataUser as $key => $form) {
        if( $form["entry_id"] == strval ( $entry_id ) ){
            $tabEntry = $form;
        }
    }





    $form = GFAPI::get_form(4);
    //$entries = GFAPI::get_entries(4);
    $entrie = GFAPI::get_entry( 12 );
    $tabLabel=array();
    foreach ($form['fields'] as $field) {
        $label = $field['label'];
        $meta_key = $field['id'];
        $form_id = $field['formId'];
        $transaction_id = $field['transaction_id'];
        $payment_status = $field['payment_status']; 

        if( $label != NULL){

            array_push(
                $tabLabel, 
                array( 
                    $label => $entrie[$meta_key], 
                    "meta_key" =>$meta_key, 
                    "entry_id" =>$entrie["id"], 
                    "form_id" => $form_id,
                    "payment_status" => $payment_status,
                    "transaction_id" => $transaction_id
                )
            );
        }
    }
    var_dump($form['fields']);die();
    // $forms : 
    $forms = GFAPI::get_forms();
    //var_dump(GFAPI::get_entry( 12 ));die();
    //Tableau contenant tous les form_id des formulaires contenant un label clé appélé events_atoucom
    $tabFormId = array();
    //Tableau contenant les labels d'un formulaire
    $tabLabel = array();
    // Tableaux des labels des formulaires
    $tabLabels = array();
    // Tableau contenant le label, le meta_key, le meta_value des fromulaire
    $tabLabelsKeyValue = array();

    // Chargement des données dans $tabFormId : on filtre les formulaire pour ne chopper que les form_id des events
    foreach ($forms as $form) {
        for ($i=0; $i < sizeof( $form ); $i++ ) {
            $label = $form['fields'][$i]['label'];
            if( $label === "events_atoutcom"){
                $form_id = $form['fields'][$i]['formId'];
                array_push($tabFormId, $form_id);
            }
        }
    }
    
    // A partir du tableau des form_id, on choppe les labels les meta_key et les form_id et on les mets dans le tableau des labels
    foreach( $tabFormId as $formid){
        $form = GFAPI::get_form( $formid );
        $entries = GFAPI::get_entries($formid);
        foreach ($entries as $entrie) {
            $tabLabel=array();
            foreach ($form['fields'] as $field) {
                $label = $field['label'];
                $meta_key = $field['id'];
                $form_id = $field['formId'];
                $transaction_id = $field['transaction_id'];
                $payment_status = $field['payment_status'];
                //payment_status 
                if( $label != NULL){
                    //array_push($tabLabel, array("label" => $label, "meta_key" =>$meta_key, "meta_value" => $entrie[$meta_key], "entry_id" =>$entrie["id"], "form_id" => $form_id));
                    array_push(
                        $tabLabel, 
                        array( 
                            $label => $entrie[$meta_key], 
                            "meta_key" =>$meta_key, 
                            "entry_id" =>$entrie["id"], 
                            "form_id" => $form_id,
                            "payment_status" => $payment_status,
                            "transaction_id" => $transaction_id
                        )
                    );
                }
            }
            $tabLabels[$formid][$entrie["id"]] = $tabLabel;
        }
    }

    //var_dump(GFAPI::get_entries(2));die();
    // Liste des evenements
    $listEvents = array();
    foreach ($tabLabels as $form) {
        foreach ($form as $entries) {
            $listEvent=array();
            foreach ($entries as  $entry) {
                $data = array();
                // Date début
                if($entry["Date debut"] != NULL){
                    $dateDebut = $entry["Date debut"];
                }
                
                // evenement titre
                if($entry["Titre"]!=NULL){
                    $evenement = $entry["Titre"];
                    $form_id = $entry["form_id"];                    
                }

                // Date fin
                if($entry["Date fin"] != NULL){
                    $dateFin = $entry["Date fin"];
                }

                // code Postal
                if($entry["Code postal"] != NULL){
                    $codePostal = $entry["Code postal"];
                }

                // Adresse
                if($entry["Adresse de l'événement"] != NULL){
                    $adresse = $entry["Adresse de l'événement"];
                }

                // Ville
                if($entry["Ville de l'événement"] != NULL){
                    $ville = $entry["Ville de l'événement"];
                }

                // Pays
                if($entry["Pays de l'événement"] != NULL){
                    $pays = $entry["Pays de l'événement"];
                }

                // Organisateur
                if($entry["Organisateur"] != NULL){
                    $organisateur = $entry["Organisateur"];
                }

                // Spécialité
                if($entry["Spécialité"] != NULL){
                    $specialite = $entry["Spécialité"];
                }
                
                //Users
                // Nom
                if($entry["Nom"]!=NULL){
                    $nom = $entry["Nom"];                   
                }

                // Prenom
                if($entry["Prénom"]!=NULL){
                    $prenom = $entry["Prénom"];                   
                }

                // Email
                if($entry["Email"]!=NULL){
                    $email = $entry["Email"];                   
                }

                // Adresse User
                if($entry["Adresse"]!=NULL){
                    $adresseUser = $entry["Adresse"];                   
                }

                // Code postal User
                if($entry["Code postal"]!=NULL){
                    $codepostalUser = $entry["Code postal"];                   
                }

                // Ville User
                if($entry["Ville"]!=NULL){
                    $villeUser = $entry["Ville"];                   
                }

                // Tél. Fixe User
                if($entry["Tél. Fixe"]!=NULL){
                    $telFixe = $entry["Tél. Fixe"];                   
                }

                // Tél. Mobile User
                if($entry["Tel. Mobile"]!=NULL){
                    $telMobile = $entry["Tel. Mobile"];                   
                }
                // Stockage des datas 
                $data[] = 
                array(
                    "dateDebut" => $dateDebut,
                    "dateFin" => $dateFin,
                    "codePostalEvt" => $codePostal,
                    "adresseEvt" => $adresse,
                    "villeEvt" => $ville,
                    "paysEvt" => $pays,
                    "organisateur" => $organisateur,
                    "specialite" => $specialite,
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "email" => $email,
                    "adresseUser" => $adresseUser,
                    "codepostalUser" => $codepostalUser,
                    "villeUser" => $villeUser,
                    "telFixe" => $telFixe,
                    "telMobile" => $telMobile
                );
                //pas de doublons
                if( empty($listEvents) ){
                    $listEvent = array( "evenement"=>$evenement, "form_id"=>$form_id, "data"=>$data );
                }else{
                    foreach ($listEvents as $data){
                        if ($data['evenement'] != $evenement){
                            $listEvent = array( "evenement"=>$evenement, "form_id"=>$form_id, "data"=>$data );
                        }
                    }
                }  
            }
            //si par de données dans le tableau $listEvent
            if( !empty($listEvent) ){
                $listEvents[] =  $listEvent; 
            }        
        }
    }
    
    var_dump($listEvents); 
    echo "<br><br><br><br><br><br><br>";
    var_dump($tabLabels[2][13]); 
    die();

    $dateFin = $entry["Date fin"];
    $codePostal = $entry["Code postal"];
    $adresse = $entry["Adresse de l'événement"];
    $ville = $entry["Ville de l'événement"];
    $pays = $entry["Pays de l'événement"];
    $data[] = 
    array(
        "dateDebut" => $dateDebut,
        "dateFin" => $entry["Date fin"],
        "codePostal" => $entry["Code postal"],
        "adresse" => $entry["Adresse de l'événement"],
        "ville" => $entry["Ville de l'événement"],
        "pays" => $entry["Pays de l'événement"]
    );*/
    //var_dump(GFAPI::get_entry( 12 ));
    
    /*echo "<br><br><br><br><br><br><br>";
    var_dump( $tabLabels );
    echo "<br><br><br><br><br><br><br>";
    var_dump($entries);*/
/*
    $titreAdresse = "Harou Guindja";
    $adresseFacturation ="220, Avenue de la Recherche";
    $codePostalVille = "F-59120, Loos";

    $numeroFacture = "402020/2604";
    $numFact = str_replace ("/", "_",  $numeroFacture);
    $dateFacture = "22/01/2020";
    
    $evenement = "Congrès La Médecine de la Femme";
    $dateAdresse = "26 & 27 Mars 2020 Palais du Pharo à Marseille";
    $descriptionDetail= "Participation sous forme de : STAND 6M²";
    $quantite = "1";
    $montantHT = "1 900,00";
    $montantTVA = "380,00";
    $montantTTC = "2 280,00";
    $datePaiement = "22/02/2020";

    $emailContact = "harouguindja@gmail.com";

    $html='
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="'.plugins_url().'/atoutcom-users/app/public/css/facture.css">
        </head>
        <body>
            <div class="header">
                <span class="headerGras">AGENCE ATOUTCOM.COM</span>
                <span class="headerNonGras">
                   Organisation de  Congrès & d\'Événements
                </span>
            </div>
            <div class="factureEntete">
                <div class="adresse">
                    <div class="adresseAtoutcom">
                        <span class="adresseGras">Agence ATouT.Com</span><br>
                        <span class="">Le Tertia 1</span><br>
                        <span class="">5, Rue Charles Duchesne</span><br>
                        <span class="">13290 Aix en Provence</span><br>
                        <span class="adresseGras">Personne à contacter:</span><br>
                        <span class="">Christelle Noccela</span><br>
                        <span class="">04 42 54 42 60 - gyneco@atoutcom.com</span>
                    </div>
                    
                    <div class="adresseFacturation">
                        <span class="adresseSouligneTitre">Adresse de Facturation</span><span class="espace">Adresses</span><br><br>
                        <span class="adresseGras">'.$titreAdresse.'</span><br>
                        <span class="">'.$adresseFacturation.'</span><br>
                        <span class="">'.$codePostalVille.'</span><br><br>
                        <span class="adresseSouligneTVA">N° TVA Intracommunautaire</span><br>
                    </div>
                </div>

                <div class="factureDetail">
                    <span class="adresseGras factNum">FACTURE N° : </span>
                    <span class="espace">Espa</span>
                    <span class="factNumSouligne"><b>'.$numeroFacture.'</b></span>
                    <br><br>
                    <span class="adresseGras factDate">Date de Facturation : </span>
                    <span class="adresseGras">'.$dateFacture.'</span>
                    <br><br>
                    <span class="adresseGras factMonnaie">Monnaie :</span>
                    <span class="espace">Espace f act</span> 
                    <span class="adresseGras">EURO</span>
                </div>
            </div>

            <div class="factureData">
                <table width="100%">
                    <tr>
                        <td class="noBorder">Commande n°</td>
                        <td class="noBorder">DESCRIPTION</td>
                        <td class="noBorder">QUANTITÉ</td>
                        <td class="noBorder">MONTANT HT</td>
                        <td class="noBorder">TVA 20%</td>
                        <td class="noBorder">MONTANT TTC</td>
                    </tr>
                    <tr>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">/</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras titreCongres">'.$evenement.'</span><br>
                            <span class="adresseGras dateAdresseCongres">'.$dateAdresse.'</span><br>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras quantite">'.$quantite.'</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">'.$montantHT.'€</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">'.$montantTVA.'€</span>
                        </td>
                        <td class="withBorder">
                            <span class="factNumSouligne">'.$montantTTC.'€</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="infoBancaire">
                <table>
                    <tr>
                        <td class="noBorderBancaire">Informations bancaires :</td>
                        <td class="noBorder"></td>
                    </tr>
                    <tr>
                        <td class="withBorderBancaire" style="border-right: none;">
                            <span class="adresseGras">Date De Paiement : </span>
                            <span class="adresseGras">'.$datePaiement.'</span>
                            <br><br>

                            <span class="adresseGras">Mode de règlement : </span>
                            <span class="adresseGras">Chèque Ou Virement Bancaire</span>
                            <br><br>

                            <span class="adresseGras">Modalités :</span>
                            <br><br>
                            <span class="adresseGras modalite">
                            <i>
                                Pénalité de retard : Dans le cas où le paiement intégral n\'interviendrait pas à la date prévue par
                                les parties, seront exigibles conformément à l\'article L441-6 du Code de Commerce, une
                                indemnité calculée sur la base de trois fois le taux de l\'intérêt légal en vigueur ainsi qu\'une
                                indemnité forfaitaire pour frais de recouvrement de 40€.
                            </i>
                            </span>
                            <br>

                        </td>

                        <td class="withBorderBancaireLeft">
                            <span class="virBancaireSouligne">Par virement bancaire :</span>
                            <br>
                            <span>Banque : Société Générale</span>
                            <br>
                            <span>Adresse : Aix En Provence Les Milles</span>
                            <br>
                            <span>IBAN : FR76 3000 3000 3400 0211 1030 324</span>
                            <br>
                            <span>BIC : SOGEFRPP</span>
                            <br>
                            <span class="virBancaireSouligne">ou par chèque à l\'ordre de : ATouT.Com</span>
                            <br><br>
                            <span class="virBancaireSouligne">N° De T V A / I C </span><span>: Fr 444 80 089 515 000 47</span>
                        </td>
                    </tr>
                </table>
            </div>

            <footer>
                <img src="'.ABSPATH.'wp-content/plugins/atoutcom-users/app/public/images/logoAtoutcom.png">
            </footer>
        </body>
    </html>';
	//$html = ob_get_clean();
	include ( ABSPATH.'wp-content/plugins/atoutcom-users/app/public/lib/dompdf/autoload.inc.php');   
	// reference the Dompdf namespace
	use Dompdf\Dompdf;
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();

	$pdf_gen = $dompdf->output();

	if(file_put_contents(ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/'.$emailContact.'/Facture_'.$numFact.'.pdf', $pdf_gen)){
    	// Envoie du mail avec la pièce jointe
    	echo "Facture générée avec succès";
    	/*$attachments = array( __DIR__.'/Factures/invoice.pdf' );
	    if(wp_mail( $to, $subject, $body, $headers, $attachments )){
            echo "Mail envoyé avec succès";
	    }else{
	    	echo "Mail non envoyé";
	    }
	}else{
	    echo "La facture n'a pas été générée";
    }*/
?>

