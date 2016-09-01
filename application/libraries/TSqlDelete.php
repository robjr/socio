<?php

/**
 * classe TSqlDelete
 * Esta classe prove meios para manipulacao de uma instrucao de DELETE no banco de dados
 */
final class TSqlDelete extends TSqlInstruction {

    /**
     * @return string A instrucao de DELETE em forma de string.
     */
    public function getInstruction() {
        // monta a string de DELETE
        $this->sql = "DELETE FROM {$this->entity}";

        // retorna a clausula WHERE do objeto $this->criteria
        if ($this->criteria) {
            $expression = $this->criteria->dump();
            if ($expression) {
                $this->sql .= ' WHERE ' . $expression;
            }
        }
        return $this->sql;
    }

}
