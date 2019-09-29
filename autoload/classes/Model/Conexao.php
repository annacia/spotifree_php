<?php


// namespace autoload\classes\Model;

class Conexao
{
    private $pdo;

    public function __construct()
    {
        $this->setPdo();
        $this->getPdo();
    }

    public function setPdo()
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=127.0.0.1; dbname=spotifree; charset=utf8', 'root', '',
                array(
                    PDO::ATTR_PERSISTENT => true,
                )
            );
        } catch (PDOException $e) {
            //throw $th;
            echo 'Error!: '.$e->getMessage().'<br/>';
            die();
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
