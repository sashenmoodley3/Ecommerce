<<<<<<< HEAD
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $this->load->view('welcome_message');
    }
    public function hello() {
        //$this->load->view('welcome_message');
        echo "Hello Robin";
    }

}
=======
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        $this->load->view('welcome_message');
    }
    public function hello() {
        //$this->load->view('welcome_message');
        echo "Hello Robin";
    }

}
>>>>>>> main
