<?php
/*
Template Name: passerelle de retour SOGENACTIF
*/

include ( ABSPATH.'wp-content/plugins/atoutcom-users/app/public/lib/dompdf/autoload.inc.php');   
// reference the Dompdf namespace
use Dompdf\Dompdf;

global $wpdb;
$appPublic = ABSPATH.'wp-content/plugins/atoutcom-users/app/public/';

try {
	// Transaction ID retourné par sogecommerce
	$transaction_id = $_POST["vads_trans_id"];
	$prefix  = ($_POST["vads_ext_info_site_id"] != 0) ? $wpdb->base_prefix . sanitize_text_field($_POST["vads_ext_info_site_id"]) . '_' : $wpdb->base_prefix;
	
	//On récupère les variables qui nous permettent de retrouver la personne
	$getData = $wpdb->get_row( "SELECT * FROM ".$prefix."gf_entry WHERE transaction_id = '".$transaction_id."' ");
	
	if(is_null($getData)) throw new Exception("La transaction id n'a pas été trouvé (siteid : " . $prefix . "; transaction_id : ".$transaction_id.")");
	
	$entry_id = $getData->id;
	$form_id = $getData->form_id;
	
	$updateUser = $wpdb->update( 
		$prefix."gf_entry",
		array( 
			'payment_status' => $_POST['vads_trans_status']
		), 
		array(
			'id' => $entry_id,
			'form_id' => $form_id,
		)
	);

	// On récupère à présent toutes les information de la personne qui a effectué la transaction afin d'éditer sa facture
	$dataUserEvent = atoutcomUser::formsEvents("listeEventsForUsers");
	if(is_null($dataUserEvent)) throw new Exception("Aucunes données sur les evenements  n'a été trouvé");
	
	foreach ($dataUserEvent as $form) {		
		if( $form["entry_id"] == strval ( $entry_id ) ){
			$tabEntry = $form;
			break;
		}
	}

	$maxID = atoutcomUser::getMaxIdFacture();
	if($maxID === NULL || $maxID === ""){
		$maxID = 0;
	}

	$numero = $maxID +1;

	// Tableau des valeurs
	$params = $tabEntry["data"][0];

	//On choppe les info de la personne et voir si elle a une adresse de facturation
	$userInfo = $wpdb->get_row( "
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
	    email ='".$params['Email Professionnel']."' 
	");
	
	// Evenement
	$intitule = $tabEntry["evenement"];
	$dateDebut = atoutcomUser::dateFrFacture($params["Date Debut Evenement"], false);
	$dateFin = atoutcomUser::dateFrFacture($params["Date Fin Evenement"], false);

	$jrDebut = $dateDebut->format("d");
	$moisDebut = $dateDebut->format("m");
	$anneeDebut = $dateDebut->format("Y");

	$jrFin = $dateFin->format("d");
	$moisFin = $dateFin->format("m");
	$anneeFin = $dateFin->format("Y");

	//Date evenement texte
	if($dateDebut === $dateFin){
		$dateEvenement = $dateDebut;
	}else{
		//si les années sont identiques
		if($anneeDebut === $anneeFin){
			//$dateEvenement = $jrDebut."/".$moisDebut." - ".$jrFin."/".$moisFin." ".$anneeDebut;
			if( $moisDebut === $moisFin ){
                $dateEvenement = $jrDebut." - ".$jrFin." ".$moisDebut." ".$anneeDebut;
            }else{
                $dateEvenement = $jrDebut." ".$moisDebut." - ".$jrFin." ".$moisFin." ".$anneeDebut;
            }
		}else{
			$dateEvenement = $dateDebut." - ".$dateFin;
		}
	}
	$numeroFacture = $numero."".$periode."/".$jrDebut."".$moisDebut;
	$numFact = str_replace ("/", "_",  $numeroFacture);
	$codePostalEvt = $params["Code postal Evenement"];
	$adresseEvt = $params["Adresse Evenement"];
	$villeEvt = $params["Ville Evenement"];
	$paysEvt = $params["Pays Evenement"];
	$organisateur = $params["Organisateur Evenement"];
	$specialite = $params["Specialite Evenement"];

	$jourEvenement = $jrDebut;
	$moisEvenement = $moisDebut;
	$periode = $anneeFin;

	$numeroFacture = $numero."".$periode."/".$jourEvenement."".$moisEvenement;

	$dateFacture = date('d/m/Y');    
	$datePaiement = $dateFacture;
	
	// $nom = $params["Nom"];
	// $prenom = $params["Prenom"];
	$participant = $params["Nom"]." ".$params["Prenom"];
	$adresseParticiant = $params["Adresse"];
	$codePostalParticipant = $params["Code postal"];
	$villeParticipant = $params["Ville"];
	$paysParticipant = $userInfo->pays;
	$emailParticipant = $params["Email Professionnel"];
	
	//participant & adresse facturation
	if($userInfo->organisme_facturation === "" || $userInfo->organisme_facturation == NULL){
        $email = $params["Email Professionnel"];
		$destinataire = $participant;
		$adresseFacturation = $adresseParticiant;
		$codepostalFacturation = $codePostalParticipant;
		$villeFacturation = $villeParticipant;
		$paysFacturation =  $paysParticipant;
		$codepostalVille = $codepostalFacturation.", ".$villeFacturation.", ".$paysFacturation;
	}else{
        $email = $userInfo->email_facturation;
		$destinataire = $userInfo->organisme_facturation;
		$adresseFacturation = $userInfo->adresse_facturation;
		$codepostalFacturation = $userInfo->codepostal_facturation;
		$villeFacturation =  $userInfo->ville_facturation;
		$paysFacturation =  $userInfo->pays_facturation; 
		$codepostalVille = $codepostalFacturation.", ".$villeFacturation.", ".$paysFacturation;
	}
	
	$telephone_fixe = $params["Telephone Professionnel"];
	$telephone_mobile = $params["Telephone Professionnel"];
	$contact_adresse = $params["Contact Adresse"];
	$contact_nom = $params["Contact Nom"];

	$participation = number_format($_POST["vads_amount"]/100, 2);
	$aka_tauxTVA = "10%";
	$montantTVA = number_format($participation*0.1, 2);
	$montantHT = number_format($participation-$montantTVA, 2);
	$montantTTC = number_format($participation, 2);
	$montantNET = number_format($participation, 2);
	$total = number_format($participation, 2);
	$accompte = number_format(0, 2);
	$restedu = number_format(0, 2);
	$paye = $participation;
	$encaisse = $participation;
	$quantite = "1";
	$commentaire = "";
	$concerne = "Participant";
	$modePaiement = $params["paiement"];
	
	// On insère les donnée de la facture dans la table 
	$insertDataFacture =  $wpdb->insert( 
		$wpdb->base_prefix."atoutcom_users_events_facture",
		array( 
			'periode'  => $periode,
			'numero' => $numeroFacture,
			'date_facture' => $dateFacture,
			'destinataire' => $destinataire,
			'intitule' => $intitule,
			'specialite' => $specialite,
			'annee' => $periode,
			'montantHT' => $montantHT,
			'aka_tauxTVA' => $aka_tauxTVA,
			'montantTVA' => $montantTVA,
			'montantTTC' => $montantTTC,
			'montantNET' => $montantNET,
			'total' => $total,
			'accompte' => $accompte,
			'restedu' => $restedu,
			'paye' => $paye,
			'encaisse' => $encaisse,
			'date_reglement' => $dateFacture,
			'modePaiement' = $modePaiement,
			'commentaire' => $commentaire,
			'concerne' => $concerne,
		), 
		array( 
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
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
            '%s',
		) 
	);

	/**
	* Edition de la fature du participant
	*/
	if($insertDataFacture){
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
	                        <span class="adresseGras">'.$participant.'</span><br>
	                        <span>'.$adresseParticiant.'</span><br>
	                        <span>'.$codepostalVille.'</span><br>
	                        <span class="adresseGras">'.$emailParticipant.'</span>
	                        <span class="espace">xxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span>
	                    </div>
						
						<div class="adresseFacturation">
							<span class="adresseSouligneTitre">Adresse de Facturation</span>
							<br><br>
							<span class="adresseGras">'.$destinataire.'</span><br>
							<span class="">'.$adresseFacturation.'</span><br>
							<span class="">'.$codePostalVille.'</span><br><br>
							<span class="adresseSouligneTVA">N° TVA Intracommunautaire</span><br>
							<span class="espace">xxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span>
						</div>
					</div>

					<div class = "logo_facture_acq">
	                    <img src="'.ABSPATH.'wp-content/plugins/atoutcom-users/app/public/images/facture_acq.png">
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
							<td class="withBorder" width="100%" style="border-right: none;">
								<span class="adresseGras titreCongres">'.$intitule.'</span><br>
								<span class="adresseGras dateAdresseCongres">'.$dateEvenement.'<br>'.$villeEvt.'</span><br>
								<span>'.$nom.' '.$prenom.'</span>
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
								';
	                            if($modePaiement == ""){
	                                $html .= '<span class="adresseGras">Chèque ou Virement Bancaire</span>';
	                            }else{
	                                $html .= '<span class="adresseGras">'.$modePaiement.'</span>';
	                            }
	                            $html .= '
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
					<img src="'.$appPublic.'images/logoAtoutcom.png">
				</footer>
			</body>
		</html>'; 

		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$pathPdf = $appPublic.'uploads/'.$email;
		$fichierPDF = $pathPdf.'/Facture_'.$numFact.'.pdf';
		$pdf_gen = $dompdf->output();
		
		if (!is_dir($pathPdf)) {
		  // dir doesn't exist, make it
		  mkdir($pathPdf);
		}

		if(file_put_contents($fichierPDF, $pdf_gen)){
			//En local pas d'envoie de mail
			if( strpos($_SERVER["SERVER_NAME"], "localhost") !== false){
				$retour = "success";
			}else{
				$attachments = array( $fichierPDF );
				$subject = 'Facture';
				$body = '
		        <p>Chère Madame, Cher Monsieur,</p>

		        Vous trouverez ci-joint la facture acquittée pour votre inscription.<br><br>

		        Nous restons à votre disposition pour toute information complémentaire,<br><br>

		        Bien à vous,<br>
		        Agence ATouT.Com<br>
		        Tel : 04 42 54 42 60<br>
		        www.atoutcom.com<br><br>
		        <img src="https://atoutcom.com/wp-content/plugins/atoutcom-users/app/public/images/logoAtoutcom.png">
		        ';
				$headers = array('Content-Type: text/html; charset=UTF-8');
				if(wp_mail( $email, $subject, $body, $headers, $attachments )){
					
					// On insère les données de la facture dans la table user_file
					$insertDataUsersFile =  $wpdb->insert( 
						$wpdb->base_prefix."atoutcom_users_file",
						array( 
							'email'  => $email,
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
					//Si Mail envoyé + facture insérée dans user_file
					if($insertDataUsersFile){
						$retour = "Mail envoyé à ".$destinataire." ".$email." avec facture en PJ, le : ".$datePaiement." Données insérée avec succès dans la table user_file\n";
					}else{
						$retour = "Mail envoyé à ".$destinataire." ".$email." avec facture en PJ, le : ".$datePaiement." Données non insérée dans la table user_file\n";
					}
				}else{
					$retour = "Le Mail n'a pas été envoyé le : ".$datePaiement." pour : ".$destinataire." ".$email."\n";
				}
			}
		}else{
			$retour = "Le fichier n'a pas été généré le : ".$datePaiement." pour : ".$destinataire."\n";
		}      
	}else{
		$retour = "Erreur de base de données lors de l'insertion des données de facturation en date du : ".$datePaiement." pour : ".$destinataire."\n";
	}

	// On met les résultats dans le fichier de log

	$cheminDuFichier = $appPublic.'uploads/passerelle_retour.txt';
	if(!is_file($cheminDuFichier)){
		$fichierRetour = fopen($cheminDuFichier, 'a+') or die("Unable to open file!");
		$fichierRetour="\xEF\xBB\xBF".$fichierRetour; // this is what makes the magic
		fclose($fichierRetour);
	}

	$fichierRetour = fopen($cheminDuFichier, 'a+') or die("Unable to open file!");
	fwrite($fichierRetour, $retour);
	fclose($fichierRetour);

} catch (Exception $e) {
	$fichierRetour = fopen($appPublic.'uploads/error.txt', 'a+') or die("Unable to open file!");
	$error = $e->getMessage()."\n";
	fwrite($fichierRetour, $error);
	fclose($fichierRetour);
}



