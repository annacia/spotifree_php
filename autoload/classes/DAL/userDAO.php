<?php

// namespace autoload\classes\DAL;

class userDAO
{
    public function userNew(Conexao $conexao, User $user)
    {
        $stmt = $conexao->getPdo()->prepare(
            'INSERT user(created, nameUser, nickname, email, password) 
            VALUES (NOW(), :nome, :nickname, :email, :password)'
        );

        $stmt->bindValue(':nome', $user->getNome());
        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getSenha());
        $stmt->execute();

        return $stmt;
    }

    //Mudando o email
    public function userModifyEmail(Conexao $conexao, User $user, $newEmail)
    {
        $stmt = $conexao->getPdo()->prepare(
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
    public function userModifyPassword(Conexao $conexao, User $user, $newPassword)
    {
        $stmt = $conexao->getPdo()->prepare(
            'UPDATE user SET 
            modified = NOW(), password = :novoPassword 
            WHERE nickname=:nickname'
        );

        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->bindValue(':novoPassword', $newPassword);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Deleta o diretorio do User
    public function removeDiretorioUser(User $user)
    {
        if (is_dir($user->diretorio)) {
            $objects = scandir($user->diretorio);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($user->diretorio.'/'.$object)) {
                        removeDiretorioUser($user->diretorio.'/'.$object);
                    } else {
                        unlink($user->diretorio.'/'.$object);
                    }
                }
            }
            rmdir($user->diretorio);
        }
    }

    //Deletando o user
    public function userDelete(Conexao $conexao, User $user)
    {
        $stmt = $conexao->getPdo()->prepare(
            'DELETE FROM user WHERE nickname = :nickname'
        );

        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //busca usuario
    public function buscaUsuario(Conexao $conexao, User $user)
    {
        $stmt = $conexao->getPdo()->prepare(
            'SELECT nameUser, nickname, email
            FROM user 
            WHERE nickname = :nickname and password = :password'
        );

        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->bindValue(':password', $user->getSenha());

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function logicaUsuario(Conexao $conexao, User $user)
    {
        $userResult = $this->buscaUsuario($conexao, $user);
        session_start();
        if ($userResult == true) {
            $_SESSION['nameUser'] = $userResult[0]['nameUser'];
            $_SESSION['nickname'] = $userResult[0]['nickname'];
            $_SESSION['email'] = $userResult[0]['email'];
            header('Location: ../../../feed.php');

            return true;
        } else {
            header('Location: ../../../index.php?login=0');

            return false;
        }
    }

    public function verificaSessao()
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
}
