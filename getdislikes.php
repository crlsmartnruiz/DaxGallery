<?php include_once './db_access.php';
$imageId = $_REQUEST["image"];
$image = findImageByImageId($imageId);
updateDislikes($image);
$image = findImageByImageId($imageId);
echo "Dislikes: " . $image->getDislikes();


