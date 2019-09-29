<?php 

// namespace autoload\classes\Model;

class User{
    private $nome;
    private $nickname;
    private $email;
    private $senha;
    private $diretorio;

    public function __construct(string $nome='', string $nickname, string $email='', string $senha=''){
        $this->setNome($nome);
        $this->setNickname($nickname);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setDiretorio('../../data_uploads/' . $this->getNickname());
    }

    public function setDiretorio(string $diretorio){
        $this->diretorio = $diretorio;
    }

    public function setNome(string $nome){
        $this->nome = $nome;
    }

    public function setNickname(string $nickname){
        $this->nickname = $nickname;
    }

    public function setEmail(string $email){
        $this->email = $email;
    }

    public function setSenha(string $senha){
        $salt = $this->getNickname();
        $this->senha = md5($salt . $senha);
    }

    public function getDiretorio() : string{
        return $this->diretorio;
    }

    public function getNome() : string{
        return $this->nome;
    }

    public function getNickname() : string{
        return $this->nickname;
    }

    public function getEmail() : string{
        return $this->email;
    }

    public function getSenha() : string{
        return $this->senha;
    }
}