<?php include 'cabecalho.php'; ?>

    <div>
        <select name="type-feed" id="type-feed" class="select-feed">
            <option value="Meu Feed">Meu Feed</option>
            <option value="World Feed">World Feed</option>
        </select>
    
        <select name="type-category" id="type-category" class="select-feed">
            <option value="0">Categorias</option>
            <?php 
            $categorias = worldCategoria($conexao2);
            foreach ($categorias as $categoria) :
            ?>
                <option value="<?= $categoria['pkcategory']; ?>"><?= $categoria['nameCategory']; ?></option>
            <?php endforeach; ?>
        </select>


    </div>

    <div id="feed-musics-selecteds"></div>

<?php include 'footer.php'; ?>0