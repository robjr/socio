<?php

/**
 * classe TSqlSelect
 * Esta classe prove meios para manipulacao de uma instrucao de SELECT no banco de dados
 */
final class TSqlSelect extends TSqlInstruction {

    /**
     * @var array Array de colunas a serem retornadas
     */
    private $columns;

    /**
     * Adiciona uma coluna a ser retornada pelo SELECT
     * 
     * @param string $column A coluna da tabela
     */
    public function addColumn($column) {
        // adiciona a coluna no array
        $this->columns[] = $column;
    }

    /**
     * @return string A instrucao de SELECT em forma de string.
     */
    public function getInstruction() {
        // monta a instrucao de SELECT
        $this->sql = 'SELECT ';

        // monta string com os nomes de colunas
        $this->sql .= implode(',', $this->columns);

        // adiciona na clausula FROM o nome da tabela
        $this->sql .= ' FROM ' . $this->entity;

        // obtem a clausula WHERE do objeto criteria.
        if ($this->criteria) {
            $expression = $this->criteria->dump();
            if ($expression) {
                $this->sql .= ' WHERE ' . $expression;
            }

            // obtem as propriedades do criterio
            $where = $this->criteria->getProperty('where');
            $order = $this->criteria->getProperty('order');
            $limit = $this->criteria->getProperty('limit');
            $offset = $this->criteria->getProperty('offset');

            // obtem a ordenacao do SELECT
            if ($where) {
                $this->sql .= ' WHERE ' . $where;
            }
            if ($order) {
                $this->sql .= ' ORDER BY ' . $order;
            }
            if ($limit) {
                $this->sql .= ' LIMIT ' . $limit;
            }
            if ($offset) {
                $this->sql .= ' OFFSET ' . $offset;
            }
        }
        return $this->sql;
    }

}
