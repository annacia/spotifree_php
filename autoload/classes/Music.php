<?php 

class Music {
    private $nome;
    private $album;
    private $dir_art;
    private $categoria;
    private $dir_music; 
    
    public function __construct(string $nome, string $album, string $dir_art, string $categoria, string $dir_music){
        $this->setNome($nome);
        $this->setAlbum($album);
        $this->setDir_art($dir_art);
        $this->setCategoria($categoria);
        $this->setDir_music($dir_music);
    }

    public function setNome(string $nome){
        $this->nome = $nome;
    }

    public function setAlbum(string $album){
        $this->album = $album;
    }

    public function setDir_art(string $dir_art){
        $this->dir_art = $dir_art;
    }

    public function setCategoria(string $categoria){
        $this->categoria = $categoria;
    }

    public function setDir_music(string $dir_music){
        $this->dir_music = $dir_music;
    }

    public function getNome() : string {
        return $this->nome;
    }

    public function getAlbum() : string {
        return $this->album;
    }

    public function getDir_art() : string {
        return $this->dir_art;
    }

    public function getCategoria() : string {
        return $this->Categoria;
    }

    public function getDir_music() : string {
        return $this->dir_music;
    }
    
}