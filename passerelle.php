<?php
/*
Template Name: passerelle de paiement SOGENACTIF
*/

error_reporting(0);

get_header();

echo '<br/><br/><br/>';

global $wpdb;

define("IDBOUTIQUE", "XXXX"); //Identifiant de la boutique
define("IDCERTIFICAT", "XXXX"); //Certificat de test ou de production
define("MODEBOUTIQUE", "TEST"); //VALEUR TEST OU PRODUCTION

$form_id = sanitize_text_field($_GET['form_id']);
$entry_id = sanitize_text_field($_GET['entry_id']);
$prefix  = ((isset($_GET['site_id'])) ? $wpdb->base_prefix . sanitize_text_field($_GET['site_id']) . '_' : $wpdb->base_prefix);
$field_id  = sanitize_text_field($_GET['field_id']);

$siteid = (isset($_GET['site_id'])) ? $_GET['site_id'] : 0;

$field_id = (int)$field_id;
$form_id = (int)$form_id;
$entry_id = (int)$entry_id;

function generateRandomString($length = 6) {
    return sanitize_text_field(substr(str_shuffle(str_repeat($x='012345678', ceil($length/strlen($x)) )),1,$length));
}

$transaction_id = generateRandomString();

$sql = "SELECT meta_value FROM " . $prefix . "gf_entry_meta WHERE form_id=".$form_id." AND entry_id=".$entry_id." AND meta_key = '".$field_id."'";
$inscr = $wpdb->get_var( $sql );
$total = number_format($inscr,2);
$total = $total * 100;

$trans_date = date('YmdHis');

$concat = utf8_encode (sanitize_text_field('INTERACTIVE+'.$total.'+'.MODEBOUTIQUE.'+978+'.$siteid.'+PAYMENT+SINGLE+'.IDBOUTIQUE.'+'.$trans_date.'+'.$transaction_id.'+V2+'.IDCERTIFICAT));

$signature = hash('sha1', $concat, false);

$formulaire = "
<form name='passerelle' method='POST' action='https://sogecommerce.societegenerale.eu/vads-payment/'>
<input type='hidden' name='vads_action_mode' value='INTERACTIVE' />
<input type='hidden' name='vads_amount' value='".$total."' />
<input type='hidden' name='vads_ctx_mode' value='".MODEBOUTIQUE."' />
<input type='hidden' name='vads_currency' value='978' />
<input type='hidden' name='vads_page_action' value='PAYMENT' />
<input type='hidden' name='vads_payment_config' value='SINGLE' />
<input type='hidden' name='vads_site_id' value='".IDBOUTIQUE."' />
<input type='hidden' name='vads_trans_date' value='".$trans_date."' />
<input type='hidden' name='vads_trans_id' value='".$transaction_id."' />
<input type='hidden' name='vads_version' value='V2' />
<input type='hidden' name='vads_ext_info_site_id' value='".$siteid."' />
<input type='hidden' name='signature' value='".$signature."' />
<input type='submit' id='bouton_payer' name='payer' value='Effectuer le réglement'/>
</form>";

$updateUser = $wpdb->update( 
    $prefix."gf_entry",
    array( 
        'payment_date'  => $trans_date,
        'transaction_id'  => $transaction_id,
		'payment_amount'  => $total,
		'payment_status' => 'WAITING'
    ), 
    array(
        'id' => $entry_id,
        'form_id' => $form_id,
    )
);

?>

<style>
#bouton_payer { width:300px; height:40px; font-size:14px; }
</style>

<div class="container-wrap">
	
	<div class="container main-content">
		
		<div class="row">

			<div style="text-align:center;">
				<img src="https://www.inrs-metro-tempsreel2019.fr/wp-content/uploads/2018/08/cb-images.png">
				<br /><br />
				Vous allez être redirigé vers le formulaire de paiement sécurisé
				<br /><br /><br /><br />

				<?php print $formulaire; ?>
			</div>

		</div><!--/row-->
		
	</div><!--/container-->

</div>

<?php get_footer(); ?>
