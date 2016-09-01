<?php

/**
 * classe TSqlInstruction
 * Esta classe prove os metodos em comum entre todas instrucoes
 * SQL (SELECT, INSERT, DELETE e UPDATE)
 */
abstract class TSqlInstruction {

    protected $sql;       // armazena a instrucao SQL
    protected $criteria;  // armazena o objeto criterio
    protected $entity;

    /**
     * Define o nome da entidade (tabela) manipulada pela instrucao SQL
     * @param string $entity O nome da tabela
     */
    final public function setEntity($entity) {
        $this->entity = $entity;
    }

    /**
     * @return string O nome da entidade (tabela)
     */
    final public function getEntity() {
        return $this->entity;
    }

    /**
     * Define um criterio de selecao dos dados atraves da composicao de um objeto
     * do tipo TCriteria, que oferece uma interface para definicao de criterios
     * @param TCriteria $criteria Objeto do tipo TCriteria
     */
    public function setCriteria($TCriteria) {
        $this->criteria = $TCriteria;
    }

    /**
     * Declarando-o como <abstract> obrigamos sua declaracao nas classes filhas, 
     * uma vez que seu comportamento sera distinto em cada uma delas, configurando polimorfismo.
     */
    abstract function getInstruction();
}
