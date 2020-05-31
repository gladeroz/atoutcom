<?php
    /*$to = 'barreaultj@gmail.com';
	$subject = 'Test Atoutcom Facture';
	$body = 'Email de test depuis Atoutcom PPROD';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $body, $headers, $attachments );*/
	 
    include ( 'TCPDF/tcpdf.php');   
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
    // set default font subsetting mode
	$pdf->setFontSubsetting(true);

	$pdf->SetFont('dejavusans', '', 14, '', true);
    
    // disable header and footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	// Add a page
	// This method has several options, check the source code documentation for more information.
	$pdf->AddPage();

	// set text shadow effect
	$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    
    // Fichier CSS 
    $html = '<style>'.file_get_contents(plugins_url().'/atoutcom-users/app/public/css/facture.css').'</style>';
	// Contenu du document
	$html .= '
	<div class="header">
        <span class="headerGras">AGENCE ATOUTCOM.COM</span>
        <span class="headerNonGras">
            Organisation de Congrès & d\'Événements
        </span>
	</div>

    <div class="adresseAgence">
	    <table width="190" align="right" id="tableAdresseAgence">
	        <tr>
		        <td>
		            <span class="adresseGras adresse">Agence ATouT.Com</span><br>
					<span class="adresse">Le Tertia 1</span><br>
					<span class="adresse">5, Rue Charles Duchesne</span><br>
					<span class="adresse">13290 Aix en Provence</span><br>
					<span class="adresseGras adresse">Personne à contacter:</span><br>
					<span class="adresse">Christelle Noccela</span><br>
					<span class="adresse">04 42 54 42 60 - gyneco@atoutcom.com</span>
		        </td>
	        </tr>
	    </table>
    </div>

	<div class="adresseFacturation">

	</div>
	';

	// Print text using writeHTMLCell()
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

	// ---------------------------------------------------------

	//$pdf->Output('Facture_test.pdf', 'I');
	$pdf->Output(__DIR__.'/Factures/test.pdf', 'F');

	if(file_exists( __DIR__.'/Factures/test.pdf' )){
		echo "Ok";
		$attachments = array( __DIR__.'/Factures/test.pdf' );
	    if(wp_mail( $to, $subject, $body, $headers, $attachments )){
            echo "Mail envoyé avec succès";
	    }else{
	    	echo "Mail non envoyé";
	    }
	    
	} else {
	    echo "fail";
	}
?>