<?php

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('login');
    }

    function index() {
        if(LoginHelper::isLogged()){
            redirect('socios');
        }
        
        $csrf = array('name' => $this->security->get_csrf_token_name(),
                      'hash' => $this->security->get_csrf_hash()
                );
        
        $this->load->view("homepage", array("csrf" => $csrf));
    }
    
    function logar() {
        #Carrega bibliotecas
        $this->load->library(array('form_validation','user_agent'));
        
        #Regras de validacao do formulario
        $this->form_validation->set_rules('username', 'Nome de usuário', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Senha', 'trim|required|max_length[20]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        #JSON erro/sucesso javascript
        $json = array();
        
        try{
            #Verifica dados do form
            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors());
            }
            
            #Verifica dados credenciais
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            
            if(!LoginHelper::login($username, $password)) {
                throw new Exception('A combinação de usuário e senha está errada.');
            }

            $json["redirect"] = base_url("socios");
            
        } 
        catch (Exception $ex) {
            
            $json["sucesso"] = false;
            $json["erro"] = $ex->getMessage();
            
        }
        finally{
            
            #Define tipo do cabeçalho para JSON
            header('Content-Type: application/json');
            
            #Retorna objeto JSON
            echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        }
    }

    /**
     * Desloga e redireciona para a index
     * @param string $redirect
     */
    function logout() {
        LoginHelper::logout(base_url(''));
    }

}
