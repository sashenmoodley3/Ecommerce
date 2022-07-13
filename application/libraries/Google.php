<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH .'third_party/google-php-sdk/autoload.php';


Class Google
{
    private $GoogleClient;
    private $GoogleAuth;
    private $GoogleConfig;
	
	
    public function __construct(){
        // Load config
		$this->ci =& get_instance();
		$this->ci->config->load('google');
		$this->GoogleConfig = $this->ci->config->item('google');
		$this->base_url = $this->ci->config->item('base_url');
		$this->client_id = $this->ci->config->item('google_client_id');
		$this->client_secret = $this->ci->config->item('google_client_secret');
		
        
        // Load required libraries and helpers
        $this->GoogleClient = new Google_Client();
		$this->GoogleClient->setClientId($this->client_id);
		$this->GoogleClient->setClientSecret($this->client_secret);
		$this->GoogleClient->setRedirectUri($this->base_url.$this->GoogleConfig['redirect_uri']);
		$this->GoogleClient->addScope($this->GoogleConfig['scopes']);
	}
	
    public function login_url(){
		return $this->GoogleClient->createAuthUrl();
    }
	
    public function getAuth(){
		$this->GoogleClient->authenticate($_GET['code']); 
		$token = $this->GoogleClient->getAccessToken(); 
		$_SESSION['token'] = $token;
		
		if(!empty($_SESSION['token']) || empty($token)){
			$token = $_SESSION['token'];
		}
		
		$this->GoogleClient->setAccessToken($token['access_token']);
		
		if(!empty($token['access_token'])){
			return true;
		}
		
		return false;

    }
	
    public function getUserInfo(){
		
		
		$this->GoogleAuth = new Google_Service_Oauth2($this->GoogleClient);
		return $this->GoogleAuth->userinfo->get();
    }
	
	
	

    

}
