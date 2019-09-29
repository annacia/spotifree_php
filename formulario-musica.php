<?php 
require_once("autoload/classes/User.php");
require_once("autoload/classes/categoriaDAO.php");
include("cabecalho.php"); 
?>

    <h2 class="titulo2">Upload</h2>
    
    <form action="autoload/classes/upload.php" class="container form-music"  enctype="multipart/form-data" method="post">
        <div class="form-group">
            <label for="nome-upload">Nome da Música:</label>
            <input type="text" class="input-text" name="nome-upload" >
        </div>
        <!-- Aqui sera um selectize -->
        <div class="form-group">
            <label for="album-upload">Nome do Album:</label>
            <input type="text" class="input-text" name="album-upload" >
        </div>
        <div class="form-group">
            <label for="musica-art">Arte do Album:</label>
            <input type="file" class="jfilestyle send-file artalbum" data-input="true" name="musica-art"  accept=".jpg, .jpeg, .png">
        </div>
        <div class="form-group">
            <label for="categoria-upload">Categoria:</label>
            <select name="categoria-upload" class="select-upload" >
                <?php
                $categorias = worldCategoria($conexao2); 
                foreach($categorias as $categoria) :
                ?>
                    <option value="<?= $categoria['nameCategory'] ?>"><?= $categoria['nameCategory'] ?></a></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label for="musica-file">Selecione sua Música:</label>
            <input type="file" class="jfilestyle send-file musica-file" data-input="false" name="musica-file"  accept=".mp3, .aac, .wav">
        </div>  
        <button type="submit"  value="Submit" name="submit" class="btn-upload">Enviar</button>
    </form>

<?php include("footer.php"); ?>
