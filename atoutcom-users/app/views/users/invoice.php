<?php 
    global $wpdb;

    var_dump("hello");die();
    function randomPassword() 
    { 
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%*_-=+?"; 
        $length = rand(8, 12); 
        $password = substr( str_shuffle(sha1(rand() . time()) . $chars ), 0, $length );
        return $password;
    }
    /*$alter = $wpdb->get_var( "ALTER TABLE ".$wpdb->base_prefix."atoutcom_users_events_facture MODIFY COLUMN montantTVA decimal(10,2)", ARRAY_A);
    $wpdb->prefix = 'atoa_105_';
	//$forms = GFAPI::get_forms(4);
	//$entries = GFAPI::get_entries(4);
    //$dataUserEvents = atoutcomUser::formsEvents("listeEventsForUsers");
    //$dataUsersEvents = $wpdb->get_results( "SELECT * FROM atoa_105_gf_entry_meta where meta_key = 23", ARRAY_A);

    var_dump(atoutcomUser::formsEvents("listeEventsForUsers"));
	die();*/
?>

