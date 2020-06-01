<?php

/**
 *
 * @class AtoutcomUsersLoader
 *
 * @author Eybios
 */
class AtoutcomUsersLoader extends MvcPluginLoader
{

  /**
   * @var float $db_version
   *
   * Version number to put in DB
   */
    private $db_version = 2.0;

    /**
     * @var array $tables
     *
     * Variable to store the tables to create
     */
    private $tables = [$wpdb->base_prefix ."atoutcom_users"];

    public function init()
    {
    }

    public function activate($network_wide = false)
    {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    
        // check if it is a network activation - if so, run the activation public function for each blog id
        if ($network_wide && function_exists('is_multisite') && is_multisite()) {
            // Get all blog ids and activate / create tables on each current
            // exisiting blog
            $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
            foreach ($blog_ids as $blog_id) {
                $this->activate_blog($blog_id);
            }
        } else {
            // single blog
            $this->activate_blog();
        }

        // This call needs to be made to activate this app within WP MVC
        $this->activate_app(__FILE__);

        return;
    }

    public function deactivate($network_wide = false)
    {
        global $wpdb;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // This call needs to be made to deactivate this app within WP MVC
        $this->deactivate_app(__FILE__);

        // check if it is a network activation - if so, run the deactivation public function for each blog id
        if ($network_wide && function_exists('is_multisite') && is_multisite()) {
            // check if it is a network activation - if so, run the activation public function for each blog id
            if (!empty($network_wide) && $network_wide) {
                // Get all blog ids
                $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                foreach ($blog_ids as $blog_id) {
                    $this->deactivate_blog($blog_id);
                }
            }
        } else {
            // single blog
            $this->deactivate_blog();
        }

        return;
    }

    /**
     * activate_blog()
     *
     * Setup the required tables for the plugin for $blog_id.
     *
     * @param $blog_id - The id of the blog to work against
     *
     * @return void
     */
    public function activate_blog($blog_id = 1)
    {
        if ($blog_id == 1) {
            add_option('atoutcom_users_db_version', $this->db_version);
            $this->create_tables();
        } else {
            switch_to_blog($blog_id);
            add_option('atoutcom_users_db_version', $this->db_version);
            $this->create_tables();
            restore_current_blog();
        }
    }

    /**
     * deactivate_blog()
     *
     * Remove the tables used by the plugin for $blog_id.
     *
     * @param $blog_id - The id of the blog to work against
     *
     * @return void
     */
    public function deactivate_blog($blog_id = 1)
    {
        if ($blog_id == 1) {
            delete_option('atoutcom_users_db_version');
            $this->delete_tables();
        } else {
            switch_to_blog($blog_id);
            delete_option('atoutcom_users_db_version');
            $this->delete_tables();
            restore_current_blog();
        }
    }

    /**
     * create_tables()
     *
     * Create the required table for the plugin.
     *
     * @return void
     */
    private function create_tables()
    {
        global $wpdb;
        // this needs to occur at this level, and not in the
        // constructor/init since we are switching blogs for multisite
        $this->tables = [
            'users' => $wpdb->base_prefix .'atoutcom_users',
            'users_file' => $wpdb->base_prefix .'atoutcom_users_file',
            'users_events_status' => $wpdb->base_prefix .'atoutcom_users_events_status',
            'users_events_facture' => $wpdb->base_prefix .'atoutcom_users_events_facture'
        ];

        /* http://wiip.fr/content/choisir-le-type-de-colonne-de-ses-tables-mysql */
        $sql = '
            CREATE TABLE IF NOT EXISTS '.$this->tables['users'].'(
                id int(11) NOT NULL auto_increment,
                PRIMARY KEY (id),
                nom VARCHAR(255) NOT NULL,
                prenom VARCHAR(255) NOT NULL,
                email VARCHAR(320) NOT NULL,
                password VARCHAR(500) NOT NULL,
                adresse CHAR(255),
                codepostal CHAR(10),
                ville CHAR(60),
                pays CHAR(60),
                telephone_mobile CHAR(20),
                telephone_fixe CHAR(20),
                dateinscription CHAR(20) NOT NULL,
                statut VARCHAR(15),
                specialite VARCHAR(100),
                categorie VARCHAR(20),
                isUpdate VARCHAR(10),
                organisme_facturation CHAR(100),
                email_facturation CHAR(255),
                adresse_facturation CHAR(255),
                ville_facturation CHAR(60),
                codepostal_facturation CHAR(10),
                pays_facturation CHAR(50)
                

        )';

        dbDelta($sql);

        $sql = '
            CREATE TABLE IF NOT EXISTS '.$this->tables['users_file'].'(
                id int(11) NOT NULL auto_increment,
                PRIMARY KEY (id),
                email VARCHAR(320) NOT NULL,
                fichier VARCHAR(500) NOT NULL,
                chemin VARCHAR(500) NOT NULL,
                date_enregistrement VARCHAR(500) NOT NULL,
                type_doc VARCHAR(100) NOT NULL
                
        )';

        dbDelta($sql);

        $sql = '
            CREATE TABLE IF NOT EXISTS '.$this->tables['users_events_status'].'(
                id int(11) NOT NULL auto_increment,
                PRIMARY KEY (id),
                email VARCHAR(320) NOT NULL,
                id_event int(11) NOT NULL,
                status VARCHAR(50) NOT NULL
                
        )';

        dbDelta($sql);

        $sql = '
        CREATE TABLE IF NOT EXISTS '.$this->tables['users_events_facture'].'(
            id int(11) NOT NULL auto_increment,
            PRIMARY KEY (id),
            periode CHAR(50),
            numero CHAR(50),
            date_facture CHAR(20),
            destinataire CHAR(100),
            intitule CHAR(250),
            specialite CHAR(20),
            annee CHAR(10),
            montantHT DECIMAL(10,2),
            aka_tauxTVA DECIMAL(10,2),
            montantTVA DECIMAL(10,0),
            montantTTC DECIMAL(10,0),
            montantNET DECIMAL(10,0),
            total DECIMAL(10,0),
            accompte DECIMAL(10,0),
            restedu DECIMAL(10,0),
            paye DECIMAL(10,0),
            encaisse DECIMAL(10,0),
            date_reglement CHAR(20),
            commentaire CHAR(250),
            concerne CHAR(50)
                
        )';

        dbDelta($sql);
    }

    /**
     * delete_tables()
     *
     * Delete the tables which are required by the plugin.
     *
     * @return void
     */
    private function delete_tables()
    {
        // global $wpdb;

        // this needs to occur at this level, and not in the

        // foreach ($this->tables as $tablename) {
        //    $sql = 'DROP TABLE IF EXISTS ' . $tablename;
        //    $wpdb->query($sql);
        // }
    }
    /**
     * insert_example_data()
     *
     * Insert some dummy data
     *
     * @return void
     */
    private function insert_example_data()
    {
        
        // Only insert the example data if no data already exists
        $sql = '
          SELECT
              id
          FROM
              ' . $this->tables['users'] . '
          LIMIT
              1';
        $data_exists = $this->wpdb->get_var($sql);
        if ($data_exists) {
            return false;
        }

        // Insert example data

        $users = [
          [
              'nom' => 'users1',
              'id' => 1,
          ],
          [
              'nom' => 'user2',
              'id' => 2,
          ]
      ];
        foreach ($users as $row) {
            $this->wpdb->insert($this->tables['users'], $row);
        }
    }
}
