<?php

include_once './db_access.php';

$imageId = $_REQUEST["image"];
$image = findImageByImageId($imageId);
publicarImagen($image, $image->getPublicada());

header('Location: index.php');

