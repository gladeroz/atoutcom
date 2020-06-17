<?php
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Blocking direct access to plugin      -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
defined('ABSPATH') or die('Are you crazy!');


add_action( 'tf_create_options', 'iabstract_create_options' );
function iabstract_create_options() {
	
	remove_filter( 'admin_footer_text', 'addTitanCreditText' );

    /***************************************************************
     * Launch options framework instance
     ***************************************************************/
    $iabstract_option = TitanFramework::getInstance( IABSTRACT_ID );

    /***************************************************************
     * Create option menu item
     ***************************************************************/
    $iabstract_panel = $iabstract_option->createAdminPanel( array(
        'name'       => IABSTRACT_NAME,
		'title'      => IABSTRACT_NAME,
        'icon'       => ' data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAABuvAAAbrwFeGpEcAAAAB3RJTUUH4gIVECwAr0gsOgAAAxVJREFUSMfVlk1onEUYx3/Pm41pi01J26QNNUVFW9SDdAtFi6xK0YsfF8UUFYIE3CkqYi+ezGERUQ+1l+zOphZR0Loiggdveim2oO0q1EbUiyRa22iKRvADN3n/HnZ8O5tktzEnncs7/5lnnv88n/PC/23It8x3y7MVIFmlsmF5yhHulWfSXAvRXmDbam+7YxG+bhmZczFOVuoGeSzANxZtH4nkdqlCrzm2xa5bsZ/lqctzW7RelOeBDFe5UR7Jr95Fn8pzMsIH5PktwxVukkeqMhAw/8pd8tQx5s2xN+CngFfo5spgQR7jLMZWK/IjAMaJy5JELjoF/GXFjOAgcIiEPhtF8tyKqANDVmQmUjHc+eaVjOCkKpyKiA/Kk8qzIeA7QgyuBVCZ9QFv7kxQzRR+JM/piKAkz0VV2BTwXUHhDeHcBnmkCnfHejpZ8IE89Za1cXIAf0z0Is81geDmoHBTwPdFlxqLdRuAjoKNgjzvANebYxfA2PDxe4C1wEZgMM3xwvNvFhryDJrjvCoMYMwA+81Ri0ieMMd4C0nYeAR42Vwzz8ceOl4Cnrsk0RylWsGC/CDwAzBirlmg8pwF7jTHT0ssCQIC+g99/O7sXGNLvW/ginzP2hwz3/2OUsVnnizVCuPy/Aw8a44JeXLAHnOXamlJCstzCzBljtm5Rn/eTPn1fT30X7WOLdvXQQsH83qdHPCiOSbCWg4YaZdQufAdAqaDccckmP76V9IvRXdPAgZJYqSpWNPNERshBV4KgZ9EPG2OYjuS5Yoxa3hJl7EwL9IFsSO/kXRB/NngUR3NUn4SMWuODzuVxj8k08DVYf7qEqEu46vTF0m6DBqNt2wUVOULxAVz3H651pQAmOMTYEhlBku1wi/AZ23kD5fe2zcfCKbMsa9t4bVx14MkfB7SdDewBpgLeydAO0u1wjPynEF8Y457VQUrrrSVl7M0PizPBZWbb/OilrNZnnPyvN2xdSwz4johvNH3A+8D3wPf0kzg7SFmD5vjmCpgB1ZBAqAJsMcz0j1RMkyFuKHXwB77D/4q/Q0w2mTlRqFeWwAAAABJRU5ErkJggg==',
        'id'         => IABSTRACT_ID,
		'capability' => 'manage_options',
		'desc'       => '',
            ) );
	// --- Sous menu
	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
        'name' => __( 'Options', IABSTRACT_ID_LANGUAGES ),
		'id'   => 'iabstract&tab=options',
    ) );
	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
        'name' => 'Membres',
		'id'   => 'iabstract&tab=members',
    ) );
	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
        'name' => 'Entrées',
		'id'   => 'iabstract&tab=entries',
    ) );
//	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
//        'name' => __( 'Payment', IABSTRACT_ID_LANGUAGES ),
//		'id'   => 'iabstract&tab=payment',
//    ) );
//	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
//        'name' => 'Bon de commande',
//		'id'   => 'iabstract&tab=bdc',
//    ) );
//	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
//        'name' => __( 'Emails', IABSTRACT_ID_LANGUAGES ),
//		'id'   => 'iabstract&tab=emails',
//    ) );
	$iabstract_submenu = $iabstract_panel->createAdminPanel( array(
        'name' => __( 'Credits', IABSTRACT_ID_LANGUAGES ),
		'id'   => 'iabstract&tab=credits',
    ) );
	
    // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    // Create option panel tabs              -=
    // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $iabstract_dashboardTab = $iabstract_panel->createTab( array(
        'name' => __( 'Dashboard', IABSTRACT_ID_LANGUAGES ),
        'id'   => 'dashboard',
    ) );
	$iabstract_optionsTab = $iabstract_panel->createTab( array(
		'name' => __( 'Options', IABSTRACT_ID_LANGUAGES ),
		'id'   => 'options',
	) );
	$iabstract_membersTab = $iabstract_panel->createTab( array(
		'name' => 'Membres',
		'id'   => 'members',
	) );
	$iabstract_entriesTab = $iabstract_panel->createTab( array(
		'name' => 'Entrées',
		'id'   => 'entries',
	) );
	//$iabstract_paymentTab = $iabstract_panel->createTab( array(
	//	'name' => __( 'Payment', IABSTRACT_ID_LANGUAGES ),
	//	'id'   => 'payment',
	//) );
	//$iabstract_bdcTab = $iabstract_panel->createTab( array(
	//	'name' => 'Bon de commande',
	//	'id'   => 'bdc',
	//) );
	//$iabstract_emailsTab = $iabstract_panel->createTab( array(
	//	'name' => __( 'Emails', IABSTRACT_ID_LANGUAGES ),
	//	'id'   => 'emails',
	//) );
    $iabstract_creditsTab = $iabstract_panel->createTab( array(
        'name' => __( 'Credits', IABSTRACT_ID_LANGUAGES ),
        'id'   => 'credits',
    ) );
			
	// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	// Include files options                 -=
	// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	$iabstractOptions = ['dashboard', 'options', 'members', 'entries', 'credits'];
	foreach ($iabstractOptions as $iabstractOption) {
		$iabstractOptionFile = IABSTRACT_PATH . 'includes/' . IABSTRACT_ID . '-' . $iabstractOption . '.php';
		if (file_exists($iabstractOptionFile))
			require_once($iabstractOptionFile);
	}
	
    // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	// Launch options framework instance     -=
	// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
    $iabstract_optionsTab->createOption( array(
        'type' => 'save',
        'save' => __( 'Save Changes', IABSTRACT_ID_LANGUAGES ),
		'use_reset' => false,
    ) );
    $iabstract_membersTab->createOption( array(
        'type' => 'save',
        'save' => __( 'Save Changes', IABSTRACT_ID_LANGUAGES ),
		'use_reset' => false,
        'reset' => __( 'Reset to Defaults', IABSTRACT_ID_LANGUAGES ),
    ) );
//    $iabstract_spacesTab->createOption( array(
//        'type' => 'save',
//        'save' => __( 'Save Changes', IABSTRACT_ID_LANGUAGES ),
//		'use_reset' => false,
//        //'reset' => __( 'Reset to Defaults', IABSTRACT_ID_LANGUAGES ),
//    ) );
//    $iabstract_paymentTab->createOption( array(
//        'type' => 'save',
//        'save' => __( 'Save Changes', IABSTRACT_ID_LANGUAGES ),
//		'use_reset' => false,
//        //'reset' => __( 'Reset to Defaults', IABSTRACT_ID_LANGUAGES ),
//    ) );
//    $iabstract_bdcTab->createOption( array(
//        'type' => 'save',
//        'save' => __( 'Save Changes', IABSTRACT_ID_LANGUAGES ),
//		'use_reset' => false,
//        //'reset' => __( 'Reset to Defaults', IABSTRACT_ID_LANGUAGES ),
//    ) );
//    $iabstract_emailsTab->createOption( array(
//        'type' => 'save',
//        'save' => __( 'Save Changes', IABSTRACT_ID_LANGUAGES ),
//        'reset' => __( 'Reset to Defaults', IABSTRACT_ID_LANGUAGES ),
//    ) );
	
} // END iabstract_create_options

