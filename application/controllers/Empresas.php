<?php

/*
 * Controle para manipular dados relacionados a Empresa.
 */

class Empresas extends MY_Controller  {

    public function __construct() {
        parent::__construct();
        
        #Carrega biblioteca Empresa
        $this->load->model("empresa");
    }

    public function adicionar()
    {
        #Carrega bibliotecas
        $this->load->library('form_validation');
        
        #Carrega helpers ORM
        $this->load->helper(array("dao" , "empresaMapper"));
        
        #Regras de validacao do formulario
        $this->form_validation->set_rules('cnpj', 'CNPJ', "trim|required|parseToDigits|isCnpj|is_unique[empresa.cnpj]|max_length[20]");
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        
        #JSON erro/sucesso javascript
        $json = array();
        
        try{
            #Verifica dados do form
            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors());
            }
            
            #Pega dados do form
            $cnpj = $this->input->post("cnpj");
                 
            #Adiciona dados a Empresa
            $empresa = new Empresa();
            $empresa->setCnpj($cnpj);
           
            #Persite dados no banco
            $empresaMapper = new EmpresaMapper($empresa);
            $empresaMapper->insert();
            
            $json["sucesso"] = true;
            
        } 
        catch (Exception $ex) {
            
            $json["sucesso"] = false;
            $json["erro"] = $ex->getMessage();
            
        }
        finally{
            
            #Define tipo do cabeçalho para JSON
            header('Content-Type: application/json');
            
            #Retorna objeto JSON
            echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        }
        
    }

    public function editar()
    {
        #Carrega bibliotecas
        $this->load->library('form_validation');
        
        #Carrega helpers ORM
        $this->load->helper(array("dao" , "empresaMapper"));
        
        #Regras de validacao do formulario
        $this->form_validation->set_rules('id', 'id', 'trim|required|is_natural');
        $this->input->post('cnpj') ? $this->form_validation->set_rules('cnpj', 'Cnpj', 'trim|required|parseToDigits|isCnpj|is_unique[empresa.cnpj]|max_length[20]') : '';
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        
        #JSON erro/sucesso javascript
        $json = array();
        
        try{
            #Verifica dados do form
            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors());
            }
            
            #Pega dados do form
            $id = $this->input->post("id");
            $cnpj = $this->input->post("cnpj");
                 
            #Adiciona dados a Empresa
            $empresa = new Empresa();
            $cnpj ? $empresa->setCnpj($cnpj) : '';
           
            #Persite dados no banco
            $empresaMapper = new EmpresaMapper($empresa);
            $criteria = new TCriteria();
            $criteria->add(new TFilter(EmpresaMapper::ID_EMP, '=', $id));

            $empresaMapper->update($criteria);
            
            $json["sucesso"] = true;
            
        } 
        catch (Exception $ex) {
            
            $json["sucesso"] = false;
            $json["erro"] = $ex->getMessage();
            
        }
        finally{
            
            #Define tipo do cabeçalho para JSON
            header('Content-Type: application/json');
            
            #Retorna objeto JSON
            echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        }
    }

    public function deletar()
    {
        #Carrega bibliotecas
        $this->load->library('form_validation');
        
        #Carrega helpers ORM
        $this->load->helper(array("dao" , "empresaMapper"));
        
        #Regras de validacao do formulario
        $this->form_validation->set_rules('id', 'id', 'trim|required|is_natural');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        
        #JSON erro/sucesso javascript
        $json = array();
        
        try{
            #Verifica dados do form
            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors());
            }
            
            #Pega dados do form
            $id = $this->input->post("id");
                 
            #Adiciona dados a Empresa
            $empresa = new Empresa();
            $empresa->setId((int) $id);
           
            #Deleta do banco
            $empresaMapper = new EmpresaMapper($empresa);
            $empresaMapper->delete();
            
            $json["sucesso"] = true;
            
        } 
        catch (Exception $ex) {
            
            $json["sucesso"] = false;
            $json["erro"] = $ex->getMessage();
            
        }
        finally{
            
            #Define tipo do cabeçalho para JSON
            header('Content-Type: application/json');
            
            #Retorna objeto JSON
            echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        }
    }

    public function ler($page = '1',$cnpj = '')
    {
        #Carrega helpers ORM
        $this->load->helper(array("dao" , "empresaMapper"));
        
        #JSON a ser retornado
        $json = array();
        
        #Dados de leitura
        $limit = 10;
        $offset = ($page - 1) * $limit; 
        
        try{
            #Ler dados do BD
            $empresaMapper = new EmpresaMapper();
            $criteria = new TCriteria();

            $criteria->add(new TFilter(EmpresaMapper::CNPJ_EMP, 'LIKE', "%{$cnpj}%"));
            
            $empresas = $empresaMapper->read($criteria);
            
            #Conta numero de paginas
            $json["paginas"] = (int) ( count($empresas) / $limit );
            
            #Define limit e offset
            $empresas = array_slice($empresas, $offset, $limit);
            
            #Parse dados para JSON
            $dados = array();
            
            foreach($empresas as $empresa) :
                
                $dados[] = array("id" => $empresa->getId(),
                                 "cnpj" => $empresa->getCnpj()
                            );
            
            endforeach;
            
            #Adiciona dados dos empresas ao json
            $json["empresas"] = $dados;
            $json["sucesso"] = true;
            
        } 
        catch (Exception $ex) {
            
            $json["sucesso"] = false;
            $json["erro"] = $ex->getMessage();
            
        }
        finally{
            
            #Define tipo do cabeçalho para JSON
            header('Content-Type: application/json');
            
            #Retorna objeto JSON
            echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        }
        
    }
}
