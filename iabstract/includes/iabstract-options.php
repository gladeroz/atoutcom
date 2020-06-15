<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Create tab's options                  -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$iabstract_optionsTab->createOption( array(
	'name' => "Formulaire GF",
	'type' => 'heading',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name' => '<div style="witdh: 100%; text-align: center;"><img src="' . IABSTRACT_URL . '/images/icon-warning.png" /></div>',
	'type' => 'note',
	'desc' => 'Dès que des membres du comité ont commencé à noter des abstracts,<br><strong>NE PAS MODIFIER CES PARAMÈTRES !</strong>'
) );
// ----------------------------------------
$iabstract_gf_forms       = GFAPI::get_forms();
$iabstract_gf_forms_count = count($iabstract_gf_forms);
// ----------------------------------------
// Create option select
// ----------------------------------------
$iabstract_gf_forms_select = "";
if ($iabstract_gf_forms_count > 0) {
	$iabstract_gf_forms_select[0] = "Choisissez un formulaire";
	foreach($iabstract_gf_forms as $form) {
		$iabstract_gf_forms_select[$form['id']] = '[ID: '.$form['id'].'] ' . $form['title'];
	}
}
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name'    => 'Nbre de formulaires (GF)',
	'type'    => 'note',
	'desc'    => '<a href=" ' . get_admin_url( get_current_blog_id() ) . 'admin.php?page=gf_edit_forms">' . (($iabstract_gf_forms_count > 1) ? $iabstract_gf_forms_count . ' formulaires présents' : $iabstract_gf_forms_count . ' formulaire présent' ) . '</a>',
) );
$iabstract_optionsTab->createOption( array(
	'name'    => 'Formulaire',
	'id'      => 'form_gf_id',
	'type'    => 'select',
	'options' => $iabstract_gf_forms_select,
	'default' => '0',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name'    => 'Note maximum',
	'id'      => 'note_max',
	'type'    => 'number',
	'min'     => '1',
	'max'     => '20',
	'step'    => '1',
	'default' => '20',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name' => "Ouverture des sélections",
	'type' => 'heading',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name'     => 'Ouvrir les sélections',
	'id'       => 'opening_selection',
	'type'     => 'enable',
	'enabled'  => 'OUI',
	'disabled' => 'NON',
	'desc'     => "Ouvrir les sélections même si tous les votants n'ont pas voté",
	'default'  => false,
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name' => "Date de clôture",
	'type' => 'heading',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name'    => 'Date de clôture',
	'id'      => 'closing_date',
	'type'    => 'date',
	'desc'    => 'Choisissez une date de clôture pour la modification des notes des membres',
	'default' => '',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name' => "Texte introduction",
	'type' => 'heading',
) );
// ----------------------------------------
$iabstract_optionsTab->createOption( array(
	'name' => '[FRONT] Introduction',
	'id'   => 'introduction',
	'type' => 'editor',
	'desc' => "Texte d'introduction de la page de notation des membres du comité",
) );
// ----------------------------------------

// ----------------------------------------
?>