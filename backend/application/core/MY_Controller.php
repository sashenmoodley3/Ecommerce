<?php
Class MY_Controller Extends CI_Controller{

    public function __construct(){
        parent::__construct();
         $language = $this->db
                ->select('language_name')
                ->where('status', 1)
                ->get('language_setting')
                ->row();
        if($language->language_name == "arabic"){
            $this->lang->load('ps', 'arabic');
        }elseif($language->language_name == "english"){
            $this->lang->load('ps', 'english');
        }elseif($language->language_name == "spanish"){
            $this->lang->load('ps', 'spanish');
        }elseif($language->language_name == "hindi"){
            $this->lang->load('ps', 'hindi');
        }elseif($language->language_name == "greek"){
            $this->lang->load('ps', 'greek');
        }
        if($this->input->get('lang')){
            $this->session->set_userdata(array("language"=>$language->language_name));
            $this->lang->load('ps', $language->language_name);
        }
    }
    
}
?>