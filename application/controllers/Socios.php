<?php

/*
 * Controle para manipular dados relacionados a Socio.
 */

class Socios extends MY_Controller  {

    public function __construct() {
        parent::__construct();
        
        #Carrega biblioteca Socio
        $this->load->model("socio");
    }
    
    public function index(){
        $this->load->view("socios");
    }

    public function adicionar()
    {
        #Carrega bibliotecas
        $this->load->library('form_validation');
        
        #Carrega helpers ORM
        $this->load->helper(array("dao" , "socioMapper"));
        
        #Regras de validacao do formulario
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|isName|max_length[250]');
        $this->form_validation->set_rules('cpf', 'Cpf', 'trim|required|parseToDigits|isCpf|is_unique[socio.cpf]|max_length[20]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|is_unique[socio.email]|valid_email|max_length[100]');
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        
        #JSON erro/sucesso javascript
        $json = array();
        
        try{
            #Verifica dados do form
            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors());
            }
            
            #Pega dados do form
            $nome = $this->input->post("nome");
            $cpf = $this->input->post("cpf");
            $email = $this->input->post("email");
                 
            #Adiciona dados a Socio
            $socio = new Socio();
            $socio->setNome($nome);
            $socio->setCpf($cpf);
            $socio->setEmail($email);
           
            #Persite dados no banco
            $socioMapper = new SocioMapper($socio);
            $id = $socioMapper->insert();
            
            $json["sucesso"] = true;
            $json["id"] = $id;
            
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
        $this->load->helper(array("dao" , "socioMapper"));
        
        #Regras de validacao do formulario
        $this->form_validation->set_rules('id', 'id', 'trim|required|is_natural');
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|isName|max_length[250]');
        
        $this->input->post('cpf') ? $this->form_validation->set_rules('cpf', 'Cpf', 'trim|required|parseToDigits|isCpf|is_unique[socio.cpf]|max_length[20]') : '';
        $this->input->post('email') ? $this->form_validation->set_rules('email', 'E-mail', 'trim|required|is_unique[socio.email]|valid_email|max_length[100]'):'';
        
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
            $nome = $this->input->post("nome");
            $cpf = $this->input->post("cpf");
            $email = $this->input->post("email");
                 
            #Adiciona dados a Socio
            $socio = new Socio();
            $socio->setNome($nome);
            $cpf ? $socio->setCpf($cpf) : '';
            $email ? $socio->setEmail($email) : '';
           
            #Persite dados no banco
            $socioMapper = new SocioMapper($socio);
            $criteria = new TCriteria();
            $criteria->add(new TFilter(SocioMapper::ID_SOC, '=', $id));

            $socioMapper->update($criteria);
            
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
        $this->load->helper(array("dao" , "socioMapper"));
        
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
                 
            #Adiciona dados a Socio
            $socio = new Socio();
            $socio->setId((int) $id);
           
            #Deleta do banco
            $socioMapper = new SocioMapper($socio);
            $socioMapper->delete();
            
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

    public function ler($page = '1',$cpf = '')
    {
        #Carrega helpers ORM
        $this->load->helper(array("dao" , "socioMapper"));
        
        #JSON a ser retornado
        $json = array();
        
        #Dados de leitura
        $limit = 10;
        $offset = ($page - 1) * $limit; 
        
        try{
            #Ler dados do BD
            $socioMapper = new SocioMapper();
            $criteria = new TCriteria();

            $criteria->add(new TFilter(SocioMapper::CPF_SOC, 'LIKE', "%{$cpf}%"));
            
            $socios = $socioMapper->read($criteria);
            
            #Conta numero de paginas
            $json["paginas"] = (int) ( count($socios) / $limit );
            
            #Define limit e offset
            $socios = array_slice($socios, $offset, $limit);
            
            #Parse dados para JSON
            $dados = array();
            
            foreach($socios as $socio) :
                
                $dados[] = array("nome" => $socio->getNome(),
                                 "id" => $socio->getId(),
                                 "cpf" => $socio->getCpf(),
                                 "email" => $socio->getEmail()
                            );
            
            endforeach;
            
            #Adiciona dados dos socios ao json
            $json["socios"] = $dados;
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
