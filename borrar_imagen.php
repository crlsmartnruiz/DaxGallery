<?php

session_start();
include_once './db_access.php';

parse_str($_SERVER['QUERY_STRING'], $get_array);
$imagen = findImageByImageId($get_array['imagen']);

if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == $imagen->getUsuario()) {
    if (!unlink($imagen->getRuta())) {
    } else {
        deleteImage($imagen);
    }
    header('Location: index.php?propias=1');
} else {
    echo "No tienes autorización para acceder a esta ruta";
}





