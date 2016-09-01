<?php

/**
 * classe TFilter
 * Esta classe prove uma interface para definicao de filtros de selecao
 */
class TFilter extends TExpression {

    /**
     * @var mixed Variavel
     */
    private $variable;

    /**
     * @var string Operador
     */
    private $operator;

    /**
     * @var mixed Valor
     */
    private $value;

    /**
     * Instancia um novo filtro
     * @param mixed $variable = variavel
     * @param string $operator = operador (>,<)
     * @param mixed $value    = valor a ser comparado
     * @param boolean $transform = caso false, nao aplica transformacao no valor
     */
    public function __construct($variable, $operator, $value, $transform = true) {
        // armazena as propriedades
        $this->variable = $variable;
        $this->operator = $operator;

        /**
         * Transforma o valor de acordo com certas regras
         * antes de atribuir a propriedade $this->value
         */
        if ($transform) {
            $this->value = $this->transform($value);
        } else {
            $this->value = $value;
        }
    }

    /**
     * Recebe um valor e faz as modificacoes necessarias
     * para ele ser interpretado pelo banco de dados
     * podendo ser um integer/string/boolean ou array.
     * @param mixed $value Valor a ser transformado
     * @return mixed O valor transformado
     */
    private function transform($value) {
        $CI = & get_instance();
        // caso seja um array
        if (is_array($value)) {
            // percorre os valores
            foreach ($value as $x) {
                // se for um inteiro
                if (is_integer($x)) {
                    $foo[] = $x;
                } else if (is_string($x)) {
                    // se for string, adiciona aspas
                    $foo[] = $CI->db->escape($x);
                }
            }
            // converte o array em string separada por ","
            $result = '(' . implode(',', $foo) . ')';
        }
        // caso seja uma string
        else if (is_string($value)) {
            // adiciona aspas
            $result = $CI->db->escape($value);
        }
        // caso seja valor nullo
        else if (is_null($value)) {
            // armazena NULL
            $result = 'NULL';
        }

        // caso seja booleano
        else if (is_bool($value)) {
            // armazena TRUE ou FALSE
            $result = $value ? 'TRUE' : 'FALSE';
        } else {
            $result = $CI->db->escape($value);
        }
        // retorna o valor
        return $result;
    }

    /**
     * @return string O filtro em forma de expressao
     */
    public function dump() {
        // concatena a expressao
        return "{$this->variable} {$this->operator} {$this->value}";
    }

}
