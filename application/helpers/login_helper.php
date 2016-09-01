<?php

abstract class LoginHelper {
    
    private static $domain = '.socio.com';
    private static $path = '/';
    private static $prefix = 'socio_';
    private static $expire = 86500*30;
    private static $secure = FALSE;

     /**
     * Faz o login
     * @param string $username
     * @param string $password
     * @throws Exception
     * @return boolean true, se logar com sucesso, false, caso contrário.
     */
    
    static function login($username, $password) {
           $CI = & get_instance();
           
           //if(LoginHelper::throttleFailedLogins($username) > 0){
           //    throw new Exception("Você excedeu o número máximo de tentativas! Tente novamente em 10 minutos.");
           //}
           
           $ableToLog = LoginHelper::verificaLogin($username, $password);
           
            if ($ableToLog) {
                #Salvar dados na session
                //Regenera session periodicamente em pontos chaves
                $CI->session->sess_regenerate();
                
                $CI->session->set_userdata('username',$username);
                $CI->session->set_userdata('userpassword',$password);
                
                //LoginHelper::clearFailedLogins($username);
                return true;
            } else {
                //LoginHelper::recordFailedLogin($username);
                return false;
            }
    
    }
    
    /**
     * Desloga e redireciona para $redirect
     * @param mixed $redirect Se === <b>FALSE</b>, nao redireciona
     */
    public static function logout($redirect = '') {
        #Carrega libraries
        $CI = & get_instance();
        $CI->load->helper('url');
        
        #Destroi sessao
        $CI->session->sess_destroy();
        
        if (!empty($redirect)) {
            redirect($redirect);
        }
        
    }

    /**
     * Verifica a combinacao de usuario x senha
     * @param string $username username
     * @param string $password senha
     * @return Usuario|FALSE
     */
    public static function verificaLogin($username, $password) {
        
        $validUser = $username == "admin";
        $validPass = strcmp("admin", $password) === 0;
            
        return $validUser && $validPass;
        
    }
    
    /**
     * Requer login e faz a autenticidade do usuario.
     * @return mixed Retorna true em caso de usuario logado e autenticado.
     *               Caso contrário, faz o logout e retorna falso.     
     */   
    public static function requireLogin(){
        
        $CI = & get_instance();

        if(LoginHelper::isLogged()){
            
            #Verifica autenticidade
            $auth = LoginHelper::verificaLogin($CI->session->username, $CI->session->password);

            if($auth)
                return true;
            
            #Deleta sessoes invalidos por nao passarem no teste de autenticidade
            LoginHelper::logout(); 
        }
        
        return false;
    }    
    
    /**
     * Verifica se usuario estah logado.
     * @return bool true ou false
     */    
    public static function isLogged(){
        
        $CI = & get_instance();
        
        #Verifica se sessao existe, se nao existir, verifica se estah armazenada em cookies
        return $CI->session->has_userdata("username"); //existe sessao
        
    }    
    
}
