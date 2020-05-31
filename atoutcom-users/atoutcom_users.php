<?php
/*
Plugin Name: Atoutcom users
Plugin URI: http://eybios.fr/plugins/users
Description: Gestion des participants à un évenement
Author: Harou G
Version: 0.1
Author URI:
*/

// register activation hook for when the plugin is installed.
register_activation_hook(__FILE__, 'atoutcom_users_activate');
function atoutcom_users_activate($network_wide)
{
    require_once dirname(__FILE__) . '/atoutcom_users_loader.php';
    $loader = new AtoutcomUsersLoader();
    $loader->activate($network_wide);
}

// register deactivation hook for when the plugin is uninstalled
register_deactivation_hook(__FILE__, 'atoutcom_users_deactivate');
function atoutcom_users_deactivate($network_wide)
{
    require_once dirname(__FILE__) . '/atoutcom_users_loader.php';
    $loader = new AtoutcomUsersLoader();
    $loader->deactivate($network_wide);
}

// register an action handler for when a new blog is created in a multisite environment
add_action('wpmu_new_blog', 'atoutcom_users_on_create_blog');
function atoutcom_users_on_create_blog($blog_id)
{
    require_once dirname(__FILE__) . '/atoutcom_users_loader.php';
    $loader = new AtoutcomUsersLoader();
    $loader->activate_blog($blog_id);
}

// register an action handler for when a blog is deleted in a multisite environent
add_action('deleted_blog', 'atoutcom_users_on_delete_blog');
function atoutcom_users_on_delete_blog($blog_id)
{
    require_once dirname(__FILE__) . '/atoutcom_users_loader.php';
    $loader = new AtoutcomUsersLoader();
    $loader->deactivate_blog($blog_id);
}

//users
define( 'CHILD_THEME_VERSION', '2.3.0' );
function users_js_scripts() {
    wp_enqueue_script( 'script', plugins_url().'/atoutcom-users/app/public/js/users-script.js', array('jquery'), '3.4.1', true );

    
    wp_enqueue_style( 'bootstrap-glyficon', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css' );
    wp_enqueue_script( 'proper-js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js', array( 'jquery' ), "1.0.4", true );
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
    // pass Ajax Url to script.js
    wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}
add_action('wp_enqueue_scripts', 'users_js_scripts');

function registration() {
    global $wpdb;
    $params = array();
    parse_str($_POST['data'], $params);
    $categorie = $params["categorie"];
    $nom = $params["nom"];
    $prenom = $params["prenom"];
    $email = $params["email"];
    $password = $params["password"];
    $repeatPassword = $params["repeat-password"];
    $redirection = $params["redirection"];
    $date = date("d/m/Y");


    $dataUser = $wpdb->get_row( "SELECT email FROM ".$wpdb->base_prefix."atoutcom_users WHERE email ='".$email."' AND categorie = '".$categorie."' ");

    //Si les mots de passe ne sont pas identique
    if($password != $repeatPassword){
        wp_die(json_encode("errorPwd"));
    }else{
        $passwordEncrypt = password_hash($password, PASSWORD_DEFAULT);
    }

    //Si l'email existe
    if( $email === $dataUser->email ){
        wp_die(json_encode("errorMail"));
    }else{
        $insertDataUsers =  $wpdb->insert( 
            $wpdb->base_prefix."atoutcom_users",
            array( 
                'nom'  => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password'  => $passwordEncrypt,
                'dateinscription' => $date,
                'categorie' => $categorie,
            ), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            ) 
        );

        if($insertDataUsers){
            wp_die(json_encode("success".$redirection));
        }else{
            wp_die(json_encode("errorDB"));
        }
    }
}
add_action( 'wp_ajax_registration', 'registration' );
add_action( 'wp_ajax_nopriv_registration', 'registration' );


function login() {
    session_start();
    global $wpdb;
    $params = array();
    parse_str($_POST['data'], $params);
    $email = $params["email"];
    $password = $params["password"];
    $categorie = $params["categorie"];
    $_SESSION["categorie"] = $categorie;
    $stayConnected = $params["remember"];

    $checkMail = false;
    $checkPassword = false;
    $redirection = $params["redirection"];
    
    $dataUser = $wpdb->get_row( "SELECT password, email FROM ".$wpdb->base_prefix."atoutcom_users WHERE email ='".$email."' AND categorie ='".$categorie."' ");
    //Si l'email n'existe pas
    if( $dataUser===NULL ){
        wp_die(json_encode("errorMail"));
    }else{
        $checkMail = true;
    }
    
    //Si les mots de passe ne sont pas identique
    if( password_verify ( $password , $dataUser->password ) ) {
        $checkPassword = true;
    }else{
        wp_die(json_encode("errorPwd"));
    }
    
    // Si $checkMail et $checkPassword
    if($checkPassword && $checkMail){
        $_SESSION["loginEmail"] = $email;
        // Enregistrer le login pendant une journée pour la gestion des login
        if($stayConnected ==="on"){
            $temps = 24*3600;
            setcookie( "LOGIN", $email, time()+$temps, SITECOOKIEPATH, COOKIE_DOMAIN, false );
        }
        wp_die(json_encode("success".$redirection));
    }
}
add_action( 'wp_ajax_login', 'login' );
add_action( 'wp_ajax_nopriv_login', 'login' );

function updateUserInfo() {
    session_start();
    global $wpdb; 
    $wpdb->show_errors();
    $params = array();
    parse_str($_POST['data'], $params);
    $id = $params["idUser"];
    $nom = $params["nom"];
    $prenom = $params["prenom"];
    $email = $params["email"];
    $adresse = $params["adresse"];
    $ville = $params["ville"];
    $pays = $params["pays"];
    $codePostal = $params["codepostal"];
    $telephone_fixe = $params["telephone_fixe"];
    $telephone_mobile = $params["telephone_mobile"];
    $specialite = $params["specialite"];
    //$prospection = $params["prospection"];

    //$dataUser = $wpdb->get_row( "SELECT password, email FROM wp_atoutcom_users WHERE email ='".$email."' ");
    $updateUser = $wpdb->update( 
        $wpdb->base_prefix."atoutcom_users",
        array( 
            'nom'  => $nom,
            'prenom'  => $prenom,
            'email'  => $email,
            'adresse'  => $adresse,
            'ville'  => $ville,
            'pays'  => $pays,
            'codepostal'  => $codePostal,
            'telephone_fixe'  => $telephone_fixe,
            'telephone_mobile'  => $telephone_mobile,
            'specialite'  => $specialite,
            'isUpdate'  => "yes",
        ), 
        array(
            'id' => $id,
        )
    );

    if( $updateUser ){
        wp_die(json_encode("success"));
    }else{
        wp_die(json_encode("error"));
    }
}
add_action( 'wp_ajax_updateUserInfo', 'updateUserInfo' );
add_action( 'wp_ajax_nopriv_updateUserInfo', 'updateUserInfo' );

// Recupération mot de passe
function password_resset() {
    session_start();
    global $wpdb;
    $params = array();
    parse_str($_POST['data'], $params);
    $email = $params["email"];
    $password = $params["password"];
    $password_repeat = $params["password-repeat"];
    $action = $params["action"];
    
    if($action === ""){
        $dataUser = $wpdb->get_row( "SELECT email FROM ".$wpdb->base_prefix."atoutcom_users WHERE email ='".$email."' ");
        if( $dataUser===NULL ){
            wp_die(json_encode("errorMail"));
        }else{
            wp_die(json_encode("successMail"));
        }
    }else{
        if($password === "" || $password_repeat === ""){
            if($password === ""){
                wp_die(json_encode("errorPasswordVide"));
            }else{
                wp_die(json_encode("errorRepeatPasswordVide"));
            }
        }else{
            // Vérifier si les mots de passe sont identiques
            if($password === $password_repeat){
                $passwordEncrypt = password_hash($password, PASSWORD_DEFAULT);
                $updateUser = $wpdb->update( 
                    $wpdb->base_prefix."atoutcom_users",
                    array( 
                        'password'  => $passwordEncrypt,
                    ), 
                    array(
                        'email' => $email,
                    )
                );

                if( $updateUser ){
                    wp_die(json_encode("successUpdatePassword"));
                }else{
                    wp_die(json_encode("errorUpdatePassword"));
                }
            }else{
                wp_die(json_encode("errorPassword"));
            }
        }
    }
}
add_action( 'wp_ajax_password_resset', 'password_resset' );
add_action( 'wp_ajax_nopriv_password_resset', 'password_resset' );

// Recupération login
function login_resset() {
    session_start();
    global $wpdb;
    $params = array();
    parse_str($_POST['data'], $params);
    $email = $params["email"];
    $password = $params["password"];
    $password_repeat = $params["password-repeat"];
    $action = $params["action"];
    
    if($action === ""){
        $dataUser = $wpdb->get_row( "SELECT email FROM ".$wpdb->base_prefix."atoutcom_users WHERE email ='".$email."' ");
        if( $dataUser===NULL ){
            wp_die(json_encode("errorMail"));
        }else{
            wp_die(json_encode("successMail"));
        }
    }else{
        if($password === $password_repeat){
            $passwordEncrypt = password_hash($password, PASSWORD_DEFAULT);
            $updateUser = $wpdb->update( 
                $wpdb->base_prefix."atoutcom_users",
                array( 
                    'password'  => $passwordEncrypt,
                ), 
                array(
                    'email' => $email,
                )
            );

            if( $updateUser ){
                wp_die(json_encode("successUpdatePassword"));
            }else{
                wp_die(json_encode("errorUpdatePassword"));
            }
        }else{
            wp_die(json_encode("errorPassword"));
        }
    }
}
add_action( 'wp_ajax_login_resset', 'login_resset' );
add_action( 'wp_ajax_nopriv_login_resset', 'login_resset' );


// Deconnexion
function disconnectFunction() {
    session_start();
    $_SESSION["loginEmail"] = "disconnect";
    setcookie( "LOGIN", $email, time()-1, SITECOOKIEPATH, COOKIE_DOMAIN, false );
    
    wp_die(json_encode("success"));
}
add_action( 'wp_ajax_disconnectFunction', 'disconnectFunction' );
add_action( 'wp_ajax_nopriv_disconnectFunction', 'disconnectFunction' );

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
// Add JS Scripts to admin               -=
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
add_action( 'admin_enqueue_scripts', 'users_script_admin_method' );
function users_script_admin_method() {

    wp_enqueue_script( 'script', plugins_url().'/atoutcom-users/app/public/js/users-admin-script.js', array('jquery'), '3.3.1', true );

    //wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'bootstrap-css', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css' );
    //wp_enqueue_style( 'bootstrap-select', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css' );
    
    wp_enqueue_style( 'bootstrap-glyficon', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css' );
    wp_enqueue_script( 'proper-js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js', array( 'jquery' ), "3.3.1", true );
    wp_enqueue_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
    //wp_enqueue_script( 'bootstrap-select-js', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js');
    

    wp_enqueue_script( 'datatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array( 'jquery' ), '3.3.1', true );
    wp_enqueue_style( 'datatables-style', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
    
    // pass Ajax Url to script.js
    wp_localize_script('script', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}


// Source datatable events
function users_manage() {
    global $wpdb;
    $data = array();
    $datas = array();
    $dataUser = atoutcomUser::getAllUsers();

    if( $dataUser===NULL ){
        wp_die(json_encode(""));
    }else{
        foreach ($dataUser as $key => $value) {
            $data["Nom"] = $value["nom"];
            $data["Prenom"] = $value["prenom"];
            $data["Email"] = $value["email"];
            $data["Adresse"] = $value["adresse"];
            $data["CodePostal"] = $value["codepostal"];
            $data["Ville"] = $value["ville"];
            $data["TelephoneMobile"] = $value["telephone_mobile"];
            $data["TelephoneFixe"] = $value["telephone_fixe"];
            $data["DateInscription"] = $value["dateinscription"];
            $data["Pays"] = $value["pays"];
            $data["Profil"] = $value["categorie"];
            $data["userFile"] = wp_json_encode(atoutcomUser::dataUserFileForAdmin($value["email"]));
            $datas[]=$data;
        }
        echo wp_json_encode($datas);
        wp_die();
    }
}
add_action( 'wp_ajax_users_manage', 'users_manage' );
add_action( 'wp_ajax_nopriv_users_manage', 'users_manage' );

// Upluoad des fichiers utilisateurs
function form_file() {
    global $wpdb;
    $data = array();
    $datas = array();

    $fichier = $_POST["fichier"];
    $file = $_FILES[$fichier];

    $date = date("Y-m-d H:i:s");
    $type = $_POST["type"];
    $nomFichierDB = $file["name"];
    if($type==="attestation"){
        $email = $_POST["email"];
    }else{
        $email = $_SESSION["loginEmail"];
    }
    
    if($file['tmp_name']!=''){
        $valid_ext = array( 'pdf', 'doc', 'docx' );
        $info=  new SplFileInfo($file['name']);
        $extension_upload = $info->getExtension();
        if ( in_array($extension_upload,$valid_ext) ){
            $name_upload = uniqid()."_".$file['name'];
            $url_insert = trailingslashit( ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/'.$email);
            
            if(! is_dir($url_insert)){
                wp_mkdir_p($url_insert);
            }

            $name_insert = trailingslashit($url_insert) . $name_upload;
            $name_insert = str_replace(" ", "_", $name_insert);
            $name_upload = str_replace(" ", "_", $name_upload);
            $action = move_uploaded_file($file['tmp_name'], $name_insert);
            
            if($action !=false){
                $insertDataUsersFile =  $wpdb->insert( 
                    $wpdb->base_prefix."atoutcom_users_file",
                    array( 
                        'email'  => $email,
                        'fichier' => $nomFichierDB,
                        'chemin' => $name_upload,
                        'date_enregistrement' => $date,
                        'type_doc' => $type,
                    ), 
                    array( 
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                    ) 
                );
                if ($insertDataUsersFile) {
                    wp_die(json_encode("success"));
                }else{
                    unlink($name_insert);
                    wp_die(json_encode("errorDB"));
                }
            }else{
                wp_die(json_encode("UploadNok"));
            }
        }else{
            wp_die(json_encode('errorExtension'));
        }
    }else{
        wp_die(json_encode('errorFichierVide'));
    }
    
}
add_action( 'wp_ajax_form_file', 'form_file' );
add_action( 'wp_ajax_nopriv_form_file', 'form_file' );


// Get UserFiles Ajax
function deleteUserFiles() {
    global $wpdb;
    
    $id = $_POST["id"];
    $nomFichier = $_POST["fichier"];
    $url_insert = trailingslashit( ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/'.$_SESSION["loginEmail"]);
    $name_insert = trailingslashit($url_insert) . $nomFichier;
    
    $deleteUserFile = atoutcomUser::deleteUserFile($id);

    if($deleteUserFile===1){
        if(unlink($name_insert) ){
            wp_die(json_encode("success"));
        }else{
            wp_die(json_encode("errorDelFile"));
        }
    }else{
        wp_die(json_encode("errorDB"));
    }

    wp_die(json_encode(""));
}
add_action( 'wp_ajax_deleteUserFiles', 'deleteUserFiles' );
add_action( 'wp_ajax_nopriv_deleteUserFiles', 'deleteUserFiles' );

// Get Data Facture
function getFacture() {
    global $wpdb;
    $data = array();
    $datas = array();
    $parametre = $_POST["data"];
    $dataFacture = atoutcomUser::getUsersEventsFacture($parametre);
    if( $dataFacture === NULL ){
        wp_die(json_encode(""));
    }else{
        foreach ($dataFacture as $key => $value) {
            $data["id"] = $value["id"];
            $data["periode"] = $value["periode"];
            $data["numero"] = $value["numero"];
            $data["date_facture"] = $value["date_facture"];
            $data["destinataire"] = $value["destinataire"];
            $data["intitule"] = $value["intitule"];
            $data["specialite"] = $value["specialite"];
            $data["annee"] = $value["annee"];
            $data["montantHT"] = $value["montantHT"];
            $data["aka_tauxTVA"] = $value["aka_tauxTVA"];
            $data["montantTVA"] = $value["montantTVA"];
            $data["montantTTC"] = $value["montantTTC"];
            $data["montantNET"] = $value["montantNET"];
            $data["total"] = $value["total"];
            $data["accompte"] = $value["accompte"];
            $data["restedu"] = $value["restedu"];
            $data["paye"] = $value["paye"];
            $data["encaisse"] = $value["encaisse"];
            $data["date_reglement"] = $value["date_reglement"];
            $data["commentaire"] = $value["commentaire"];
            $data["concerne"] = $value["concerne"];
            $datas[]=$data;
        }
        echo wp_json_encode($datas);
        wp_die();
    }
}
add_action( 'wp_ajax_getFacture', 'getFacture' );
add_action( 'wp_ajax_nopriv_getFacture', 'getFacture' );

// Create Intervenant
function createIntervenant() {
    global $wpdb;
    $data = array();
    $params = array();
    parse_str($_POST['data'], $params);
    $evenement = substr($params["evenement"], 0, strpos($params["evenement"],","));

    // Vérifier si l'intervenant existe avec la même conférence
    $checkEventIntervenant = atoutcomUser::checkEventIntervenant($params["evenement"], $params["email"]);
    if( sizeof($checkEventIntervenant)===1 ){
        wp_die(json_encode("exist"));
    }else{
        $insertDataIntervenant =  $wpdb->insert( 
            $wpdb->base_prefix."atoutcom_events_intervenants",
            array( 
                'evenement'  => $evenement,
                'date_evenement' => $params["dateEvenement"],
                'nom' => $params["nom"],
                'prenom' => $params["prenom"],
                'email' => $params["email"],
                'telephone' => $params["telephone"],
                'adresse' => $params["adresse"],
                'code_postal' => $params["codePostal"],
                'ville' => $params["ville"],
                'pays' => $params["pays"],
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
                '%s',
                '%s',        
            ) 
        );
        
        if($insertDataIntervenant != false){
            wp_die(json_encode("success"));
        }else{
            wp_die(json_encode("errorDB"));
        }
    }
}
add_action( 'wp_ajax_createIntervenant', 'createIntervenant' );
add_action( 'wp_ajax_nopriv_createIntervenant', 'createIntervenant' );

// Récupérer les intervenants
function getIntervenants() {
    global $wpdb;
    $data = array();
    $datas = array();
    $dataIntervenants = atoutcomUser::getAllIntervenants();
    if( $dataIntervenants === NULL ){
        wp_die();
    }else{
        echo wp_json_encode($dataIntervenants);
        wp_die();
    }
}
add_action( 'wp_ajax_getIntervenants', 'getIntervenants' );
add_action( 'wp_ajax_nopriv_getIntervenants', 'getIntervenants' );

// Create Sponsor
function createSponsor() {
    global $wpdb;
    $data = array();
    $params = array();
    parse_str($_POST['data'], $params);
    $maxID = atoutcomUser::getMaxIdFacture();
    if($maxID === NULL || $maxID === ""){
        $maxID = 0;
    }
    
    $langue = $params["sponsorLangue"];
    $numero = $maxID +1;
    $date_facture = date("d/m/Y");
    $destinataire = $params["sponsor"];
    $adresseFacturation = $params["adresseFact"];
    $codepostalFacturation = $params["codepostalFact"];
    $villeFacturation = $params["villeFact"];
    $paysFacturation = $params["paysFact"];

    $intitule = substr($params["evenement"], 0, strpos($params["evenement"],","));
    $specialite = $params["specialite"];
    
    //Date de l'evenement en fonction de la langue
    if($langue==="fr"){
        if($params["dateDebut"] === $params["dateFin"]){
            $dateEvenement = atoutcomUser::dateFr($params["dateDebut"], "");
        }else{
            $jrDebut = substr($params["dateDebut"], 0, 2);
            $moisDebut = atoutcomUser::dateFr("", substr($params["dateFin"], 3, -5));
            $anneeDebut = substr($params["dateDebut"], 6);

            
            $jrFin = substr($params["dateFin"], 0, 2);
            $moisFin = atoutcomUser::dateFr("", substr($params["dateFin"], 3, -5));
            $anneeFin = substr($params["dateFin"], 6);

            //si les années sont identiques
            if($anneeDebut === $anneeFin){
                $dateEvenement = $jrDebut."/".$moisDebut." - ".$jrFin."/".$moisFin." ".$anneeDebut;
            }else{
                $dateEvenement = atoutcomUser::dateFr($params["dateDebut"], "")." - ".atoutcomUser::dateFr($params["dateFin"], "");
            }
        }
    }else{
        if($params["dateDebut"] === $params["dateFin"]){
            $dateEvenement = atoutcomUser::dateEn($params["dateDebut"], "");
        }else{
            $jrDebut = substr($params["dateDebut"], 0, 2);
            $moisDebut = atoutcomUser::dateEn("", substr($params["dateFin"], 3, -5));
            $anneeDebut = substr($params["dateDebut"], 6);

            
            $jrFin = substr($params["dateFin"], 0, 2);
            $moisFin = atoutcomUser::dateEn("", substr($params["dateFin"], 3, -5));
            $anneeFin = substr($params["dateFin"], 6);

            //si les années sont identiques
            if($anneeDebut === $anneeFin){
                $dateEvenement = $jrDebut."/".$moisDebut." - ".$jrFin."/".$moisFin." ".$anneeDebut;
            }else{
                $dateEvenement = atoutcomUser::dateEn($params["dateDebut"], "")." - ".atoutcomUser::dateEn($params["dateFin"], "");
            }
        }
    }
    

    $datePaiement = date("d/m/Y");
    $adresseEvenement = $params["adresseEvent"];
    $codepostalEvenement = $params["codepostalEvent"];
    $villeEvenement = $params["villeEvent"];
    $paysEvenement = $params["paysEvent"];
    $descriptionDetail = $params["detailDesc"];

    
    $jourEvenement = substr($params["dateDebut"], 0, 2);
    $moisEvenement = substr($params["dateDebut"], 3, -5);
    $periode = substr($params["dateDebut"], 6);
    $numeroFacture = $numero."".$periode."/".$jourEvenement."".$moisEvenement;

    $annee = $periode;
    $quantite = "1";
    $patricipation = str_replace ( "," , "." , $params["participation"] );
    $montantHT = round($patricipation/1.2, 2, PHP_ROUND_HALF_DOWN);
    $aka_tauxTVA = 20;
    $montantTVA = round($patricipation*0.2, 2, PHP_ROUND_HALF_DOWN);
    $montantTTC = $patricipation;
    $montantNET = $patricipation;
    $total = $patricipation;
    $accompte = 0;
    $restedu = 0;
    $paye = $patricipation;
    $encaisse = $patricipation;
    $date_reglement = $datePaiement;
    $commentaire = "";
    $concerne = "sponsor";
    $emailContact = $params["emailContact"];
    
    $insertDataFacture =  $wpdb->insert( 
        $wpdb->base_prefix."atoutcom_users_events_facture",
        array( 
            'periode'  => $periode,
            'numero' => $numeroFacture,
            'date_facture' => $date_facture,
            'destinataire' => $destinataire,
            'intitule' => $intitule,
            'specialite' => $specialite,
            'annee' => $annee,
            'montantHT' => $montantHT,
            'aka_tauxTVA' => $aka_tauxTVA,
            'montantTVA' => $montantTVA,
            'montantTTC' => $montantTTC,
            'montantNET' => $montantNET,
            'total' => $total,
            'accompte' => $accompte,
            'restedu' => $restedu,
            'paye' => $paye,
            'encaisse' => $encaisse,
            'date_reglement' => $date_reglement,
            'commentaire' => $commentaire,
            'concerne' => $concerne,

        ), 
        array( 
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%f',
            '%d',
            '%f',
            '%f',
            '%f',
            '%f',
            '%f',
            '%f',
            '%f',
            '%f',
            '%s',
            '%s',
            '%s',
        ) 
    );
    
    if($insertDataFacture){
        //Génération de la facture et envoie de Mail avec la facture
        $retour = genererFacture(
            $langue,
            $destinataire, 
            $adresseFacturation,
            $codepostalFacturation.", ".$villeFacturation.", ".$paysFacturation,
            $numeroFacture,
            $date_facture,
            $intitule,
            $dateEvenement." ".$adresseEvenement." à ".$villeEvenement,
            $descriptionDetail,
            $quantite,
            $montantHT,
            $montantTVA,
            $montantTTC,
            $datePaiement,
            $emailContact
        );
        
        wp_die(json_encode($retour));
        
    }else{
        wp_die(json_encode("errorDB"));
    }
}
add_action( 'wp_ajax_createSponsor', 'createSponsor' );
add_action( 'wp_ajax_nopriv_createSponsor', 'createSponsor' );


// Remplir dynamiquement les champs sponsor quand on selectionne un evenement
function setDataValueSponsor() {
    global $wpdb;
    $form_id = $_POST["form_id"];
    $dataSponsorEvent = atoutcomUser::getDataSponsorEvents($form_id);
    wp_die(wp_json_encode($dataSponsorEvent));    
}
add_action( 'wp_ajax_setDataValueSponsor', 'setDataValueSponsor' );
add_action( 'wp_ajax_nopriv_setDataValueSponsor', 'setDataValueSponsor' );

// Fonction d'export excel des sponsors
function exportExcel() {
    global $wpdb;
    $data = array();

    $identifiants = $_POST["data"];
    $type = $_POST["type"];
    $colonneVisible = $_POST["colonneVisible"];
    $tabEntete = array(
        "PERIODE", 
        "NUMÉRO", 
        "DATE_CREATION", 
        "DESTINATAIRE", 
        "INTITULÉ",
        "SPECIALITÉ", 
        "ANNÉE", 
        "MontantHT", 
        "Ak_TauxTVA", 
        "MontantTVA", 
        "MontantTTC", 
        "MontantNet€", 
        "TOTAL", 
        "ACCOMPTE", 
        "RESTEDÛ", 
        "PAYÉ", 
        "ENCAISSÉ", 
        "Ak_DateReglement", 
        "COMMENTAIRE", 
        "CONCERNE"
    );

    $tabEnteteOrdonnee = array();
    // Distinguer les listes classiques des exports facture
    if($type==="Liste_Participant"){
        $from = "A1";
        $to = "K1";
        $dataExport = $identifiants;
        for($i=0; $i < sizeof($dataExport); $i++ ){
            unset($dataExport[$i][0], $dataExport[$i][11], $dataExport[$i][12]);
        }

    }else{
        $list = "";
        $select = "";
        $from = "A1";
        $to = "T1"; 
        for($i=0; $i<sizeof($identifiants); $i++){

            if($i===sizeof($identifiants)-1){
                $list = $list."".$identifiants[$i]."";
            }else{
                $list = $list."".$identifiants[$i].",";
            }
            
        }
        
        // L'affichage et le masquage des colonnes peut perturber l'ordre des colonnes
        for( $j = 0; $j < sizeof($tabEntete); $j++) {
            //si un element n'existe pas dans colonne visible alors on le mets dans le tableau ordonné
            if (in_array( $tabEntete[$j], $colonneVisible)) {
                $tabEnteteOrdonnee[] = $tabEntete[$j];
            }
        }

        // Requêter sur les colonnes visibles ordonnées
        for( $i = 0; $i < sizeof($tabEnteteOrdonnee); $i++){
            $valeur = switchCaseColumn($tabEnteteOrdonnee[$i]);

            if($i===sizeof($tabEnteteOrdonnee)-1){
                $select = $select."".$valeur."";
            }else{
                $select = $select."".$valeur.",";
            }
        }
        
        // Exécuter les réquêtes selon le type de profil sponsor/participant/global
        // Sponsor
        if($type==="sponsor"){
            $dataExport = $wpdb->get_results( "SELECT $select FROM ".$wpdb->base_prefix."atoutcom_users_events_facture WHERE id IN($list) AND concerne='sponsor' ", ARRAY_A);
        }
        // Global
        if($type==="global"){
            $dataExport = $wpdb->get_results( "SELECT $select FROM ".$wpdb->base_prefix."atoutcom_users_events_facture WHERE id IN($list)", ARRAY_A);
        }
        // Participant
        if($type==="participant"){
            $dataExport = $wpdb->get_results( "SELECT $select FROM ".$wpdb->base_prefix."atoutcom_users_events_facture WHERE id IN($list) AND concerne='participant' ", ARRAY_A);
        }  
    }

    
 
    if ( defined('CBXPHPSPREADSHEET_PLUGIN_NAME') && file_exists( CBXPHPSPREADSHEET_ROOT_PATH . 'lib/vendor/autoload.php' ) ) {
        //Include PHPExcel
        require_once( CBXPHPSPREADSHEET_ROOT_PATH . 'lib/vendor/autoload.php' );
        require CBXPHPSPREADSHEET_ROOT_PATH . 'lib/vendor/phpoffice/phpspreadsheet/samples/Header.php';

        //now take instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $spreadsheet->getProperties()
        ->setCreator('Atoutcom')
        ->setLastModifiedBy('Atoutcom')
        ->setTitle('Export '.$type)
        ->setSubject($type)
        ->setDescription('Facture '.$type);


        // Entête du fichier excel
        $spreadsheet->setActiveSheetIndex(0)->fromArray($tabEnteteOrdonnee);
        // On met en gras l'entête
        //$spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true );

        //foreach( $dataExport as $row ) {
        $spreadsheet->setActiveSheetIndex(0)->fromArray($dataExport,NULL,'A2');

        /*foreach(range('A','T') as $columnID) {
           $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }*/

        foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $col) {
            $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        
        // On met en gras l'entête
        $spreadsheet->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true );
        // Renommer la feuille de calcul
        $spreadsheet->getActiveSheet()->setTitle('Export du '.date("d-m-y"));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
        $filename =  ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/Export_Atoutcom_'.$type.'.xlsx';
        $helper->write($spreadsheet, $filename, ['Xlsx']);

        exit;
    }

    wp_die(json_encode(""));    
}
add_action( 'wp_ajax_exportExcel', 'exportExcel' );
add_action( 'wp_ajax_nopriv_exportExcel', 'exportExcel' );


add_filter( 'gform_field_value_nom', 'setNom' );
function setNom( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->nom;
}

add_filter( 'gform_field_value_prenom', 'setPrenom' );
function setPrenom( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->prenom;
}

add_filter( 'gform_field_value_email', 'setEmail' );
function setEmail( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->email;
}

add_filter( 'gform_field_value_adresse', 'setAdresse' );
function setAdresse( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->adresse;
}

add_filter( 'gform_field_value_codepostal', 'setCodepostal' );
function setCodepostal( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->codepostal;
}

add_filter( 'gform_field_value_ville', 'setVille' );
function setVille( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->ville;
}

add_filter( 'gform_field_value_telephone_fixe', 'setTelephoneFixe' );
function setTelephoneFixe( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->telephone_fixe;
}

add_filter( 'gform_field_value_telephone_mobile', 'setTelephoneMobile' );
function setTelephoneMobile( $value ) {
    global $wpdb;
    session_start();
    $email = $_SESSION["loginEmail"];
    $dataUserInfo = atoutcomUser::dataUser($email, "participant");
    return $dataUserInfo->telephone_mobile;
}

// Arrangement des colonnes
function switchCaseColumn($val){
    if($val==="PERIODE"){
        $value="periode";
    }

    if($val==="NUMÉRO"){
        $value="numero";
    }

    if($val==="DATE_CREATION"){
        $value="date_facture";
    }

    if($val==="DESTINATAIRE"){
        $value="destinataire";
    }

    if($val==="INTITULÉ"){
        $value="intitule";
    }
    
    if($val==="SPECIALITÉ"){
        $value="specialite";
    }

    if($val==="ANNÉE"){
        $value="annee";
    }

    if($val==="MontantHT"){
        $value="montantHT";
    }

    if($val==="Ak_TauxTVA"){
        $value="aka_tauxTVA";
    }

    if($val==="MontantTVA"){
        $value="montantTVA";
    }

    if($val==="MontantTTC"){
        $value="montantTTC";
    }

    if($val==="MontantNet€"){
        $value="montantNET";
    }

    if($val==="TOTAL"){
        $value="total";
    }

    if($val==="ACCOMPTE"){
        $value="accompte";
    }

    if($val==="RESTEDÛ"){
        $value="restedu";
    }

    if($val==="PAYÉ"){
        $value="paye";
    }

    if($val==="ENCAISSÉ"){
        $value="encaisse";
    }

    if($val==="Ak_DateReglement"){
        $value="date_reglement";
    }

    if($val==="COMMENTAIRE"){
        $value="commentaire";
    }

    if($val==="CONCERNE"){
        $value="concerne";
    }

    return $value;
}


// Génération de facture
include ( ABSPATH.'wp-content/plugins/atoutcom-users/app/public/lib/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
function genererFacture(
    $langue,
    $titreAdresse, 
    $adresseFacturation,
    $codePostalVille,
    $numeroFacture,
    $dateFacture,
    $evenement,
    $dateAdresse,
    $descriptionDetail,
    $quantite,
    $montantHT,
    $montantTVA,
    $montantTTC,
    $datePaiement,
    $emailContact
)
{
    $numFact = str_replace ("/", "_",  $numeroFacture);

    $htmlFR='
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="'.plugins_url().'/atoutcom-users/app/public/css/facture.css">
        </head>
        <body>
            <div class="header">
                <span class="headerGras">AGENCE ATOUTCOM.COM</span>
                <span class="headerNonGras">
                   Organisation de  Congrès & d\'Événements
                </span>
            </div>
            <div class="factureEntete">
                <div class="adresse">
                    <div class="adresseAtoutcom">
                        <span class="adresseGras">Agence ATouT.Com</span><br>
                        <span class="">Le Tertia 1</span><br>
                        <span class="">5, Rue Charles Duchesne</span><br>
                        <span class="">13290 Aix en Provence</span><br>
                        <span class="adresseGras">Personne à contacter:</span><br>
                        <span class="">Christelle Noccela</span><br>
                        <span class="">04 42 54 42 60 - gyneco@atoutcom.com</span>
                    </div>
                    
                    <div class="adresseFacturation">
                        <span class="adresseSouligneTitre">Adresse de Facturation</span><span class="espace">Adresses</span><br><br>
                        <span class="adresseGras">'.$titreAdresse.'</span><br>
                        <span class="">'.$adresseFacturation.'</span><br>
                        <span class="">'.$codePostalVille.'</span><br><br>
                        <span class="adresseSouligneTVA">N° TVA Intracommunautaire</span><br>
                    </div>
                </div>

                <div class="factureDetail">
                    <span class="adresseGras factNum">FACTURE N° : </span>
                    <span class="espace">Espa</span>
                    <span class="factNumSouligne"><b>'.$numeroFacture.'</b></span>
                    <br><br>
                    <span class="adresseGras factDate">Date de Facturation : </span>
                    <span class="adresseGras">'.$dateFacture.'</span>
                    <br><br>
                    <span class="adresseGras factMonnaie">Monnaie :</span>
                    <span class="espace">Espace f act</span> 
                    <span class="adresseGras">EURO</span>
                </div>
            </div>

            <div class="factureData">
                <table width="100%">
                    <tr>
                        <td class="noBorder">Commande n°</td>
                        <td class="noBorder">DESCRIPTION</td>
                        <td class="noBorder">QUANTITÉ</td>
                        <td class="noBorder">MONTANT HT</td>
                        <td class="noBorder">TVA 20%</td>
                        <td class="noBorder">MONTANT TTC</td>
                    </tr>
                    <tr>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">/</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras titreCongres">'.$evenement.'</span><br>
                            <span class="adresseGras dateAdresseCongres">'.$dateAdresse.'</span><br>
                            <span class="adresseGras detailCongres">'.$descriptionDetail.'</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras quantite">'.$quantite.'</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">'.$montantHT.'€</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">'.$montantTVA.'€</span>
                        </td>
                        <td class="withBorder">
                            <span class="factNumSouligne">'.$montantTTC.'€</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="infoBancaire">
                <table>
                    <tr>
                        <td class="noBorderBancaire">Informations bancaires :</td>
                        <td class="noBorder"></td>
                    </tr>
                    <tr>
                        <td class="withBorderBancaire" style="border-right: none;">
                            <span class="adresseGras">Date De Paiement : </span>
                            <span class="adresseGras">'.$datePaiement.'</span>
                            <br><br>

                            <span class="adresseGras">Mode de règlement : </span>
                            <span class="adresseGras">Chèque Ou Virement Bancaire</span>
                            <br><br>

                            <span class="adresseGras">Modalités :</span>
                            <br><br>
                            <span class="adresseGras modalite">
                            <i>
                                Pénalité de retard : Dans le cas où le paiement intégral n\'interviendrait pas à la date prévue par
                                les parties, seront exigibles conformément à l\'article L441-6 du Code de Commerce, une
                                indemnité calculée sur la base de trois fois le taux de l\'intérêt légal en vigueur ainsi qu\'une
                                indemnité forfaitaire pour frais de recouvrement de 40€.
                            </i>
                            </span>
                            <br>

                        </td>

                        <td class="withBorderBancaireLeft">
                            <span class="virBancaireSouligne">Par virement bancaire :</span>
                            <br>
                            <span>Banque : Société Générale</span>
                            <br>
                            <span>Adresse : Aix En Provence Les Milles</span>
                            <br>
                            <span>IBAN : FR76 3000 3000 3400 0211 1030 324</span>
                            <br>
                            <span>BIC : SOGEFRPP</span>
                            <br>
                            <span class="virBancaireSouligne">ou par chèque à l\'ordre de : ATouT.Com</span>
                            <br><br>
                            <span class="virBancaireSouligne">N° De T V A / I C </span><span>: Fr 444 80 089 515 000 47</span>
                        </td>
                    </tr>
                </table>
            </div>

            <footer>
                <img src="'.ABSPATH.'wp-content/plugins/atoutcom-users/app/public/images/logoAtoutcom.png">
            </footer>
        </body>
    </html>'; 

    
    // Facture en Anglais
    $htmlEN ='
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="'.plugins_url().'/atoutcom-users/app/public/css/facture.css">
        </head>
        <body>
            <div class="header">
                <span class="headerGras">AGENCE ATOUTCOM.COM</span>
                <span class="headerNonGras">
                   Organisation de  Congrès & d\'Événements
                </span>
            </div>
            <div class="factureEntete">
                <div class="adresse">
                    <div class="adresseAtoutcom">
                        <span class="adresseGras">Agence ATouT.Com</span><br>
                        <span class="">Le Tertia 1</span><br>
                        <span class="">5, Rue Charles Duchesne</span><br>
                        <span class="">13290 Aix en Provence</span><br>
                        <span class="adresseGras">Personne à contacter:</span><br>
                        <span class="">Christelle Noccela</span><br>
                        <span class="">04 42 54 42 60 - gyneco@atoutcom.com</span>
                    </div>
                    
                    <div class="adresseFacturation">
                        <span class="adresseSouligneTitre">Invoice Address</span><span class="espace">Invoice Address</span><br><br>
                        <span class="adresseGras">'.$titreAdresse.'</span><br>
                        <span class="">'.$adresseFacturation.'</span><br>
                        <span class="">'.$codePostalVille.'</span><br><br>
                        <span class="adresseSouligneTVA">N° TVA Intracommunautaire</span><br>
                    </div>
                </div>

                <div class="factureDetail">
                    <span class="adresseGras factNum">INVOICE N° : </span>
                    <span class="espace">Espa</span>
                    <span class="factNumSouligne"><b>'.$numeroFacture.'</b></span>
                    <br><br>
                    <span class="adresseGras factDate">Date Of Invoice : </span>
                    <span class="adresseGras">'.$dateFacture.'</span>
                    <br><br>
                    <span class="adresseGras factMonnaie">Currency :</span>
                    <span class="espace">Espace f act</span> 
                    <span class="adresseGras">EURO</span>
                </div>
            </div>

            <div class="factureData">
                <table width="100%">
                    <tr>
                        <td class="noBorder">Order N°</td>
                        <td class="noBorder">DESCRIPTION</td>
                        <td class="noBorder">QUANTITY</td>
                        <td class="noBorder">AMOUNT WITHOUT</td>
                        <td class="noBorder">VAT 20%</td>
                        <td class="noBorder">TOTAL AMOUNT</td>
                    </tr>
                    <tr>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">/</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras titreCongres">'.$evenement.'</span><br>
                            <span class="adresseGras dateAdresseCongres">'.$dateAdresse.'</span><br>
                            <span class="adresseGras detailCongres">'.$descriptionDetail.'</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras quantite">'.$quantite.'</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">'.$montantHT.'€</span>
                        </td>
                        <td class="withBorder" style="border-right: none;">
                            <span class="adresseGras">'.$montantTVA.'€</span>
                        </td>
                        <td class="withBorder">
                            <span class="factNumSouligne">'.$montantTTC.'€</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="infoBancaire">
                <table>
                    <tr>
                        <td class="noBorderBancaire">Bank details :</td>
                        <td class="noBorder"></td>
                    </tr>
                    <tr>
                        <td class="withBorderBancaire" style="border-right: none;">
                            <span class="adresseGras">Date Of Payment : </span>
                            <span class="adresseGras">'.$datePaiement.'</span>
                            <br><br>

                            <span class="adresseGras">Mode of payment : </span>
                            <span class="adresseGras">Check Or Bank Transfer</span>
                            <br><br>

                            <span class="adresseGras">Modalités :</span>
                            <br><br>
                            <span class="adresseGras modalite">
                            <i>
                                Late penalty : If full payment is not made on time by the parties, will be payable in
                                accordance with article L441-6 of the Commercial Code, compensation calculated on
                                the basis of three times the rate of the legal interest rate and a fixed compensation
                                for recovery costs 40 €.
                            </i>
                            </span>
                            <br>

                        </td>

                        <td class="withBorderBancaireLeft">
                            <span class="virBancaireSouligne">Wire Transfer :</span>
                            <br>
                            <span>Banque : Société Générale</span>
                            <br>
                            <span>Adresse : Aix En Provence Les Milles</span>
                            <br>
                            <span>IBAN : FR76 3000 3000 3400 0211 1030 324</span>
                            <br>
                            <span>BIC : SOGEFRPP</span>
                            <br>
                            <span class="virBancaireSouligne">or by check payable to : ATouT.Com</span>
                            <br><br>
                            <span class="virBancaireSouligne">N° De T V A / I C </span><span>: Fr 444 80 089 515 000 47</span>
                        </td>
                    </tr>
                </table>
            </div>

            <footer>
                <img src="'.ABSPATH.'wp-content/plugins/atoutcom-users/app/public/images/logoAtoutcom.png">
            </footer>
        </body>
    </html>'; 

    $dompdf = new Dompdf();
    //Selection du template en fonction de la langue
    if($langue === "fr"){
        $fichierPDF = ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/Factures/Facture_'.$numFact.'.pdf';
        $subject = 'Facture';
        $body = 'Nous vous remercions pour votre participation.<br>Vous trouverez ci-joint la facture';
        $dompdf->loadHtml($htmlFR);
    }else{
        $fichierPDF = ABSPATH.'wp-content/plugins/atoutcom-users/app/public/uploads/Factures/Invoice_'.$numFact.'.pdf';
        $subject = 'Invoice';
        $body = 'Thank you for your parthnership.';
        $dompdf->loadHtml($htmlEN);
    }
    
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdf_gen = $dompdf->output();

    if(file_put_contents($fichierPDF, $pdf_gen)){
        //En local pas d'envoie de mail
        if( strpos($_SERVER['SERVER_NAME'], "localhost") !== false){
            $retour = "success";
        }else{
            $attachments = array( $fichierPDF );
            
            $headers = array('Content-Type: text/html; charset=UTF-8');
            if(wp_mail( $emailContact, $subject, $body, $headers, $attachments )){
                $retour = "success";
            }else{
                $retour = "errorMail";
            }
        }
    }else{
        $retour = "error";
    }
    return $retour; 
}