<?php

//require_once("conecta.php");
require_once 'Categoria.php';
require_once 'Album.php';
require_once 'User.php';
require_once 'Playlist.php';
require_once 'Music.php';
// require_once("autoload/autoload.php");
require_once 'userDAO.php';

//Funções World:
//Todas as musicas
function worldMusics($conexao2)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music,
        a.nameAlbum, u.nickname FROM music m
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum
        INNER JOIN user u ON m.fkUser = u.pkUser 
        ORDER BY m.pkMusic DESC'
    );

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Musicas por categoria
function worldMusicsByCategory($conexao2, Categoria $category)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music,
        a.nameAlbum, u.nickname FROM music m
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum
        INNER JOIN user u ON m.fkUser = u.pkUser 
        INNER JOIN category c ON m.fkCategory = c.pkCategory 
        WHERE c.nameCategory = :name'
    );

    $stmt->bindValue(':name', $category->getNome());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Musicas por album
function worldMusicsByAlbum($conexao2, Album $album)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music,
        a.nameAlbum, u.nickname FROM music m
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE a.nameAlbum = :name'
    );

    $stmt->bindValue(':name', $album->getNome());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Funções do User
//Todas as musicas
function userMusics($conexao2, User $user)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music, 
        a.nameAlbum, u.nickname FROM music m
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE u.nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Musicas por categoria
function userMusicsByCategory($conexao2, User $user, Categoria $category)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music, 
        a.nameAlbum, u.nickname FROM music m 
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum
        INNER JOIN category c ON m.fkCategory = c.pkCategory 
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE c.nameCategory = :nome 
        AND u.nickname=:nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':nome', $category->getNome());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Musicas por Album
function userMusicsByAlbum($conexao2, User $user, Album $album)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music, 
        a.nameAlbum, u.nickname FROM music m
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum 
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE a.nameAlbum = :nameAlbum AND u.nickname=:nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':nameAlbum', $album->getNome());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Musicas por Playlist
function userMusicsByPlaylist($conexao2, User $user, Playlist $playlist)
{
    $stmt = $conexao2->prepare(
        'SELECT m.pkMusic, m.nameMusic, m.dir_art, m.dir_music, 
        a.nameAlbum, u.nickname FROM music m
        INNER JOIN musicplaylist mp ON m.pkMusic = mp.fkMusic 
        INNER JOIN playlist p ON mp.fkPlaylist = p.pkPlaylist 
        INNER JOIN user u ON p.fkUser = u.pkUser 
        INNER JOIN album a ON m.fkAlbum = a.pkAlbum
        WHERE p.namePlaylist=:namePlaylist AND u.nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':namePlaylist', $playlist->getNome());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Insere Nova Música
function userNewMusic($conexao2, User $user, Music $music, Categoria $category, Album $album)
{
    $stmt = $conexao2->prepare(
        'INSERT INTO music
        (created, nameMusic, dir_art, dir_music, fkCategory, fkUser, fkAlbum) 
        VALUES (NOW(), :nameMusic, :dirArt, :dirMusic, 
        (SELECT pkCategory FROM category WHERE nameCategory=:nomeCategoria), 
        (SELECT pkUser FROM user WHERE nickname=:nickname), 
        (SELECT pkAlbum FROM album WHERE nameAlbum=:nomeAlbum))'
    );

    //Obj Music
    $stmt->bindValue(':nameMusic', $music->getNome());
    $stmt->bindValue(':dirArt', $music->getDir_art());
    $stmt->bindValue(':dirMusic', $music->getDir_music());

    //Obj Categoria
    $stmt->bindValue(':nomeCategoria', $category->getNome());

    //Obj User
    $stmt->bindValue(':nickname', $user->getNickname());

    //Obj Album
    $stmt->bindValue(':nomeAlbum', $album->getNome());

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//colocar essa funçao apos a inserção de album novo se nao existe

//Modifica a musica atraves dos ids (Atencao nisso)
function userModifyMusic($conexao2, $idMusic, $idCategory)
{
    $stmt = $conexao2->prepare(
        'UPDATE music 
        SET modified = now(), fkCategory = :idCategory  
        WHERE pkMusic=:idMusic'
    );

    $stmt->bindValue(':idMusic', $idMusic);
    $stmt->bindValue(':idCategory', $idCategory);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Deleta a musica atraves do id(!!!!)
function userDeleteMusic($conexao2, $idMusic, User $user)
{
    $stmt = $conexao2->prepare(
        'DELETE m.* FROM music m
        INNER JOIN user u ON m.fkUser = u.pkUser
        WHERE m.pkMusic=:idMusic and u.nickname=:nickname
        '
    );

    $stmt->bindValue(':idMusic', $idMusic);
    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMusicDir($conexao2, $idMusic)
{
    $stmt = $conexao2->prepare(
        'SELECT m.dir_music, m.dir_art
        FROM music m
        WHERE m.pkMusic = :idMusic'
    );

    $stmt->bindValue(':idMusic', $idMusic);
    $stmt->execute();

    $diretoryMusicSelected = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $diretoryMusicSelected = $diretoryMusicSelected[0];

    return $diretoryMusicSelected;
}

if (isset($_POST['idMusicDelete'])) {
    clearstatcache();
    $user = verificaSessao();
    $dirUpload = '../../';
    $dir = getMusicDir($conexao2, $_POST['idMusicDelete']);
    file_exists($dirUpload.$dir['dir_music']);
    file_exists($dirUpload.$dir['dir_art']);
    if ((file_exists($dirUpload.$dir['dir_music'])) && (file_exists($dirUpload.$dir['dir_art']))) {
        unlink($dirUpload.$dir['dir_music']);
        unlink($dirUpload.$dir['dir_art']);
        clearstatcache();
        userDeleteMusic($conexao2, $_POST['idMusicDelete'], $user);
    }
}
