<?php

require_once '../classes/albumDAO.php';
require_once '../classes/categoriaDAO.php';
require_once '../classes/playlistDAO.php';
require_once '../classes/User.php';
require_once '../classes/userDAO.php';
require_once '../classes/Model/Conexao.php';

$user = verificaSessao();

$conexao2 = new Conexao();
$conexao2 = $conexao2->getPdo();

$user = new User($_SESSION['nickname'], $_SESSION['nickname'], $_SESSION['nickname'], '');

if (isset($_POST['tipoSelecionadoUser'])) {
    if ($_POST['tipoSelecionadoUser'] == 'Album') {
        echo json_encode(userAlbuns2($conexao2, $user));
    } elseif ($_POST['tipoSelecionadoUser'] == 'Playlist') {
        echo json_encode(userPlaylists($conexao2, $user));
    } elseif (($_POST['tipoSelecionadoUser'] == 'Categoria')) {
        echo json_encode(userCategoria($conexao2, $user));
    }
}
