<?php include("cabecalho.php"); ?>
    <!-- Talvez vire modal -->
    <div class="playlist list-playlist">
        <a href="#" class="playlist-item">
            <!-- aqui ele pega  a arte da primeira musica -->
            <img src="img/music-art.png" alt="">
            <span>Nome da Playlist</span>
        </a>
    </div>

    <div class="nova-playlist">
        <a href="#">
            <i class="fas fa-plus-square"></i>
            <span>Nova Playlist</span>
        </a>
    </div>

    <div class="adicionar-playlist click-off">
        <label for="nome-playlist">Nome da Playlist:</label>
        <input type="text">
        <button type="submit"><i class="fas fa-check"></i></button>
    </div>

<?php include("footer.php"); ?>