<?php 
session_start();
if (!isset($_SESSION['nickname'])) {
    include 'cabecalho-index.php'; ?>

<form class="form-index cadastro" action="autoload/classes/Action/userAC.php" method="post">
    <div class="campo-cadastro">
        <label class="form-index-label" for="nome-cadastro">Nome:</label><br>
        <input class="form-index-input" type="text" name="nome-cadastro">
    </div>
    <div class="campo-cadastro">
        <label class="form-index-label" for="cpf-cadastro">Nickname:</label><br>
        <input class="form-index-input" type="text" name="nickname-cadastro">
    </div>
    <div class="campo-cadastro">
        <label class="form-index-label" for="email-cadastro">Email:</label><br>
        <input class="form-index-input" type="text" name="email-cadastro">
    </div>
    <div class="campo-cadastro">
        <label class="form-index-label" for="confirma-email-cadastro">Confirmar Email:</label><br>
        <input class="form-index-input" type="text" name="confirma-email-cadastro">
    </div>
    <div class="campo-cadastro">
        <label class="form-index-label" for="senha-cadastro">Senha:</label><br>
        <input class="form-index-input" type="password" name="senha-cadastro">
    </div>
    <div class="campo-cadastro">
        <label class="form-index-label" for="confirma-senha-cadastro">Confirma Senha:</label><br>
        <input class="form-index-input" type="password" name="confirma-senha-cadastro">
    </div>
    <button class="index-btn" href="feed.php" type="submit">Cadastrar</button>
</form>
<button class="back-index btn-entrar">Já possui cadastro?</button>

<?php include 'footer-index.php';
} else {
    header('Refresh: 0; url=feed.php');
//    header("Location: feed.php");
    exit;
}
?>
