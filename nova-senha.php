<?php include("cabecalho.php"); ?>

    <form action="nova-senha.php" class="generic-form new-pass">
        <div class="form-group">
            <label for="senha-nova">Senha Nova:</label>
            <input type="text" name="senha-nova" >
        </div>
        <div class="form-group">
            <label for="senha-confirma">Confirmar Senha:</label>
            <input type="text" name="senha-confirma" >    
        </div>
        <button type="submit">Solicitar Nova Senha</button>
    </form>

<?php include("footer.php"); ?>