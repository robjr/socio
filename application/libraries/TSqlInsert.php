<?php

/**
 * classe TSqlInsert
 * Esta classe prove meios para manipulacao de uma instrucao de INSERT no banco de dados
 */
final class TSqlInsert extends TSqlInstruction {

    private $columnValues;

    /**
     * Atribui valores a determinadas colunas no banco de dados que serao inseridas
     * @param string $column Coluna da tabela
     * @param mixed $value Valor a ser armazenado
     */
    public function setRowData($column, $value) {
        $CI = & get_instance();
        // verifica se e um dado escalar (string, inteiro, ...)
        if (is_scalar($value)) {
            if (is_string($value) and ( !empty($value))) {
                // adiciona \ em aspas
                //$value = addslashes($value);
                $value = $CI->db->escape($value);
                // caso seja uma string
                $this->columnValues[$column] = $value;
            } else if (is_bool($value)) {
                // caso seja um boolean
                $this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
            } else if ($value !== '') {
                // caso seja outro tipo de dado
                $this->columnValues[$column] = $CI->db->escape($value);
            } else {
                // caso seja NULL
                $this->columnValues[$column] = "NULL";
            }
        }
    }

    /**
     * Nao existe no contexto desta classe, logo, ira lancar um erro ser for executado
     */
    public function setCriteria($criteria) {
        // lanca o erro
        throw new Exception("Cannot call setCriteria from " . __CLASS__);
    }

    /**
     * @return string A instrucao de INSERT em forma de string.
     */
    public function getInstruction() {
        $this->sql = "INSERT INTO {$this->entity} (";
        // monta uma string contendo os nomes de colunas
        $columns = implode(', ', array_keys($this->columnValues));
        // monta uma string contendo os valores
        $values = implode(', ', array_values($this->columnValues));
        $this->sql .= $columns . ')';
        $this->sql .= " VALUES ({$values})";
        return $this->sql;
    }

}
