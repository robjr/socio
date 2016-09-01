<?php

/**
 * Classe EmpresaMapper. Assim como todos os mappers que herdam a classe
 * DAO, as constantes desta classe representam as variaveis que podem ser utili-
 * zadas na classe TCriteria e que ha seguranca de haver no banco de dados.
 * @author Roberto Júnior
 * @version %I%, %G%
 * @see TCriteria
 * @since 1.0 
 */
class EmpresaMapper extends DAO {

    //Variaveis cujo valor tem a mesma nomenclatura do banco de dados.
    //Relacao com todos os campos do banco de dados.
    const ID_EMP = "id";
    const CNPJ_EMP = "cnpj";

    //Variaveis com a mesma nomenclatura do banco de dados.
    protected $id;
    protected $cnpj;

    /*
     * Construtor da classe. Faz a conversao obj->relacional.
     * @param Empresa Recebe um objeto empresa ou nulo, caso deseje-se
     *                    apenas leitura. 
     * @see Empresa
     * @since 1.0
     */
    public function __construct($Empresa=NULL) {
        parent::__construct();
        if($Empresa !== NULL){
            $this->id = $Empresa->getId();
            $this->cnpj = $Empresa->getCnpj();
        }
    }

    /*
     * Faz a conversao relacional->objeto.
     * @param Recebe como um parametro uma linha/objeto do banco de dados.
     * @return Usuario Retorna um objeto do tipo da classe.
     * @since 1.0
     */ 
    protected function parseToObject($row) {
        
        $socio = new Empresa();
        
        $socio->setId((int) $row->{self::ID_EMP});
        $socio->setCnpj($row->{self::CNPJ_EMP});
        
        return $socio;
    }
    


}
