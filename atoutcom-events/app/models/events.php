<?php
   
    require(ABSPATH . 'wp-load.php');
	session_start();
	class events extends MvcModel
	{
		
	    public function datEvents()
	    {
	    	global $wpdb;
	    	$dataeventInfo = $wpdb->get_row( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_events");
	    	return $dataeventInfo;
	    }

	    // Récuperer le statut d'un participant
	    public function getUsersEventsStatus($formid, $email){
	    	global $wpdb;
            $dataUsersEventsStatus = $wpdb->get_var( "SELECT status FROM ".$wpdb->base_prefix."atoutcom_users_events_status WHERE id_event=".$formid." AND email='".$email."' ");
            return $dataUsersEventsStatus;
	    }

	    // Récuperer la date de paiement saisie manuellement lors du changement d'état de reglement d'un participant
	    public function getUsersEventsDatePayment($formid, $email){
	    	global $wpdb;
            $dataUsersEventsDatePayment = $wpdb->get_var( "SELECT date_paiement FROM ".$wpdb->base_prefix."atoutcom_users_events_status WHERE id_event=".$formid." AND email='".$email."' ");
            return $dataUsersEventsDatePayment;
	    }
	}
