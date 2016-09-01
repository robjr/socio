<?php

/**
 * Classe TSqlUpdate
 * Esta classe prove meios para manipulacao de uma instrucao de UPDATE no banco de dados
 */
final class TSqlUpdate extends TSqlInstruction {

    private $columnValues;

    /**
     * Atribui valores a determinadas colunas no banco de dados que serao modificadas
     * @param string $column Coluna da tabela
     * @param mixed $value Valor a ser armazenado
     */
    public function setRowData($column, $value) {
        $CI = & get_instance();
        // verifica se e um dado escalar (string, inteiro,...)
        if (is_scalar($value)) {
            if (is_string($value) and (!empty($value))) {
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
     * @return string A instrucao de UPDATE em forma de string.
     */
    public function getInstruction() {
        // monsta a string de UPDATE
        $this->sql = "UPDATE {$this->entity}";
        // monta os pares: coluna=valor,...
        if ($this->columnValues) {
            foreach ($this->columnValues as $column => $value) {
                $set[] = "{$column} = {$value}";
            }
        }
        $this->sql .= ' SET ' . implode(', ', $set);
        // retorna a cl�usula WHERE do objeto $this->criteria
        if ($this->criteria) {
            $this->sql .= ' WHERE ' . $this->criteria->dump();
        }
        return $this->sql;
    }

}
