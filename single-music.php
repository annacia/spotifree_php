<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Philosopher:400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
<?php require_once "autoload/Helper/playlist.php"; ?>
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
                        <a href="#">
                            <span class="add-playlist">
                                <i class="fas fa-plus-circle" alt="Adicionar a uma playlist"></i>
                            </span>
                        </a>
                    </div>
                </nav>
            </div>
            <img src="img/music-art.png" alt="">
            <span class="min-music"><i class="fas fa-minus"></i></span>
        </header>
        <div class="dados-musica">
            <p>Nome da Musica</p>
            <p>Dono da Musica</p>
            <p>Album</p>
        </div>
        <audio id="musica" preload="true">
            <source id="musica-source" src="music/A.mp3" type="audio/mp3">
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


    <script src="js/jquery.js"></script>
    <script src="js/jquery-filestyle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/modal.js"></script>
    <script src="js/menu_script.js"></script>
    <script src="js/player.js"></script>
</body>
</html>