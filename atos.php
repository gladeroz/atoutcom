     <?php   	
$theme = $_GET['theme'];
$siteid = (int)$_GET['site_id'];
$site = $_GET['site'];
$lang =  $_GET['lang'];
$field_id = (int)$_GET['field_id'];
$form_id = (int)$_GET['form_id'];
$entry_id = (int)$_GET['entry_id'];
$prefix = (int)$_GET['prefix'];
$transaction_id = $prefix + $entry_id;

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');

$sql = "SELECT value FROM atoa_".$siteid."_rg_lead_detail WHERE form_id=".$form_id." AND lead_id=".$entry_id." AND field_number=".$field_id;
$inscr = $wpdb->get_var( $sql );
if($inscr === NULL){
	$sql = "SELECT meta_value FROM atoa_".$siteid."_gf_entry_meta WHERE form_id=".$form_id." AND entry_id=".$entry_id." AND meta_key=".$field_id;
	$inscr = $wpdb->get_var( $sql );
}

$inscr = number_format($inscr,2,".","");
$frais = $inscr * 0.0175;
$frais = number_format($frais,2,".","");
$total = $inscr + $frais;
$total = number_format($total,2,".","");
$data = $form_id."l".$siteid."l".$entry_id;

if($lang == 'fr')
echo '<div align="center"><p style="line-height:20px">Merci de bien vouloir choisir votre carte de paiement ci-dessous. Le montant total de votre inscription est de '.$total.'€</p><p>(inscription : '.$inscr.'€ + 1,75% de frais bancaires)</p></div>';
else
echo '<div align="center"><p style="line-height:20px">Please choose your payment method below. The total amount is '.$total.'€</p><p>(registration : '.$inscr.'€ + 1,75% bank charge)</p></div>';

	// code de test :
	//$parm="merchant_id=XXXXXXXX";
	// code de production :
	$parm="merchant_id=XXXXXXXX";
	
	$parm="$parm merchant_country=fr";
	$parm="$parm amount=".number_format($total,2,"","");
	$parm="$parm currency_code=978";

	$parm="$parm pathfile=/home/ataweb02/atoutcom.com/sogenactif/param/pathfilewp";
	//		Si aucun transaction_id n'est affect&Atilde;&copy;, request en g&Atilde;&copy;n&Atilde;&uml;re
	//		un automatiquement &Atilde;&nbsp; partir de heure/minutes/secondes
	//		R&Atilde;&copy;f&Atilde;&copy;rez vous au Guide du Programmeur pour
	//		les r&Atilde;&copy;serves &Atilde;&copy;mises sur cette fonctionnalit&Atilde;&copy;
	//
	$parm="$parm transaction_id=".$transaction_id;
	//		Affectation dynamique des autres param&Atilde;&uml;tres
	// 		Les valeurs propos&Atilde;&copy;es ne sont que des exemples
	// 		Les champs et leur utilisation sont expliqu&Atilde;&copy;s dans le Dictionnaire des donn&Atilde;&copy;es
	//
	$parm="$parm normal_return_url=http://atoutcom.com/".$site."/";
	$parm="$parm cancel_return_url=https://atoutcom.com/".$site."/";
	$parm="$parm automatic_response_url=https://atoutcom.com/auto.php";
if($lang == 'fr')
	$parm="$parm language=fr";
else
	$parm="$parm language=en";
	//		$parm="$parm payment_means=CB,2,VISA,2,MASTERCARD,2";
	//		$parm="$parm header_flag=no";
	//		$parm="$parm capture_day=";
	//		$parm="$parm capture_mode=";
	//		$parm="$parm bgcolor=";
	//		$parm="$parm block_align=";
	//		$parm="$parm block_order=";
	//		$parm="$parm textcolor=";
	//		$parm="$parm receipt_complement=";
	//		$parm="$parm caddie=mon_caddie";
	//		$parm="$parm customer_id=";
	//		$parm="$parm customer_email=";
	//		$parm="$parm customer_ip_address=";
	$parm="$parm data=".$data;
	//		$parm="$parm return_context=";
	//		$parm="$parm target=";
	//		$parm="$parm order_id=";
	//		Les valeurs suivantes ne sont utilisables qu'en pr&Atilde;&copy;-production
	//		Elles n&Atilde;&copy;cessitent l'installation de vos fichiers sur le serveur de paiement
	//
	// 		$parm="$parm normal_return_logo=";
	// 		$parm="$parm cancel_return_logo=";
	// 		$parm="$parm submit_logo=";   
	$parm="$parm logo_id=logoATOUTCOM.jpg";
	// 		$parm="$parm logo_id=";
	// 		$parm="$parm logo_id2=";
	// 		$parm="$parm advert=";
	// 		$parm="$parm background_id=";
	// 		$parm="$parm templatefile=";
	//		insertion de la commande en base de donn&Atilde;&copy;es (optionnel)
	//		A d&Atilde;&copy;velopper en fonction de votre syst&Atilde;&uml;me d'information
	// Initialisation du chemin de l'executable request (&Atilde;&nbsp; modifier)
	// ex :
	// -> Windows : $path_bin = "c:\\repertoire\\bin\\request";
	// -> Unix    : $path_bin = "/home/repertoire/bin/request";
	//
	$path_bin = "/home/ataweb02/atoutcom.com/sogenactif/bin/request_2.6.9_3.4.2";
	//	Appel du binaire request
	$result=exec("$path_bin $parm");

	//	sortie de la fonction : $result=!code!error!buffer!
	//	    - code=0	: la fonction g&Atilde;&copy;n&Atilde;&uml;re une page html contenue dans la variable buffer
	//	    - code=-1 	: La fonction retourne un message d'erreur dans la variable error
	//On separe les differents champs et on les met dans une variable tableau
	
	$tableau = explode ("!", "$result");
	//	r&Atilde;&copy;cup&Atilde;&copy;ration des param&Atilde;&uml;tres
	$code = $tableau[1];
	$error = $tableau[2];
	$message = $tableau[3];
	//  analyse du code retour
	 if (( $code == "" ) && ( $error == "" ) )
		{
	 	print ("<BR><CENTER>erreur appel request</CENTER><BR>");
	 	print ("executable request non trouve $path_bin");
	 	print ("<br>result=".$result);
		}
	//	Erreur, affiche le message d'erreur
	else if ($code != 0){
		print ("<center><b><h2>Erreur appel API de paiement.</h2></center></b>");
		print ("<br><br><br>");
		print (" message erreur : $error <br>");
	}
	//	OK, affiche le formulaire HTML
	else {
		# OK, affichage du mode DEBUG si activ&Atilde;&copy;
		print (" $error <br>");

		print ("  $message ");
	}
?>
