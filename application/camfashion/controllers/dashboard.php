<?php

class Dashboard extends Front_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('dashboard');
    }

}