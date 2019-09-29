<?php 
require_once 'autoload/autoload.php';
require_once 'autoload/classes/userDAO.php';
$user = verificaSessao();
$conexao2 = new Conexao();
$conexao2 = $conexao2->getPdo();
require_once 'autoload/classes/categoriaDAO.php';
require_once 'autoload/classes/musicaDAO.php';
require_once 'autoload/classes/albumDAO.php';
require_once 'autoload/classes/playlistDAO.php';

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="css/jquery-filestyle.min.js">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Philosopher:400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <title>SpotiFree</title>
</head>
<body>
    <header class="header-principal">
        <div class="container">
            <nav class="principal-menu row">
                <a href="#" alt="menu principal" class="principal-menu-item principal col-sm-4"><i class="fas fa-bars" alt="Menu Principal"></i></a>
                <!-- <img src="" alt=""> -->
                <h1 class="principal-menu-item col-sm-4 align-middle">Spotifree</h1>
                <a href="#" alt="meu menu" class="principal-menu-item pessoal col-sm-4"><i class="fas fa-user" alt="Menu Pessoal"></i></a>
            </nav>
        </div>
    </header>
    
    <!-- incluir as divs dos menus -->
    <div class="menu-pessoal-wrap click-off">
        <header class="menu-pessoal">
            <span class="titulo"><i class="fas fa-user" alt="Menu Pessoal"></i> Menu Pessoal</span>
            <span class="btn-close"><i class="fas fa-times"></i></span>
        </header>
        <div class="menu-item-pack">
            <div class="menu-item">
                <a href="generic-playlist.php"><span class="titulo">Minhas Músicas</span></a>
                <span class="holder click-off">
                    <i class="fas fa-minus"></i>
                </span>
                <span class="holder">
                    <i class="fas fa-plus"></i>
                </span>
                <ul class="sub-menu click-off">
                    <?php 
                    $Umusicas = userMusics($conexao2, $user);
                    $i = 0;
                    foreach ($Umusicas as $Umusica) :
                    ?>
                        <li class="sub-menu-item">
                            <a href="#" class="music-click-user" data-index="<?= $i; ?>" data-value="<?=$Umusica['pkMusic']; ?>"><?=$Umusica['nameMusic']; ?> by <?=$Umusica['nickname']; ?> <i class="fas fa-play"></i></a>
                        </li>
                    <?php
                    ++$i;
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
        <div class="menu-item-pack">
            <div class="menu-item">
                <a href="generic-playlist.php"><span class="titulo">Meus Albuns</span></a>
                <span class="holder click-off">
                    <i class="fas fa-minus"></i>
                </span>
                <span class="holder">
                    <i class="fas fa-plus"></i>
                </span>
                <ul class="sub-menu click-off">
                    <?php 
                    $Ualbuns = userAlbuns($conexao2, $user);
                    foreach ($Ualbuns as $Ualbum) :
                    ?>
                       <li class="sub-menu-item">
                            <a href="#" class="album-click-user" data-index="<?=$Ualbum['pkAlbum']; ?>"><?=$Ualbum['nameAlbum']; ?> <i class="fas fa-play"></i></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="menu-item-pack">
            <div class="menu-item">
                <a href="generic-playlist.php"><span class="titulo">Minhas Playlists</span></a>
                <span class="holder click-off">
                    <i class="fas fa-minus"></i>
                </span>
                <span class="holder">
                    <i class="fas fa-plus"></i>
                </span>
                <ul class="sub-menu click-off">
                    <?php 
                    $Uplaylists = userPlaylists($conexao2, $user);
                    foreach ($Uplaylists as $Uplaylist) :
                    ?>
                        <li class="sub-menu-item">
                            <a href="#" class="playlist-click-user"><?=$Uplaylist['namePlaylist']; ?><i class="fas fa-play"></i></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="conta-detalhes">
            <a class="menu-item" href="minha-conta.php"><i class="fas fa-user-plus"></i> <span>Minha Conta</span></a>
            <a class="menu-item" href="formulario-musica.php"><span><i class="fas fa-upload"></i> Upload</span></a>
            <a class="menu-item" href="autoload/Helper/logout.php"><i class="fas fa-power-off"></i> <span>Sair</span></a>
        </div>
    </div>
    <div class="menu-principal-wrap click-off">
        <header class="menu-principal">
            <span class="titulo"><i class="fas fa-bars" alt="Menu Principal"></i> Menu Principal</span>
            <span class="btn-close"><i class="fas fa-times"></i></span>
        </header>
        <div class="buscar">
            <input type="search" id="Search" name="q" class="input-text">
            <button type="submit" class="search-menu">Buscar</button>
        </div>
        <div class="menu-principal-categorias menu-item-pack">
            <div class="menu-item">
                <a href="feed.php" data-value="Categorias"><i class="fas fa-headphones"></i><span> Meu Feed</span></a>
            </div>
            <div class="menu-item">
                <a href="#" data-value="Categorias"><span>Categorias</span></a>
                <span class="holder click-off">
                    <i class="fas fa-minus"></i>
                </span>
                <span class="holder">
                    <i class="fas fa-plus"></i>
                </span>
                <ul class="sub-menu click-off">
                    <?php 
                    $categorias = worldCategoria($conexao2);
                    foreach ($categorias as $categoria) :
                    ?>
                        <li class="sub-menu-item"><a href="#" data-value="<?= $categoria['pkcategory']; ?>"><?= $categoria['nameCategory']; ?></a></li>
                    <?php endforeach; ?>  
                </ul>
            </div>
        </div>
    </div>
    <div class="single-music click-off">
        <header>
            <div class="min-menu click-off">
                <p class="player-title">Music Player</p>
                <span class="max-music"><i class="fas fa-chevron-up"></i></span>
            </div>
            <div class="left-menu">
                <nav class="options-menu">
                    <span class="options">
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <span class="options click-off">
                        <i class="fas fa-minus"></i>
                    </span>
                    <div class="sub-menu click-off">
                        <a href="#">
                            <span class="menu-principal">
                                <i class="fas fa-bars" alt="Menu Principal"></i>
                            </span>
                        </a>
                        <a href="#">
                            <span class="menu-pessoal">
                                <i class="fas fa-user" alt="Menu Pessoal"></i>
                            </span>
                        </a>
                        <a href="generic-playlist.php">
                            <span class="list-musics">
                                <i class="fas fa-clipboard-list" alt="Lista de Reprodução"></i>
                            </span>
                        </a>
                        <a class="add-playlist" href="#">
                            <span>
                                <i class="fas fa-plus-circle" alt="Adicionar a uma playlist"></i>
                            </span>
                        </a>
                    </div>
                </nav>
            </div>
            <div class="img-label-sm">
                <img src="" alt="">
            </div>
            <span class="min-music"><i class="fas fa-minus"></i></span>
        </header>
        <div class="dados-musica">
        </div>
        <audio id="musica" preload="true">
            <source id="musica-source" src="" type="audio/mp3">
        </audio>
        <div class="timeline">
            <div class="timeline-bar">
                <span class="before"></span>
                <span class="after"></span>    
            </div>
        </div>
        <div class="controles-musica">
            <a href="#" class="left-btn"><i class="fas fa-chevron-circle-left"></i></a>
            <a href="#" class="play-btn paused"><i class="fas fa-play-circle"></i><i class="fas fa-pause-circle"></i></a>
            <a href="#" class="right-btn"><i class="fas fa-chevron-circle-right"></i></a>
        </div>
    </div>
<section class="corpo bg-principal">

