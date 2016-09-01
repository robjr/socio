<?php

class MY_Form_validation extends CI_Form_validation {

    protected $CI;
    
    function __construct() {
        parent::__construct();
        
        $this->CI = & get_instance();

    }

    function isCpf($str){
        
        #Messagem de erro
        $this->CI->form_validation->set_message('isCpf', '%s está incorreto. Digite um cpf válido.');
        
        #Carrega TypeValidation
        $this->CI->load->helper("typeValidation");
        
        #Validação    
        return TypeValidation::isCpf($str);
        
    }
    
    function isCnpj($str){
        
        #Messagem de erro
        $this->CI->form_validation->set_message('isCnpj', '%s está incorreto. Digite um cnpj válido.');
        
        #Carrega TypeValidation
        $this->CI->load->helper("typeValidation");
        
        #Validação    
        return TypeValidation::isCnpj($str);
        
    }
    
    function isName($str) { 
        
        #Messagem de erro
        $this->CI->form_validation->set_message('isName', '%s está incorreto. Não use abreviações ou números.');
        
        #Validação         
        return (!preg_match('/^[a-z \x{00E0}-\x{00FC}]+$/ui', $str)) ? FALSE : TRUE;
        
    }
    
    function parseToDigits($str) { 
        
        #Parse       
        return preg_replace( '/[^0-9]/is', '', $str );
        
    }

    function matchesDb($str, $field) {
        
        #Messagem de erro
        $this->CI->form_validation->set_message('matchesDb', '%s não está disponível.');

        #Validação 
        list($table, $column) = explode('.', $field, 2);

        $this->CI->load->database();
        $query = $this->CI->db->query("SELECT COUNT(*) AS n FROM $table WHERE $column = '$str'");
        $row = $query->row();
        
        return ($row->n > 0) ? TRUE : FALSE;
        
    }
    
}
