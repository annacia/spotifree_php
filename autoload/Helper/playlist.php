<?php

require_once '../classes/User.php';
require_once '../classes/Categoria.php';
require_once '../classes/Album.php';
require_once '../classes/Music.php';
require_once '../classes/Playlist.php';
require_once '../classes/playlistDAO.php';
// require_once("../autoload.php");
require_once '../classes/userDAO.php';
require_once '../classes/Model/Conexao.php';
$user = verificaSessao();

$conexao2 = new Conexao();
$conexao2 = $conexao2->getPdo();
//AddOnPlaylist
if ((isset($_POST['playlistSelecionadaAdd'])) && (isset($_POST['musicaSelecionadaAdd']))) {
    userMusicPlaylistRelationshipID($conexao2, $user, $_POST['musicaSelecionadaAdd'], $_POST['playlistSelecionadaAdd']);
}

//Playlists por pasta
function playlistTracks(string $user, string $album)
{
    $dirUpload = '../../';

    $caminho = 'data_uploads/'.$user.'/'.$album;
    $diretorio = dir($dirUpload.$caminho);

    while ($arquivo = $diretorio->read()) {
        $extensao = explode('/', $arquivo);
        $extensao = end($extensao);
        $extensao = explode('_', $extensao);

        if ($extensao[0] == 'audio') {
            $playlist[] = $caminho.'/'.$arquivo;
        }
    }

    $diretorio->close();
    $playlist = implode('|', $playlist);
    echo $playlist;
}

if ((isset($_POST['userName'])) && (isset($_POST['albumName']))) {
    return playlistTracks($_POST['userName'], $_POST['albumName']);
}

//playlist pelo banco
require_once '../classes/musicaDAO.php';

if ((isset($_POST['tipoFeed'])) && (isset($_POST['categoriaFeed']))) {
    $category = new Categoria($_POST['categoriaFeed']);

    if ($_POST['tipoFeed'] == 'Meu Feed') {
        if ($_POST['categoriaFeed'] != 'Categorias') {
            $rows = userMusicsByCategory($conexao2, $user, $category);
            echo json_encode($rows);
        } else {
            $rows = userMusics($conexao2, $user);
            echo json_encode($rows);
        }
    } elseif ($_POST['tipoFeed'] == 'World Feed') {
        if ($_POST['categoriaFeed'] != 'Categorias') {
            $rows = worldMusicsByCategory($conexao2, $category);
            echo json_encode($rows);
        } else {
            $rows = worldMusics($conexao2);
            echo json_encode($rows);
        }
    } else {
        echo json_encode('Tipo de Feed ou categoria nao encontrado');
    }
}

if ((isset($_POST['tipoSelecaoUser'])) && (isset($_POST['nomeSelecaoUser']))) {
    if ($_POST['tipoSelecaoUser'] == 'Album') {
        $album = new Album($_POST['nomeSelecaoUser']);
        echo json_encode(userMusicsByAlbum($conexao2, $user, $album));
    } elseif ($_POST['tipoSelecaoUser'] == 'Playlist') {
        $playlist = new Playlist($_POST['nomeSelecaoUser']);
        echo json_encode(userMusicsByPlaylist($conexao2, $user, $playlist));
    } elseif (($_POST['tipoSelecaoUser'] == 'Categoria')) {
        $categoria = new Categoria($_POST['nomeSelecaoUser']);
        echo json_encode(userMusicsByCategory($conexao2, $user, $categoria));
    } else {
        echo json_encode('Não há nenhuma musica');
    }
}

if (isset($_POST['nameAlbum'])) {
    $album = new Album($_POST['nameAlbum']);
    echo json_encode(userMusicsByAlbum($conexao2, $user, $album));
}

if (isset($_POST['namePlaylist'])) {
    $playlist = new Playlist($_POST['namePlaylist']);
    echo json_encode(userMusicsByPlaylist($conexao2, $user, $playlist));
}

if (isset($_POST['nomeNovaPlaylist'])) {
    $playlist = new Playlist($_POST['nomeNovaPlaylist']);
    userNewPlaylists($conexao2, $user, $playlist);
}
