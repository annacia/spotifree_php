<?php

//require_once("conecta.php");
require_once 'User.php';
// require_once("autoload/autoload.php");

function worldCategoria($conexao2)
{
    $stmt = $conexao2->prepare(
        'SELECT pkcategory, nameCategory FROM category'
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function userCategoria($conexao2, User $user)
{
    $stmt = $conexao2->prepare(
        'SELECT DISTINCT c.pkcategory, c.nameCategory  FROM category c 
        INNER JOIN music m ON c.pkcategory = m.fkcategory 
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE u.nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll();
}
