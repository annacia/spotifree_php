<?php

// namespace autoload\classes\Controller;

class albumController{

    private $albumDAO;

    public function __construct(){
        $this->albumDAO = new albumDAO();
    }

    public function worldAlbuns(Conexao $conexao){
        return $this->albumDAO->worldAlbuns($conexao);
    }

    public function userAlbuns(Conexao $conexao, User $user){
        if($user->getNickname()!==''){
            return $this->albumDAO->userAlbuns($conexao, $user);
        }
    }

    public function userAlbuns2(Conexao $conexao, User $user){
        if($user->getNickname()!==''){
            return $this->albumDAO->userAlbuns($conexao, $user);
        }
    }

    public function newAlbum(Conexao $conexao, Album $album){
        if($album->getNome()!==''){
            return $this->albumDAO->newAlbum($conexao, $album);
        }
    }
}