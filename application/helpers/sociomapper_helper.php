<?php

/**
 * Classe SocioMapper. Assim como todos os mappers que herdam a classe
 * DAO, as constantes desta classe representam as variaveis que podem ser utili-
 * zadas na classe TCriteria e que ha seguranca de haver no banco de dados.
 * @author Roberto Júnior
 * @version %I%, %G%
 * @see TCriteria
 * @since 1.0 
 */
class SocioMapper extends DAO {

    //Variaveis cujo valor tem a mesma nomenclatura do banco de dados.
    //Relacao com todos os campos do banco de dados.
    const ID_SOC = "id";
    const CPF_SOC = "cpf";
    const EMAIL_SOC = "email";
    const NOME_SOC = "nome";
    
    

    //Variaveis com a mesma nomenclatura do banco de dados.
    protected $id;
    protected $cpf;
    protected $email;
    protected $nome;

    /*
     * Construtor da classe. Faz a conversao obj->relacional.
     * @param Socio Recebe um objeto socio ou nulo, caso deseje-se
     *                    apenas leitura. 
     * @see Socio
     * @since 1.0
     */
    public function __construct($Socio=NULL) {
        parent::__construct();
        if($Socio !== NULL){
            $this->id = $Socio->getId();
            $this->cpf = $Socio->getCpf();
            $this->email = $Socio->getEmail();
            $this->nome = $Socio->getNome();
        }
    }

    /*
     * Faz a conversao relacional->objeto.
     * @param Recebe como um parametro uma linha/objeto do banco de dados.
     * @return Usuario Retorna um objeto do tipo da classe.
     * @since 1.0
     */ 
    protected function parseToObject($row) {
        
        $socio = new Socio();
        
        $socio->setId((int) $row->{self::ID_SOC});
        $socio->setCpf($row->{self::CPF_SOC});
        $socio->setEmail($row->{self::EMAIL_SOC});
        $socio->setNome($row->{self::NOME_SOC});
        
        return $socio;
    }
    


}
