<?php

class Socio extends CI_Model {

    private $id;
    private $cpf;
    private $email;
    private $nome;
    
    public function __construct() {
        $this->load->helper("typeException");
        $this->load->helper("typeValidation");
    }

    public function setNome($nome) {
        if (!is_string($nome)) {
            throw new TypeException(TypeException::STRING);
        }
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setEmail($email) {
        
        if (!TypeValidation::isEmail($email)){
            throw new TypeException(TypeException::EMAIL);
        }
        
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
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

    public function setCpf($cpf) {
        if (!TypeValidation::isCpf($cpf)) {
            throw new TypeException(TypeException::CPF);
        }
        $this->cpf = $cpf;
    }

    public function getCpf() {
        return $this->cpf;
    }

}
