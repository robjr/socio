<?php

class Empresa extends CI_Model {

    private $id;
    private $cnpj;
    
    public function __construct() {
        $this->load->helper("typeException");
        $this->load->helper("typeValidation");
    }

    public function setId($id) {
        if (!is_int($id)) {
            throw new TypeException(TypeException::INTEGER);
        }
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }    
    
    public function setCnpj($cnpj) {
        if (!TypeValidation::isCnpj($cnpj)) {
            throw new TypeException(TypeException::CNPJ);
        }
        $this->cnpj = $cnpj;
    }

    public function getCnpj() {
        return $this->cnpj;
    }


}
