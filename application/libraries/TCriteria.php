<?php

/**
 * classe TCriteria
 * Esta classe prove uma interface utilizada para definicao de criterios
 */
class TCriteria extends TExpression {

    /**
     * @var array Armazena a lista de expressoes
     */
    private $expressions;

    /**
     * @var array Armazena a lista de operadores
     */
    private $operators;

    /**
     * @var array Propriedades do criterio
     */
    private $properties;

    /**
     * Metodo Construtor
     */
    function __construct() {
        $this->expressions = array();
        $this->operators = array();
    }

    /**
     * Adiciona uma expressao ao criterio
     * @param TExpression $expression Expressao (objeto TExpression)
     * @param string $operator [optional] Operador logico de comparacao. Utilizar constantes definidas na classe TExpression
     */
    public function add(TExpression $expression, $operator = self::AND_OPERATOR) {
        // na primeira vez, nao precisamos de operador logico para concatenar
        if (empty($this->expressions)) {
            $operator = NULL;
        }

        // agrega o resultado da expressao a lista de expressoes
        $this->expressions[] = $expression;
        $this->operators[] = $operator;
    }

    /**
     * @return A expressao final
     */
    public function dump() {
        // concatena a lista de expressoes
        if (is_array($this->expressions)) {
            if (count($this->expressions) > 0) {
                $result = '';
                foreach ($this->expressions as $i => $expression) {
                    $operator = $this->operators[$i];
                    // concatena o operador com a respectiva expressao
                    $result .= $operator . $expression->dump() . ' ';
                }
                $result = trim($result);
                return "({$result})";
            }
        }
    }

    /**
     * Define o valor de uma propriedade
     * @param mixed $property Propriedade
     * @param mixed $value Valor
     */
    public function setProperty($property, $value) {
        if (isset($value)) {
            $this->properties[$property] = $value;
        } else {
            $this->properties[$property] = NULL;
        }
    }

    /**
     * @param mixed $property Propriedade
     * @return O valor da propriedade passada em parâmetro
     */
    public function getProperty($property) {
        if (isset($this->properties[$property])) {
            return $this->properties[$property];
        }
    }

}
