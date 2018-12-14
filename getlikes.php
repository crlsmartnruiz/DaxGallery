<?php include_once './db_access.php';
$imageId = $_REQUEST["image"];
$image = findImageByImageId($imageId);
updateLikes($image);
$image = findImageByImageId($imageId);
echo "Likes: " . $image->getLikes();

