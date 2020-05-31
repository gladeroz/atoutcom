<?php
/*
Plugin Name: Atoutcom events
Plugin URI: http://eybios.fr/plugins/users
Description: Plugin de gestion d'évenements
Author: Harou Guindja
Version: 0.1
Author URI:
*/

// register activation hook for when the plugin is installed.
register_activation_hook(__FILE__, 'atoutcom_events_activate');
function atoutcom_events_activate($network_wide)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->activate($network_wide);
}

// register deactivation hook for when the plugin is uninstalled
register_deactivation_hook(__FILE__, 'atoutcom_events_deactivate');
function atoutcom_events_deactivate($network_wide)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->deactivate($network_wide);
}

// register an action handler for when a new blog is created in a multisite environment
add_action('wpmu_new_blog', 'atoutcom_events_on_create_blog');
function atoutcom_uevents_on_create_blog($blog_id)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->activate_blog($blog_id);
}

// register an action handler for when a blog is deleted in a multisite environent
add_action('deleted_blog', 'atoutcom_events_on_delete_blog');
function atoutcom_events_on_delete_blog($blog_id)
{
    require_once dirname(__FILE__) . '/atoutcom_events_loader.php';
    $loader = new AtoutcomEventsLoader();
    $loader->deactivate_blog($blog_id);
}

//Events
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Add JS Scripts to admin               -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
/*define( 'CHILD_THEME_VERSION', '2.3.0' );
add_action( 'admin_enqueue_scripts', 'events_script_admin_method' );
function events_script_admin_method() {
    wp_enqueue_script( 'script', plugins_url().'/atoutcom-events/app/public/js/events_admin_script.js', array('jquery'), '1.0', true );
    //wp_enqueue_script( 'script', plugins_url().'/atoutcom-events/app/public/js/events_admin_script.js', array('jquery'), '1.0', true );
    wp_enqueue_style( 'bootstrap-css', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css' );
    wp_enqueue_script( 'proper-js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js', array( 'jquery' ), "1.0.4", true );
    wp_enqueue_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
    
    // pass Ajax Url to script.js
    wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}*/

function createEvent() {
    global $wpdb;
    $params = array();
    parse_str($_POST['data'], $params);
    $organisateur = $params["organisateur"];
    $titre = $params["titre"];
    $specialite = $params["specialite"];
    $documents = $params["documents"];
    $adresse = $params["adresse"];
    $ville = $params["ville"];
    $codepostal = $params["codepostal"];
    $date_evenement = $params["date_evenement"];
    
    $dataEvent = $wpdb->get_row( "SELECT * FROM ".$wpdb->base_prefix."atoutcom_events WHERE titre ='".$titre."' AND date_evenement='".$date_evenement."' ");
    if($dataEvent !=null){
        wp_die(json_encode("errorEventExist"));
    }else{
        $insertDataEvents =  $wpdb->insert( 
            $wpdb->base_prefix."atoutcom_events",
            array( 
                'organisateur' => $organisateur,
                'titre' => $titre,
                'specialite' => $specialite,
                'documents'  => $documents,
                'adresse'  => $adresse,
                'ville'  => $ville,
                'codepostal'  => $codepostal,
                'date_evenement'  => $date_evenement,
            ), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ) 
        );

        if($insertDataEvents){
            wp_die(json_encode("success"));
        }else{
            wp_die(json_encode("errorDB"));
        } 
    } 
}
add_action( 'wp_ajax_createEvent', 'createEvent' );
add_action( 'wp_ajax_nopriv_createEvent', 'createEvent' );


// Affichage des évenements
// Source datatable events
function events_manage() {
    global $wpdb;
    $data = array();
    $datas = array();
    //$dataEvent = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."atoutcom_events", ARRAY_A);
    $dataEvent = atoutcomUser::formsEvents("listeEventsForUsers", "");

    if( $dataEvent===NULL ){
        wp_die(json_encode(""));
    }else{
        foreach ($dataEvent as $value) {
            $dataEvt = $value["data"][0];
            $data["organisateur"] = $dataEvt["Organisateur Evenement"];
            $data["titre"] = $value["evenement"];
            $data["specialite"] = $dataEvt["Specialite Evenement"];
            $data["adresse"] = $dataEvt["Adresse Evenement"];
            $data["codepostal"] = $dataEvt["Code postal Evenement"];
            $data["ville"] = $dataEvt["Ville Evenement"];
            $data["pays"] = $dataEvt["Pays Evenement"];
            $data["date_evenement"] = $dataEvt["Date Debut Evenement"]." - ".$dataEvt["Date Fin Evenement"];
            $datas[]=$data;
        }

        wp_die(wp_json_encode($datas));
    }
}
add_action( 'wp_ajax_events_manage', 'events_manage' );
add_action( 'wp_ajax_nopriv_events_manage', 'events_manage' );


// Affichage des participants aux évenements

function user_events() {
    global $wpdb;
    $data = array();
    $datas = array();

    $datauUserEvents = atoutcomUser::formsEvents("listeEventsForUsers", "");
    
    if( $datauUserEvents===NULL ){
        wp_die(wp_json_encode(""));
    }else{
        foreach ($datauUserEvents as $datauUserEvent) {
            $dataUsr = $datauUserEvent["data"][0];
            $data["evenement"] = $datauUserEvent["evenement"];
            $data["form_id"] = $datauUserEvent["form_id"];
            $data["entry_id"] = $datauUserEvent["entry_id"];
            $data["nom"] = $dataUsr["Nom"];
            $data["prenom"] = $dataUsr["Prenom"];
            $data["email"] = $dataUsr["Email Professionnel"];
            $data["adresseUser"] = $dataUsr["Adresse"];
            $data["codepostalUser"] = $dataUsr["Code postal"];
            $data["villeUser"] = $dataUsr["Ville"];
            $data["telephone"] = $dataUsr["Telephone Professionnel"];
            $data["payment_status"] = $dataUsr["payment_status"];
            $data["transaction_id"] = $dataUsr["transaction_id"];
            $data["status"] = events::getUsersEventsStatus($datauUserEvent["form_id"],  $dataUsr["Email"]);
            $datas[]=$data;
        }
        

        wp_die(wp_json_encode($datas));
    }
    wp_die();
}
add_action( 'wp_ajax_user_events', 'user_events' );
add_action( 'wp_ajax_nopriv_user_events', 'user_events' );


// Mise à jour du statut 
function updateUserStatus() {
    global $wpdb;
    $data = array();
    
    $userEmail = $_POST["userId"];
    $statut = $_POST["dataStatus"];
    $form_id = $_POST["formId"];
    
    //$entry_id = $_POST["formId"];
    if( !empty($form_id)  || !empty($userEmail) ){
	    $updateStatus = $wpdb->update( 
	        $wpdb->base_prefix."atoutcom_users_events_status",
	        array( 
	            'status'  => $statut,
	        ), 
	        array(
	            'id_event' => $form_id,
	            'email' => $userEmail,
	        )
	    );

	    if( $updateStatus ){
	        wp_die(wp_json_encode("success"));
	    }else{
	        wp_die(wp_json_encode("errorDB"));
	    }
    }else{
        wp_die(wp_json_encode("error"));
    }
    
    wp_die();
}
add_action( 'wp_ajax_updateUserStatus', 'updateUserStatus' );
add_action( 'wp_ajax_nopriv_updateUserStatus', 'updateUserStatus' );
