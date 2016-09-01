<?php

class MY_Controller extends CI_Controller {

     public function __construct() {
         parent::__construct();
         
        #Data
        $global_data = array(); 
         
        # Security
        $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
        );
        
        #Verifica se usuário está logado
        $this->load->helper("login");
        $this->load->helper('url');
        
        $isLogged = LoginHelper::requireLogin();
     
        if(!$isLogged){
            redirect('');
        }
        
        $global_data['csrf'] = $csrf;
        $this->load->vars($global_data);

     }  
}