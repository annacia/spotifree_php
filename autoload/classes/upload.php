<?php

//require_once("conecta.php");
require_once 'User.php';
require_once 'userDAO.php';
require_once 'Categoria.php';
require_once 'Album.php';
require_once 'Music.php';
require_once 'albumDAO.php';
require_once 'musicaDAO.php';
$user = verificaSessao();

$dataUploads = '../../data_uploads';

$dataUserName = $user->getNickname();

$dataMusicaNome = $_POST['nome-upload'];
$dataMusicaAlbum = $_POST['album-upload'];
$dataArtMusica = $_FILES['musica-art'];
$dataCategoria = $_POST['categoria-upload'];
$dataFileMusica = $_FILES['musica-file'];

$dirUser = $dataUploads;

//Verificação e Criação de Pastas

//Pasta Principal
if (file_exists($dirUser)) {
    //Pasta do Usuario
    $dirUser .= '/'.$dataUserName;
    if (file_exists($dirUser)) {
        //Pasta do Album
        $dirUser .= '/'.$dataMusicaAlbum;
        if (!file_exists($dirUser)) {
            if (!mkdir($dirUser)) {
                die('Nao funfou');
            }
        }
    } else {
        //Pasta do Usuario
        if (!mkdir($dirUser)) {
            die('Nao funfou');
        }

        //Pasta do Album
        $dirUser .= '/'.$dataMusicaAlbum;
        if (!file_exists($dirUser)) {
            if (!mkdir($dirUser)) {
                die('Nao funfou');
            }
        }
    }
} else {
    die('Nao funfou');
}

$extensaoArt = explode('.', $dataArtMusica['name']);
$extensaoArt = end($extensaoArt);

$extensaoMusica = explode('.', $dataFileMusica['name']);
$extensaoMusica = end($extensaoMusica);

$dirGeneric = $dataMusicaNome.'_'.$dataMusicaAlbum.'_'.$dataUserName;
$dirNameFile = $dirUser.'/'.'audio_'.$dirGeneric;
$final_dirMusic = $dirNameFile.'.'.$extensaoMusica;

$dirNameFile = $dirUser.'/'.$dirGeneric;
$final_dirArt = $dirNameFile.'.'.$extensaoArt;

if (move_uploaded_file($dataArtMusica['tmp_name'], $final_dirArt)) {
    echo 'Arquivo Imagem Enviado';
    if (move_uploaded_file($dataFileMusica['tmp_name'], $final_dirMusic)) {
        $dirUser = 'data_uploads\\'.$dataUserName;

        $dirNameFile = $dirUser.'\\'.$dataMusicaAlbum.'\\'.'audio_'.$dirGeneric;
        $final_dirMusic = $dirNameFile.'.'.$extensaoMusica;

        $dirNameFile = $dirUser.'\\'.$dataMusicaAlbum.'\\'.$dirGeneric;
        $final_dirArt = $dirNameFile.'.'.$extensaoArt;

        $musica = new Music($dataMusicaNome,
                            $dataMusicaAlbum,
                            $final_dirArt,
                            $dataCategoria,
                            $final_dirMusic);
        $album = new Album($dataMusicaAlbum);
        $categoria = new categoria($dataCategoria);

        newAlbum($conexao2, $album);

        userNewMusic($conexao2, $user, $musica, $categoria, $album);

        header('Location: ../../feed.php?upload=1');

        return true;
    } else {
        header('Location: ../../formulario-musica.php?upload=0');

        return false;
    }
} else {
    header('Location: ../../feed.php?upload=0');

    return false;
}
