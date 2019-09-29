<?php

// require_once("conecta.php");
// require_once("User.php");
// require_once("Album.php");

//Todos os albuns existentes
function worldAlbuns($conexao2){

    $stmt = $conexao2->prepare(
       'SELECT nameAlbum, pkAlbum FROM album'
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Albuns do user
function userAlbuns($conexao2, User $user){

    $stmt = $conexao2->prepare(
       'SELECT DISTINCT a.pkAlbum, a.nameAlbum FROM album a 
       INNER JOIN music m ON a.pkAlbum = m.fkAlbum 
       INNER JOIN user u ON m.fkUser = u.pkUser 
       WHERE u.nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function userAlbuns2($conexao2, User $user){

    $stmt = $conexao2->prepare(
       'SELECT DISTINCT a.pkAlbum, a.nameAlbum FROM album a 
       INNER JOIN music m ON a.pkAlbum = m.fkAlbum 
       INNER JOIN user u ON m.fkUser = u.pkUser 
       WHERE u.nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll();
}

//Adiciona novo Album (logo apos essa funcao, deve chamar a funcao de criar musica
//Usar tbm qdo for modificar musica
function newAlbum($conexao2, Album $album){
    $stmt = $conexao2->prepare(
        'INSERT INTO album (created, nameAlbum) 
        SELECT * FROM 
        (SELECT Now(), :nome) as a 
        WHERE NOT EXISTS 
        ( SELECT nameAlbum FROM album WHERE nameAlbum = :nome)'
     );
 
    $stmt->bindValue(':nome', $album->getNome());
    
    if (!$stmt) {
        echo "\nPDO::errorInfo():\n";
        print_r($pdo->errorInfo());
    } else {
        echo 'funfou';
    }

    $stmt->execute();
 
    return $stmt->fetchAll();
}



