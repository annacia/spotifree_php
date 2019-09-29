<?php
if(isset($_GET["login"]) && $_GET["login"]==false) {
?>
<p class="alert-danger">Usuário ou senha inválida!</p>
<?php
}
?>
<?php include("cabecalho-index.php"); ?>

            <p class="texto">
            Lorem ipsum dolor sit amet, consectetu adipiscing elit. In arcu turpis, 
            vehicula in sollicitudin non, consectetur ultricies ante. Curabitur aliquet 
            rhoncus blandit. Vestibulum non dui eget eros convallis tempus. Quisque ultrices 
            eu urna ut sodales. Pellentesque eu tincidunt lectus, nec mollis libero. Nullam a 
            diam at nulla semper tempus. Morbi tincidunt pulvinar nisi non facilisis. Proin sit 
            amet dignissim justo. Maecenas finibus nisi id pretium ultrices. Phasellus ullamcorper 
            luctus metus. Fusce at mauris eu tellus ultricies interdum.
            </p>


            <?php
                session_start(); 
                if(!isset($_SESSION["nickname"])) {
                    echo '
                    <nav class="menu-index">
                    <a href="#" class="menu-item btn-entrar">Entrar</a>/
                    <a href="cadastro.php" class="menu-item btn-cadastrar">Cadastre-se</a>
                    </nav>'; 
                } else {
                    echo '
                    <nav class="menu-index">
                        <a href="feed.php" class="menu-item btn-feed">Meu Feed</a>/<a class="menu-item" href="autoload/Helper/logout.php">Sair</a>
                    </nav>';
                }
            ?>
            
            

<?php include("footer-index.php"); ?>