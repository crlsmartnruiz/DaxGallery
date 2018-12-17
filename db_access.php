<?php

include_once './usuario.php';
include_once './imagen.php';

function createConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "daxgallery";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        return null;
    } else {
        return $conn;
    }
}

function closeConnextion($conn) {
    $conn->close();
}

function createUser($name, $email, $pass) {
    $sql = "INSERT INTO Usuario (nombre,email,pass) VALUES (?,?,?)";
    $conn = createConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $pass);
    $stmt->execute();
    $last_id = $conn->insert_id;
    $stmt->close();
    closeConnextion($conn);
    return $last_id;
}

function findUserByEmail($email) {
    $conn = createConnection();
    $sql = "SELECT * FROM Usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        $usuario = NULL;
        while ($row = $result->fetch_assoc()) {
            $usuario = new usuario($row["userId"], $row["nombre"], $row["email"], $row["pass"]);
        }
        closeConnextion($conn);
        return $usuario;
    }
}

function findUsuarioByUserID($userId) {
    $conn = createConnection();
    $sql = "SELECT * FROM Usuario WHERE userId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        $usuario = NULL;
        while ($row = $result->fetch_assoc()) {
            $usuario = new usuario($row["userId"], $row["nombre"], $row["email"], $row["pass"]);
        }
        closeConnextion($conn);
        return $usuario;
    }
}

function createImage($ruta, $desc, $usuario) {
    $sql = "INSERT INTO Imagen (ruta,descripcion,usuario) VALUES (?,?,?)";
    $conn = createConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $ruta, $desc, $usuario);
    $stmt->execute();
    $last_id = $conn->insert_id;
    $stmt->close();
    closeConnextion($conn);
    return $last_id;
}

function findImagesByUsuario($userId) {
    $imageArray = [];

    $conn = createConnection();
    $sql = "SELECT * FROM Imagen WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        while ($row = $result->fetch_assoc()) {
            $imagen = new imagen($row["imageId"], $row["ruta"], $row["descripcion"], $row["likes"], $row["dislikes"], $row["publicada"], $row["fecha"], $row["usuario"]);
            array_push($imageArray, $imagen);
        }
        closeConnextion($conn);
        return $imageArray;
    }
}

function findAllImages() {
    $imageArray = [];
    $conn = createConnection();
    $sql = "SELECT * FROM Imagen WHERE publicada=1";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        while ($row = $result->fetch_assoc()) {
            $imagen = new imagen($row["imageId"], $row["ruta"], $row["descripcion"], $row["likes"], $row["dislikes"], $row["publicada"], $row["fecha"], $row["usuario"]);
            array_push($imageArray, $imagen);
        }
        closeConnextion($conn);
        return $imageArray;
    }
}

function findImageByImageId($imageId) {
    $conn = createConnection();
    $sql = "SELECT * FROM Imagen WHERE `imageId` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        while ($row = $result->fetch_assoc()) {
            $imagen = new imagen($row["imageId"], $row["ruta"], $row["descripcion"], $row["likes"], $row["dislikes"], $row["publicada"], $row["fecha"], $row["usuario"]);
        }
        closeConnextion($conn);
        return $imagen;
    }
}

function updateLikes($image) {
    $likes = $image->getLikes() + 1;
    $imageId = $image->getImageId();
    $conn = createConnection();

    $sql = "UPDATE Imagen SET likes=? WHERE imageId=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $likes, $imageId);
    $stmt->execute();
    $stmt->close();
    closeConnextion($conn);
}

function updateDislikes($image) {
    $conn = createConnection();
    $imageId = $image->getImageId();
    $dislikes = $image->getDislikes() + 1;
    $sql = "UPDATE Imagen SET dislikes=? WHERE imageId=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $dislikes, $imageId);
    $stmt->execute();
    $stmt->close();
    closeConnextion($conn);
}

function deleteImage($image) {
    $conn = createConnection();
    $sql = "DELETE FROM Imagen WHERE imageId=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $image->getImageId());
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    closeConnextion($conn);
}

function publicarImagen($image, $codigo) {
    $PUBLICAR = 0;
    $PRIVATIZAR = 1;

    if ($codigo == $PUBLICAR) {
        $sql = "UPDATE Imagen SET publicada=1 WHERE imageId=?";
    } else if ($codigo == $PRIVATIZAR) {
        $sql = "UPDATE Imagen SET publicada=0 WHERE imageId=?";
    }

    $conn = createConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $image->getImageId());
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    closeConnextion($conn);
}

function findAllImageIds() {
    $conn = createConnection();
    $sql = "SELECT imageId FROM Imagen WHERE publicada = 1 ORDER BY imageId";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    $arrayDeIds = [];

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        while ($row = $result->fetch_assoc()) {
            array_push($arrayDeIds, $row["imageId"]);
        }
        closeConnextion($conn);
    }
    
    return $arrayDeIds;
}
