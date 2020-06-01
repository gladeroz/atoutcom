<?php

/**
 *
 * @class AtoutcomEventsLoader
 *
 * @author Eybios
 */
class AtoutcomEventsLoader extends MvcPluginLoader
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
    private $tables = [$wpdb->prefix."_atoutcom_events"];

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
            add_option('atoutcom_events_db_version', $this->db_version);
            $this->create_tables();
        } else {
            switch_to_blog($blog_id);
            add_option('atoutcom_events_db_version', $this->db_version);
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
            delete_option('atoutcom_events_db_version');
            $this->delete_tables();
        } else {
            switch_to_blog($blog_id);
            delete_option('atoutcom_events_db_version');
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
            'events_intervenants' => $wpdb->prefix.'atoutcom_events_intervenants'
        ];

        /* http://wiip.fr/content/choisir-le-type-de-colonne-de-ses-tables-mysql */
        $sql = '
            CREATE TABLE IF NOT EXISTS'.$this->tables['events_intervenants'].'(
            id int(11) NOT NULL auto_increment,
            PRIMARY KEY (id),
            evenement VARCHAR(255),
            date_evenement VARCHAR(20),
            nom VARCHAR(50),
            prenom VARCHAR(50),
            email VARCHAR(50),
            telephone VARCHAR(20),
            adresse VARCHAR(50),
            code_postal VARCHAR(50),
            ville VARCHAR(100),
            pays VARCHAR(50)       
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

        //foreach ($this->tables as $tablename) {
        //    $sql = 'DROP TABLE IF EXISTS ' . $tablename;
        //    $wpdb->query($sql);
        //}
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
              ' . $this->tables['events'] . '
          LIMIT
              1';
        $data_exists = $this->wpdb->get_var($sql);
        if ($data_exists) {
            return false;
        }

        // Insert example data

        $events = [
          [
              'titre' => 'events1',
              'organisateur' => 'org1',
          ],
          [
              'titre' => 'event2',
              'organisateur' => 'org2',
          ]
      ];
        foreach ($events as $row) {
            $this->wpdb->insert($this->tables['events'], $row);
        }
    }
}
