<?php

// namespace autoload\classes\Controller;

class userController{

    private $userDAO;

    public function __construct(){
        $this->userDAO = new userDAO();
    }

    public function userNew(Conexao $conexao, User $user){
        if(($user->getNome()!=='') && 
        ($user->getNickname()!=='') && 
        ($user->getEmail()!=='') && 
        ($user->getSenha()!=='')){
            return $this->userDAO->userNew($conexao, $user);
        } else {
            return false;
        }
    }

    public function userModifyEmail(Conexao $conexao, User $user, $newEmail){
        if(($user->getSenha()!=='') && 
        ($user->getNickname() !== '')&&
        ($newEmail !== '')){
            return $this->userDAO->userModifyEmail($conexao, $user, $newEmail);
        } else {
            return false;
        }
    }

    public function userModifyPassword(Conexao $conexao, User $user, User $userNew){
        $newPass = $userNew->getSenha();
        if($newPass !==''){
            return $this->userDAO->userModifyPassword($conexao, $user, $newPass);
        } else{
            return false;
        }
    }
    
    public function buscaUsuario(Conexao $conexao, User $user){
        if(($user->getNickname()!=='')&&
        ($user->getSenha()!=='')){
            return $this->userDAO->buscaUsuario($conexao, $user);
        } else {
            return false;
        }
    }
    
    public function logicaUsuario(Conexao $conexao, User $user){
        if(($user->getNickname()!=='')&&
        ($user->getSenha()!=='')){
            return $this->userDAO->logicaUsuario($conexao, $user);
        } else {
            return false;
        }    
    }
    
    public function verificaSessao(){
        return $this->userDAO->verificaSessao();
    }
    

    public function userDelete(Conexao $conexao, User $user){
        if($user->getNickname() !== ''){
            $this->removeDiretorioUser($user);
            $this->userDAO->userDelete($conexao, $user);
            session_destroy();
            clearstatcache(); 
            header("Location: ../../index.php?UserDelete=true");
        } else {
            return false;
        }
    }
    
    
    
}