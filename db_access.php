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
    $sql = "SELECT * FROM Usuario WHERE email = '$email'";
    $result = $conn->query($sql);

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
    $sql = "SELECT * FROM Usuario WHERE userId = '$userId'";
    $result = $conn->query($sql);

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
    $sql = "SELECT * FROM Imagen WHERE usuario = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        while ($row = $result->fetch_assoc()) {
            $imagen = new imagen($row["imageId"], $row["ruta"], $row["descripcion"], $row["likes"], $row["dislikes"], $row["publicada"], $row["usuario"]);
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
            $imagen = new imagen($row["imageId"], $row["ruta"], $row["descripcion"], $row["likes"], $row["dislikes"], $row["publicada"], $row["usuario"]);
            array_push($imageArray, $imagen);
        }
        closeConnextion($conn);
        return $imageArray;
    }
}

function findImageByImageId($imageId) {
    $conn = createConnection();
    $sql = "SELECT * FROM Imagen WHERE `imageId` = '$imageId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        closeConnextion($conn);
        return NULL;
    } else {
        while ($row = $result->fetch_assoc()) {
            $imagen = new imagen($row["imageId"], $row["ruta"], $row["descripcion"], $row["likes"], $row["dislikes"], $row["publicada"], $row["usuario"]);
        }
        closeConnextion($conn);
        return $imagen;
    }
}

function updateLikes($image) {
    $conn = createConnection();
    $likes = $image->getLikes() + 1;
    $sql = "UPDATE Imagen SET likes=" . $likes . " WHERE imageId='" . $image->getImageId() . "'";
    $result = $conn->query($sql);

    /* if($result === TRUE) {
      echo "Record updated successfully";
      }else {
      echo "Error updating record: " . $conn->error;
      } */
}

function updateDislikes($image) {
    $conn = createConnection();
    $dislikes = $image->getDislikes() + 1;
    $sql = "UPDATE Imagen SET dislikes=" . $dislikes . " WHERE imageId='" . $image->getImageId() . "'";
    $result = $conn->query($sql);

    /* if($result === TRUE) {
      echo "Record updated successfully";
      }else {
      echo "Error updating record: " . $conn->error;
      } */
}

function deleteImage($image) {
    $conn = createConnection();
    $sql = "DELETE FROM Imagen WHERE imageId='" . $image->getImageId() . "'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

function publicarImagen($image,$codigo) {
    $PUBLICAR = 0;
    $PRIVATIZAR = 1;
    
    $conn = createConnection();
    
    $conn = createConnection();
    
    if($codigo == $PUBLICAR) {
        $sql = "UPDATE Imagen SET publicada=1 WHERE imageId='" . $image->getImageId() . "'";
    }else if($codigo == $PRIVATIZAR) {
        $sql = "UPDATE Imagen SET publicada=0 WHERE imageId='" . $image->getImageId() . "'";
    }else {
        
    }
    
    $result = $conn->query($sql);
}
