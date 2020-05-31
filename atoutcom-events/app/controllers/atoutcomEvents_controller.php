<?php

/* Partie Utilisateur */

class EventsController extends MvcPublicController
{

    public function __construct(){
        parent::__construct();
        /*$logged_user = $this->model->find_by_id(1);// TODO change static id for dynamic one
        $this->set('object',$logged_user);*/
    }
    // Overwrite the default index() method to include the 'is_public' => true condition
    public function index()
    {
        $this->params['page'] = empty($this->params['page']) ? 1 : $this->params['page'];
        $collection = $this->model->paginate($this->params);
        $this->set('objects', $collection['objects']);
        $this->set_pagination($collection);
    }
    public function get_login(){
        $this->set('action','post_login');
    }
    public function post_login(){
        return $_POST;
    }

    public function get_table(){
        return "wp_atoutcom_events";
    }
}
