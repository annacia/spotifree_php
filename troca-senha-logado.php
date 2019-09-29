<?php include("cabecalho.php"); ?>

    <form action="autoload/classes/Action/userAC.php" class="generic-form" method="POST">
        <h2>Mudar Senha</h2>
        
        <label for="senha-atual">Senha Atual:</label>
        <input type="password" name="password-old">
        <label for="senha-nova">Senha Nova:</label>
        <input type="password" name="password-new">
        <button type="submit">Solicitar Nova Senha</button>
    </form>

<?php include("footer.php"); ?>