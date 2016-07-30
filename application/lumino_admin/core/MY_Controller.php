<?php

/**
 * The base controller which is used by the Front and the Admin controllers
 */
class Base_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

//end __construct()
}

//end Base_Controller

class Front_Controller extends Base_Controller {    

    function __construct() {

        parent::__construct();

        //load GoCart library
                
        //load needed models        

        //load helpers                

        //load the theme package
        $this->load->add_package_path(APPPATH . 'themes/' . $this->config->item('theme') . '/');
    }

    /*
      This works exactly like the regular $this->load->view()
      The difference is it automatically pulls in a header and footer.
     */

    function view($view, $vars = array(), $string = false) {
        if ($string) {
            $result = $this->load->view('header', $vars, true);
            $result .= $this->load->view($view, $vars, true);
            $result .= $this->load->view('footer', $vars, true);

            return $result;
        } else {
            $this->load->view('header', $vars);
            $this->load->view($view, $vars);
            $this->load->view('footer', $vars);
        }
    }

    /*
      This function simple calls $this->load->view()
     */

    function partial($view, $vars = array(), $string = false) {
        if ($string) {
            return $this->load->view($view, $vars, true);
        } else {
            $this->load->view($view, $vars);
        }
    }

}