<?php
   
    require(ABSPATH . 'wp-load.php');
	session_start();
	class users extends MvcModel
	{
		
	    public function dataUsers()
	    {
	    	global $wpdb;
	    	$dataUserInfo = $wpdb->get_row( "SELECT * FROM wp_atoutcom_users WHERE email ='".$_SESSION["loginEmail"]."' ");
	    	return $dataUserInfo;
	    }
	}
