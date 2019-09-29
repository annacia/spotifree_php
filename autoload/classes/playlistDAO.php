<?php

//require_once("conecta.php");
require_once 'User.php';
require_once 'Playlist.php';
require_once 'Music.php';
// require_once("../autoload.php");

//Mostra as playlists do user
function userPlaylists($conexao2, User $user)
{
    $stmt = $conexao2->prepare(
        'SELECT p.pkPlaylist, p.namePlaylist FROM playlist p 
        INNER JOIN user u ON p.fkUser = u.pkUser 
        WHERE u.nickname = :nickname'
    );

    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll();
}

//Cria playlist se ela nao existe
function userNewPlaylists($conexao2, User $user, Playlist $playlist)
{
    $stmt = $conexao2->prepare(
        'INSERT INTO playlist (created, namePlaylist, fkUser) 
        SELECT * FROM (SELECT Now(), :nome, 
        (SELECT u.pkUser FROM user u WHERE u.nickname = :nickname)) as p 
        WHERE NOT EXISTS 
        (SELECT p.namePlaylist FROM playlist p 
        INNER JOIN user u ON p.fkUser = u.pkUser 
        WHERE p.namePlaylist = :nome AND u.nickname = :nickname)'
    );

    $stmt->bindValue(':nome', $playlist->getNome());
    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Modifica o nome de uma playlist
function userModifyPlaylist($conexao2, User $user, Playlist $playlist, $playlistOld)
{
    $stmt = $conexao2->prepare(
        'UPDATE playlist p 
        INNER JOIN user u ON p.fkUser = u.pkUser 
        SET p.modified = NOW(), p.namePlaylist=:nome 
        WHERE u.nickname=:nickname AND p.namePlaylist=:oldnome'
    );

    $stmt->bindValue(':nome', $playlist->getNome());
    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->bindValue(':oldnome', $playlistOld);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Deleta uma playlist
function userDeletePlaylist($conexao2, $idPlaylist)
{
    $stmt = $conexao2->prepare(
        'DELETE FROM playlist WHERE pkPlaylist = :id'
    );

    $stmt->bindValue(':id', $idPlaylist);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Relaciona uma musica com uma playlist
function userMusicPlaylistRelationship($conexao2, User $user, Music $music, Playlist $playlist)
{
    $stmt = $conexao2->prepare(
        'INSERT INTO musicplaylist (created, fkMusic, fkPlaylist) 
        SELECT * FROM (SELECT NOW(), 
        (SELECT m.pkMusic FROM music m WHERE m.nameMusic = :musicName), 
        (SELECT p.pkPlaylist FROM playlist p 
        INNER JOIN user u ON p.fkUser=u.pkUser 
        WHERE p.name = :playlistName AND u.nickname = :nickname)) as mp 
        WHERE NOT EXISTS 
        (SELECT mp.fkMusic, mp.fkPlaylist FROM musicplaylist mp 
        INNER JOIN playlist p ON mp.fkPlaylist = p.pkPlaylist 
        INNER JOIN music m ON mp.fkMusic = m.pkMusic 
        WHERE p.namePlaylist=:playlistName AND m.nameMusic=:musicName)'
    );

    $stmt->bindValue(':musicName', $music->getNome());
    $stmt->bindValue(':playlistName', $playlist->getNome());
    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Relaciona uma musica com uma playlist pelo ID
function userMusicPlaylistRelationshipID($conexao2, User $user, $pkMusic, $pkPlaylist)
{
    $stmt = $conexao2->prepare(
        'INSERT INTO musicplaylist (created, fkMusic, fkPlaylist)
        SELECT * FROM (SELECT NOW(),
        (SELECT m.pkMusic FROM music m WHERE m.pkMusic = :pkMusic),
        (SELECT p.pkPlaylist FROM playlist p WHERE p.pkPlaylist = :pkPlaylist)) as selecao
        WHERE NOT EXISTS
        (SELECT mp.fkMusic, mp.fkPlaylist FROM musicplaylist mp
        INNER JOIN playlist p ON mp.fkPlaylist = p.pkPlaylist
        INNER JOIN music m ON mp.fkMusic = m.pkMusic
        WHERE p.pkPlaylist = :pkPlaylist AND m.pkMusic = :pkMusic);'
    );

    $stmt->bindValue(':pkMusic', $pkMusic);
    $stmt->bindValue(':pkPlaylist', $pkPlaylist);
    $stmt->bindValue(':nickname', $user->getNickname());
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Exclui uma musica da playlist
function userDeleteMusicFromPlaylist($conexao2, $idPlaylist, $idMusic)
{
    $stmt = $conexao2->prepare(
        'DELETE FROM musicplaylist WHERE fkMusic = :idMusic AND fkPlaylist = :idPlaylist'
    );

    $stmt->bindValue(':idPlaylist', $idPlaylist);
    $stmt->bindValue(':idMusic', $idMusic);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
