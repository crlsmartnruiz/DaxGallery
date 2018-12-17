<?php
session_start();
include_once './db_access.php';

$parts = parse_url($_SERVER["REQUEST_URI"]);
parse_str($parts['query'], $query);
$offset = $query["offset"];

$arrayImagenes = [];

if (!isset($_SESSION["usuario"])) {
    //Llamar a imagenes públicas
    $arrayImagenes = findAllImages($offset);
} else {
    $str_arr = explode("/", $_SERVER['HTTP_REFERER']);
    if ($str_arr[4] == 'index.php?propias=1') {
        $arrayImagenes = findImagesByUsuario($_SESSION["usuario"], $offset);
    } else {
        $arrayImagenes = findAllImages($offset);
    }
}

foreach ($arrayImagenes as $image) {
    ?>
    <a href='ver_imagen.php?imagen=<?php echo $image->getImageId() ?>' class='carta col-sm-12 col-md-6 col-lg-4'>
        <div class='card'>
            <img class='card-img-top' src='<?php echo $image->getRuta() ?>' alt='<?php echo $image->getRuta() ?> no encontrada' style='width:100%'>
            <div class='card-body'>
                <p class='card-text'>
                    <?php echo $image->getDesc() ?>
                </p>
            </div>
        </div>
    </a>

    <?php
}





