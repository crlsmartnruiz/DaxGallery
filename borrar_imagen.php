<?php

session_start();
include_once './db_access.php';
//Comprobar si hay usuario iniciado
//Comprobar si el usuario iniciado es el dueño de la foto

parse_str($_SERVER['QUERY_STRING'], $get_array);


$imagen = findImageByImageId($get_array['imagen']);

if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == $imagen->getUsuario()) {

    if (!unlink($imagen->getRuta())) {
        echo ("Se ha producido un error eliminando " . $imagen->getRuta());
    } else {
        echo ("Eliminado " . $imagen->getRuta());

        deleteImage($imagen);
    }
    
    header('Location: index.php?propias=1');
} else {
    echo "No tienes autorización para acceder a esta ruta";
}





