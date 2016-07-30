<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lumino_admin extends Front_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    var $controller_name;
    var $method_name;
    var $data;
    function __construct() {
        parent::__construct();
        $this->controller_name = $this->router->fetch_class();
        $this->method_name = $this->router->fetch_method();
        $this->data['method_name'] = $this->method_name;
        $this->data['controller_name'] = $this->controller_name;
    }

    public function index() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function charts() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function widgets() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function tables() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function forms() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function panels() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function icons() {        
        $this->load->view($this->method_name,  $this->data);
    }
    
    public function login() {        
        $this->load->view($this->method_name,  $this->data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */