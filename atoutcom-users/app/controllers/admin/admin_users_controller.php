<?php

/* Partie Admin */

class AdminUsersController extends MvcAdminController
{
    /*public $default_search_joins = array('Speaker', 'Venue');
    public $default_searchable_fields = array('Speaker.first_name', 'Speaker.last_name', 'Venue.name');*/
    public $default_columns = array(
        'id', 'nom'
    );

    function edition() {

    }

}
