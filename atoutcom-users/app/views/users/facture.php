<?php ob_start();?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" type="text/css" href="<?php echo plugins_url().'/atoutcom-users/app/public/css/facture.css' ?>">
	</head>
	<body>
		<div class="header">
            <span class="headerGras">AGENCE ATOUTCOM.COM</span>
            <span class="headerNonGras">
               Organisation de  Congrès & d'Événements
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
			    	<span class="adresseSouligneTitre">Adresse de Facturation</span><br><br>
					<span class="adresseGras">BAYER HEALTHCARE SAS</span><br>
					<span class="">220, Avenue de la Recherche</span><br>
					<span class="">F-59120 Loos</span><br><br>
					<span class="adresseSouligneTVA">N° TVA Intracommunautaire</span><br>
			    </div>
		    </div>

		    <div class="factureDetail">
		    	<span class="adresseGras factNum">FACTURE N° : </span>
		    	<span class="espace">Espa</span>
		    	<span class="factNumSouligne"><b>402020/2603</b></span>
		    	<br><br>
		    	<span class="adresseGras factDate">Date de Facturation : </span>
		    	<span class="adresseGras">22/01/2020</span>
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
        	        	<span class="adresseGras titreCongres">Congrès La Médecine de la Femme</span><br>
        	        	<span class="adresseGras dateAdresseCongres">26 & 27 Mars 2020 Palais du Pharo à Marseille</span><br>
        	        	<span class="adresseGras detailCongres">Participation sous forme de : STAND 6M²</span>
        	        </td>
        	        <td class="withBorder" style="border-right: none;">
        	        	<span class="adresseGras quantite">1</span>
        	        </td>
        	        <td class="withBorder" style="border-right: none;">
        	        	<span class="adresseGras">1900,00€</span>
        	        </td>
        	        <td class="withBorder" style="border-right: none;">
        	        	<span class="adresseGras">380,00€</span>
        	        </td>
        	        <td class="withBorder">
        	        	<span class="factNumSouligne">2280,00€</span>
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
                        <span class="adresseGras">22/01/2020</span>
        	        	<br><br>

        	        	<span class="adresseGras">Mode de règlement : </span>
                        <span class="adresseGras">Chèque Ou Virement Bancaire</span>
        	        	<br><br>

        	        	<span class="adresseGras">Modalités :</span>
        	        	<br><br>
        	        	<span class="adresseGras modalite">
                        <i>
                        	Pénalité de retard : Dans le cas où le paiement intégral n'interviendrait pas à la date prévue par
							les parties, seront exigibles conformément à l'article L441-6 du Code de Commerce, une
							indemnité calculée sur la base de trois fois le taux de l'intérêt légal en vigueur ainsi qu'une
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
                        <span class="virBancaireSouligne">ou par chèque à l'ordre de : ATouT.Com</span>
                        <br><br>
                        <span class="virBancaireSouligne">N° De T V A / I C </span><span>: Fr 444 80 089 515 000 47</span>
        	        </td>
        		</tr>
        	</table>
        </div>

        <footer>
            <img src="<?php echo ABSPATH.'wp-content/plugins/atoutcom-users/app/public/images/logoAtoutcom.png' ?>">
        </footer>
	</body>
</html>
<?php
	$html = ob_get_clean();
	include ( 'dompdf/autoload.inc.php');   
	// reference the Dompdf namespace
	use Dompdf\Dompdf;
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();

	$pdf_gen = $dompdf->output();

	if(!file_put_contents(__DIR__.'/Factures/test.pdf', $pdf_gen)){
	    echo 'Not OK!';
	}else{
	    echo 'OK';
    }
?>

