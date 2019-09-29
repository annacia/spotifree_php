<?php

//require_once("conecta.php");
require_once 'User.php';
// require_once("../autoload.php");
//Novo User
function userNew($conexao2, User $user)
{
    $stmt = $conexao2->prepare(
        'INSERT user(created, nameUser, nickname, email, password) 
        VALUES (NOW(), :nome, :nickname, :email, :password)'
    );

    if (($user->getNome() !== '') && ($user->getNickname() !== '') && ($user->getEmail() !== '') && ($user->getSenha() !== '')) {
        $stmt->bindValue(':nome', $user->getNome());
        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getSenha());
        $stmt->execute();

        return $stmt;
    } else {
        return false;
    }
}

//Mudando o email
function userModifyEmail($conexao2, User $user, $newEmail)
{
    $stmt = $conexao2->prepare(
        'UPDATE user SET 
        modified = NOW(), email = :novoEmail 
        WHERE nickname=:nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':novoEmail', $newEmail);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//mudando a senha
function userModifyPassword($conexao2, User $user, $newPassword)
{
    $stmt = $conexao2->prepare(
        'UPDATE user SET 
        modified = NOW(), password = :novoPassword 
        WHERE nickname=:nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':novoPassword', $newPassword);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Deletando o user
function userDelete($conexao2, User $user)
{
    $stmt = $conexao2->prepare(
        'DELETE FROM user WHERE nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//busca usuario
function buscaUsuario($conexao2, User $user)
{
    $stmt = $conexao2->prepare(
        'SELECT nameUser, nickname, email
        FROM user 
        WHERE nickname = :nickname and password = :password'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':password', $user->getSenha());

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function logicaUsuario($conexao2, User $user)
{
    $userResult = buscaUsuario($conexao2, $user);
    session_start();
    if ($userResult == true) {
        $_SESSION['nameUser'] = $userResult[0]['nameUser'];
        $_SESSION['nickname'] = $userResult[0]['nickname'];
        $_SESSION['email'] = $userResult[0]['email'];
        header('Location: ../../feed.php');

        return true;
    } else {
        header('Location: ../../index.php?login=0');

        return false;
    }
}

function verificaSessao()
{
    session_start();

    if (!isset($_SESSION['nickname'])) {
        header('Location: index.php');
        exit;
    } else {
        $user = new User($_SESSION['nameUser'], $_SESSION['nickname'], $_SESSION['email'], '');

        return $user;
    }
}

if (isset($_POST['sessao'])) {
    $userAtual = verificaSessao();
    echo $userAtual->getNickname();
}

if ((isset($_POST['password-old'])) && (isset($_POST['password-new']))) {
    verificaSessao();
    $user = new User('', $_SESSION['nickname'], '', $_POST['password-old']);
    $userNewPass = new User('', $_SESSION['nickname'], '', $_POST['password-new']);
    if (buscaUsuario($conexao2, $user)) {
        userModifyPassword($conexao2, $user, $userNewPass->getSenha());
        header('Location: ../../feed.php?SenhaTrocada=true');
    } else {
        header('Location: ../../feed.php?SenhaTrocada=false');
    }
}

if ((isset($_POST['deleteUser']))) {
    clearstatcache();
    verificaSessao();
    $user = new User('', $_SESSION['nickname'], '', '');

    $dirUpload = '../../data_uploads/'.$user->getNickname();
    $dir = $dirUpload;
    function removeDiretorioUser($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($dir.'/'.$object)) {
                        removeDiretorioUser($dir.'/'.$object);
                    } else {
                        unlink($dir.'/'.$object);
                    }
                }
            }
            rmdir($dir);
        }
    }
    removeDiretorioUser($dir);
    userDelete($conexao2, $user);
    session_destroy();
    clearstatcache();
    header('Location: ../../index.php?UserDelete=true');
}
