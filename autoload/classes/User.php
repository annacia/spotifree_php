<?php 

class User{
    private $nome;
    private $nickname;
    private $email;
    private $senha;

    public function __construct(string $nome='', string $nickname, string $email='', string $senha=''){
        $this->setNome($nome);
        $this->setNickname($nickname);
        $this->setEmail($email);
        $this->setSenha($senha);
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