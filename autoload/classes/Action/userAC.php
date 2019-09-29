<?php

//namespace autoload\classes\Action;

//use autoload\classes\Controller\userController as userController;

// UserDAO

require_once '../../autoload.php';
$userController = new userController();

$conexao = new Conexao();
$pdo = $conexao->getPdo();

if (isset($_POST['sessao'])) {
    $userAtual = $userController->verificaSessao();
    echo $userAtual->getNickname();
}

if ((isset($_POST['password-old'])) && (isset($_POST['password-new']))) {
    $userAtual = $userController->verificaSessao();
    $userNewPass = $userController->verificaSessao();
    
    $userNewPass->setSenha($_POST['password-new']);
    $userAtual->setSenha($_POST['password-old']);
    
    if ($userController->buscaUsuario($conexao, $userAtual)) {
        $userController->userModifyPassword($conexao, $userAtual, $userNewPass);
        header('Refresh: 0; url = ../../../feed.php?SenhaTrocada=true');
        //header('Location: ../../../feed.php?SenhaTrocada=true');
    } else {
        header('Refresh: 0; url = ../../../feed.php?SenhaTrocada=false');
        //header('Location: ../../../feed.php?SenhaTrocada=false');
    }
}

if ((isset($_POST['deleteUser']))) {
    clearstatcache();
    $userController->verificaSessao();
    $user = $userController->verificaSessao();
    
    userDelete($conexao, $user);
}

// Login

if ((isset($_POST['nickname-login'])) &&
(isset($_POST['senha-login']))) {
    $user = new User('', $_POST['nickname-login'], '', $_POST['senha-login']);
    $userController->logicaUsuario($conexao, $user);
}

//Cadastro

if ((isset($_POST['nome-cadastro'])) &&
(isset($_POST['nickname-cadastro'])) &&
(isset($_POST['email-cadastro'])) &&
(isset($_POST['senha-cadastro']))) {
    $user = new User($_POST['nome-cadastro'], $_POST['nickname-cadastro'], $_POST['email-cadastro'], $_POST['senha-cadastro']);
    if ($userController->userNew($conexao, $user)) {
        $userController->logicaUsuario($conexao, $user);
    } else {
        header('Refresh: 0; url = ../../cadastro.php?cadastro=0');
        //header('Location: ../../cadastro.php?cadastro=0');
    }
}
