<?php 

// namespace autoload\classes\DAL;

class albumDAO{

    //Todos os albuns existentes
    public function worldAlbuns($conexao){

        $stmt = $conexao->getPdo()->prepare(
        'SELECT nameAlbum, pkAlbum FROM album'
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Albuns do user
    function userAlbuns($conexao, User $user){

        $stmt = $conexao->getPdo()->prepare(
        'SELECT DISTINCT a.pkAlbum, a.nameAlbum FROM album a 
        INNER JOIN music m ON a.pkAlbum = m.fkAlbum 
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE u.nickname = :nickname'
        );

        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function userAlbuns2($conexao, User $user){

        $stmt = $conexao->getPdo()->prepare(
        'SELECT DISTINCT a.pkAlbum, a.nameAlbum FROM album a 
        INNER JOIN music m ON a.pkAlbum = m.fkAlbum 
        INNER JOIN user u ON m.fkUser = u.pkUser 
        WHERE u.nickname = :nickname'
        );

        $stmt->bindValue(':nickname', $user->getNickname());
        $stmt->execute();

        return $stmt->fetchAll();
    }

    //Adiciona novo Album (logo apos essa funcao, deve chamar a funcao de criar musica
    //Usar tbm qdo for modificar musica
    function newAlbum($conexao, Album $album){
        $stmt = $conexao->getPdo()->prepare(
            'INSERT INTO album (created, nameAlbum) 
            SELECT * FROM 
            (SELECT Now(), :nome) as a 
            WHERE NOT EXISTS 
            ( SELECT nameAlbum FROM album WHERE nameAlbum = :nome)'
        );
    
        $stmt->bindValue(':nome', $album->getNome());
        
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($pdo->errorInfo());
        } else {
            echo 'funfou';
        }

        $stmt->execute();
    
        return $stmt->fetchAll();
    }



}