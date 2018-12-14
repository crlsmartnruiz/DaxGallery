<?php
/**
 * Description of imagen
 *
 * @author Admin
 */
class imagen {
    private $imageId;
    private $ruta;
    private $descripcion;
    private $likes;
    private $dislikes;
    private $publicada;
    private $usuario;
    
    function __construct($imageId,$ruta,$descripcion,$likes,$dislikes,$publicada,$usuario) {
        $this->imageId = $imageId;
        $this->ruta = $ruta;
        $this->descripcion = $descripcion;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->publicada = $publicada;
        $this->usuario = $usuario;
    }
    
    function getImageId() {
        return $this->imageId;
    }
    
    function getRuta() {
        return $this->ruta;
    }
    
    function getDesc() {
        return $this->descripcion;
    }
    
    function getLikes() {
        return $this->likes;
    }
    
    function getDislikes() {
        return $this->dislikes;
    }
    
    function getPublicada() {
        return $this->publicada;
    }
    
    function getUsuario() {
        return $this->usuario;
    }
}
