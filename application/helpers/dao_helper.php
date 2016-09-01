<?php

/**
 * Classe DAO. Implementa o CRUD de objetos. <p> Ate a data presente, funciona
 * para relacionamentos 1:n e n:n. </p><p> Funciona em conjunto com um Mapper,
 * aonde cada classe deve ter uma ClasseMapper correspondente que serve como uma
 * ponte de ligacao entre o objeto e o banco de dados. </p>
 *
 * @author Roberto Junior
 * @version %I%, %G%
 * @see TCriteria
 * @since 1.0
 */
abstract class DAO {

    protected $__objects;

    public function __construct() {
        
        $CI = & get_instance();
        
        #Carrega biblioteca de geração de SQL
        $CI->load->helper("loadLibraries");
        loadLibraries();

        $this->__objects = array();
        
    }

    /**
     * Salva o objeto no banco de dados.
     * @return Retorna a id da linha inserida no banco de dados.
     * @throws Exception Lanca excecao em caso de falha.
     * @since 1.0
     */
    public function insert() {
        //gera SQL
        $sql = $this->insertUpdate("Insert");
        
        //Executa o SQL
        $CI = & get_instance();
        $CI->load->database();

        $CI->db->trans_start();
        $query = $CI->db->query($sql);
        
        if (!$query) {
            $erro = $CI->db->error();
            throw new Exception("Erro de conexao ao banco de dados.");
        }
        $id = $CI->db->insert_id();
        /*foreach ($this->__objects as $mapper => $objs) {
            $this->saveRelation($objs, $id, $mapper);
        }*/
        $CI->db->trans_complete();

        return $id;
    }

    /**
     * Atualiza o objeto no banco de dados especificado.
     * @return Retorna o numero de linhas atualizadas no banco de dados.
     * @throws Exception Lanca excecao em caso de falha.
     * @since 1.0
     */
    
    public function update($TCriteria = NULL) {
        //gera SQL
        $sql = $this->insertUpdate("Update", $TCriteria);
        //$tmp = $this->read($TCriteria);

        //Executa o SQL
        $CI = & get_instance();
        $CI->load->database();
        $CI->db->trans_start();

        $query = $CI->db->query($sql);
        if (!$query) {
            throw new Exception("Erro de conexao ao banco de dados: " . $CI->db->error());
        }
        /*
        //Salva relacionamentos
        foreach ($tmp as $v) {
            foreach ($this->__objects as $mapper => $objs) {
                $this->saveRelation($objs, $v->getId(), $mapper);
            }
        }
         */
        $n = $CI->db->affected_rows();
        $CI->db->trans_complete();
        return $n;
    }

    /**
     * Deleta o objeto no banco de dados. Deleta todas as linhas similares ao objeto
     * ou de acordo com especeficado por parametro.
     * @param TCriteria Recebe ou nao um objeto TCriteria como parametro. Caso
     *                  receba, limita-se a delecao de acordo com o criterio.
     * @return Retorna o numero de linhas deletadas no banco de dados.
     * @see TCriteria
     * @since 1.0
     */
    public function delete($TCriteria = NULL) {
        //Pega nome da classe
        $class = get_called_class();
        $dbColumns = $this->getClassVars($class);

        //Cria SQL
        $sql = new TSqlDelete();
        $sql->setEntity($this->getClassName($class));

        if ($TCriteria == NULL) {
            $TCriteria = new TCriteria();
            //Adiciona variaveis/campos no SQL __var_
            foreach ($dbColumns as $k => $v) {
                $TCriteria->add(new TFilter($k, "=", $v), TExpression::AND_OPERATOR);
            }
        }
        $sql->setCriteria($TCriteria);

        //Executa o SQL
        $CI = & get_instance();
        $CI->load->database();
        $query = $CI->db->query($sql->getInstruction());
        if (!$query) {
            throw new Exception("Erro de conexao ao banco de dados: " . $CI->db->error());
        }

        return $CI->db->affected_rows();
    }

    /**
     * Retorna um ou mais objetos do banco de dados.
     * @param TCriteria Recebe ou nao um objeto TCriteria como parametro. Caso
     *                  receba, limita-se a leitura de acordo com o criterio.
     * @param array $columns Um array de colunas a ser retornadas no select
     * @return Retorna a id da linha deletada no banco de dados.
     * @see TCriteria
     * @since 1.0
     */
    public function read($TCriteria = NULL, $columns = array('*')) {
        //Pega nome da classe
        $class = get_called_class();
        $dbColumns = $this->getClassVars($class);
        //Cria SQL
        $sql = new TSqlSelect();
        $sql->setEntity($this->getClassName($class));

        foreach ($columns as $c) {
            $sql->addColumn($c);
        }

        if ($TCriteria == NULL) {
            $TCriteria = new TCriteria();
            //Adiciona variaveis/campos no SQL __var_
            foreach ($dbColumns as $k => $v) {
                $TCriteria->add(new TFilter($k, "=", $v), TExpression::AND_OPERATOR);
            }
        }

        $sql->setCriteria($TCriteria);

        //Executa o SQL
        $CI = & get_instance();
        $CI->load->database();
        $query = $CI->db->query($sql->getInstruction());
        
        $tmp = array();

        if (!$query) {
            throw new Exception("Erro de conexao ao banco de dados: " . $CI->db->error());
        }

        if ($query->num_rows() > 0) {
            $c = 0;
            foreach ($query->result() as $row) {
                //Tentativa de simplificar DAO, pois retornava array de array.
                /* Potencial causador de erros por causa da mudanca com array_merge
                 * uma vez que da o merge do array de retorno com o tmp.
                 * O que acontecei sem o merge: Retorna array(array(Departamento)) por
                 * chamar EscolaDepartamento que chama Departamento
                 * Dever-se-ia retorna um objeto apenas, mas o relacionamento retorna
                 * um array.
                 * A preocupacao estah em Departamento ter outro relacionamento.
                 */
                $s = $this->parseToObject($row);
                if (is_array($s)) {
                    $tmp = array_merge($tmp, $s);
                } else {
                    $tmp[$c++] = $s;
                }
                //Pega Objetos dos Relacionamentos
                foreach ($this->getMappers($class) as $mapper => $objs) {
                    $row->{substr($mapper, 2)} = $this->readRelation($tmp[$c - 1]->getId(), substr($mapper, 2)); //substr retira __
                    $tmp[$c - 1] = $this->parseToObject($row);
                }
            }
        }
        return $tmp;
    }

    //Converte Relacional/Objeto
    protected function parseToObject($row) {

    }

    //Pega valor da variavel da classe/objeto que herda de DAO
    private function getVarValue($var) {
        return $this->{$var};
    }

    //Pega o nome da classe
    private function getClassName($class) {
        $tmp = str_replace("Mapper", "", $class);
        return $tmp;
    }

    //Pega as variaveis da classe/objeto que herda de DAO
    private function getClassVars($class) {
        $tmp = get_class_vars($class);

        //Pega os valores das variaveis
        array_walk($tmp, function(&$value, $varName) {
            $value = $this->getVarValue($varName);
        });

        //Retira variaveis que tem valor NULL e que sao objetos
        $tmp = array_filter($tmp, function($value, $key) {
            if ($this->getVarValue($key) === NULL) { //se valor for nulo, retira do array
                return false;
            } else if (substr($key, 0, 2) == "__") {
                if (substr($key, 2) == "objects") { //Retira a variavel da classe DAO __objects
                    return false;
                }
                $this->__objects[substr($key, 2)] = $value;
                return false;
            }
            return true;
        }
                , ARRAY_FILTER_USE_BOTH);
        return $tmp;
    }

    //Pega as variaveis da classe/objeto que herda de DAO
    private function getMappers($class) {
        $tmp = get_class_vars($class);

        //Retira variaveis que tem valor NULL e que sao objetos
        $tmp = array_filter($tmp, function(&$value, $key) {
            if (substr($key, 0, 2) == "__") {
                if (substr($key, 2) == "objects") { //Retira a variavel da classe DAO __objects
                    return false;
                }
                return true;
            } else {
                return false; //retira variaveis
            }
        }
                , ARRAY_FILTER_USE_BOTH);
        return $tmp;
    }

    //Procedimento para insercao e atualizacao
    //operacao = Insert ou Update
    private function insertUpdate($operacao, $TCriteria = NULL) {

        //Pega nome da classe
        $class = get_called_class();
        $dbColumns = $this->getClassVars($class);

        //Cria SQL
        $sql = $operacao == "Insert" ? new TSqlInsert() : new TSqlUpdate();
        $sql->setEntity($this->getClassName($class));
        
        //Adiciona variaveis/campos no SQL __var_
        foreach ($dbColumns as $k => $v) {
            $sql->setRowData(addslashes($k), addslashes($v));
        }

        if ($TCriteria !== NULL)
            $sql->setCriteria($TCriteria);
        
        return $sql->getInstruction();
    }

    /*
     *
     * @param Recebe parametro um array de objetos.
     * @return
     * @since 1.0
     */

    private function readRelation($idMainObj, $mapper) {
        $CI = & get_instance();
        $CI->load->helper($mapper);

        $tmp = new $mapper($idMainObj);
        return $tmp->read();
    }

    /**
     *
     * @param Recebe parametro um array de objetos.
     * @return
     * @since 1.0
     */
    private function saveRelation($arObj, $idMainObj, $mapper) {
        $CI = & get_instance();
        $CI->load->helper($mapper);
        $tipoObjeto = get_class($arObj[0]);
        $depObjKey = array();
        $depBdKey = array();
        $params = array();

        //Pega todos as Keys dos departamentos desse objeto no BD
        $tmp = new $mapper($idMainObj); //$tmp = new EscolaDepartamentoMapper($this->idEscola); #################### $tmp = call_user_func(createObject,EscolaDepartamentoMapper,$idEscola,NULL);
        $bdDepartamentos = $tmp->read();

        for ($c = 0; $c < sizeof($bdDepartamentos); $c++) {
            $depBdKey[] = $bdDepartamentos[$c]->getId();
        }

        //Pega todas as Keys dos departamentos desse objeto
        for ($c = 0; $c < sizeof($arObj); $c++) {
            $depObjKey[] = $arObj[$c]->getId();
        }
        //Insere os diferentes
        $result = array_diff($depObjKey, $depBdKey);
        var_dump($result);

        foreach ($result as $otherId) {
            $tmp = new $mapper($idMainObj, $otherId);  //$tmp = new EscolaDepartamentoMapper($this->idEscola,$result($c)); ####################
            $tmp->insert();
        }
        //Deleta os diferentes
        $result = array_diff($depBdKey, $depObjKey);
        foreach ($result as $otherId) {
            $tmp = new $mapper($idMainObj, $otherId); //$tmp = new EscolaDepartamentoMapper($this->idEscola,$result($c)); ####################
            $tmp->delete();
        }
    }

}
