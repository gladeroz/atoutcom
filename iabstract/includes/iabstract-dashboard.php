<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Create tab's options                  -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// ----------------------------------------
// --- Verifications ----------------------
// ----------------------------------------
$iabstract_dashboardTab->createOption( array(
	'name' => 'Fonctionnalités',
	'type' => 'heading',
) );
$iabstract_dashboardTab->createOption( array(
	'name' => '<div class="iabstract-icons icon-iabstract iabstract-icons-100"></div>',
	'desc' => '<h3 class="">' . sprintf( __( 'Welcome to the %s plugin', IABSTRACT_ID_LANGUAGES ), IABSTRACT_NAME ) . ' v.' . iabstract_get_version( 'Version' ) . ' ( <a href="./admin.php?page=iabstract&tab=credits" target="_blank">' . __( 'Credits', IABSTRACT_ID_LANGUAGES ) . '</a> )</h3>
				<div style="color:black; font-style: normal;">
					<p>
						<ol>
							<li>' . __( 'ADMINISTRATION', IABSTRACT_ID_LANGUAGES ) . '</li>
							<ol>
								<li>Créer une page avec le shortcode de votre formulaire (voir Gravity Forms)</li>
								<li>Créer une page avec le shortcode de visualisation des notes</li>
								<li>Vérifier que le plugin Gravity Forms est bien installé et activé</li>
								<li>Initialisez vos options (note max, formulaire à traiter)</li>
								<li>Choisissez les membres autorisés à noter le formulaire</li>
								<li>Visualisez les entrées (données du formulaire d\'abstract)</li>
							</ol>
						</ol>
						<ol>
							<li>MEMBRES</li>
							<ol>
								<li>Visualisation des notes pour chaque membre du comité</li>
								<li>Permettre aux membres du comité de noter / sélectionner les abstracts</li>
							</ol>
						</ol>
					</p>
					<p>
					</p>
				</div>
	',
	'type' => 'note'
) );
// ----------------------------------------
$iabstract_dashboardTab->createOption( array(
	'name' => 'Vérification PLUGIN Gravity Forms',
	'type' => 'heading',
) );
// ----------------------------------------
/**
 * Detect Gravity Forms Plugin. For use in Admin area only.
 */
$iabstract_gf_is_active = (is_plugin_active( 'gravityforms/gravityforms.php' )) ? '<span class="iabstract-green">' . __( 'Enabled', IABSTRACT_ID_LANGUAGES ) . '</span>' : '<span class="iabstract-red">Plugin Gravity Forms non installé / activé !</span>';
$iabstract_dashboardTab->createOption( array(
	'name'  => 'Vérification Plugin GF',
    'type'  => 'note',
    'desc'  =>  $iabstract_gf_is_active,
	'color' => 'red'
) );
// ----------------------------------------
$iabstract_dashboardTab->createOption( array(
	'name' => 'Shortcode IABSTRACT',
	'type' => 'heading',
) );
// ----------------------------------------
$iabstract_dashboardTab->createOption( array(
	'name'  => 'Shortcode à insérer',
    'type'  => 'note',
    'desc'  =>  '<span style="font-style: normal;">[iabstract]</span>',
) );
// ----------------------------------------
// ----------------------------------------

?>