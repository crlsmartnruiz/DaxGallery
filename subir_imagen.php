<?php
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"/>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css"/>   
    </head>
    <body>


        <div class="container">

            <?php include './mensaje-saludo.php'; ?>


            <?php include './mensaje.php'; ?>

            <div class="row">
                <?php
                include './menus.php';



                if (isset($_SESSION["usuario"])) {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $descripcion = test_input($_POST["desc"]);
                        $usuario = test_input($_POST["user"]);

                        $target_dir = "images/" . $usuario . "/";
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $error_message = '';

                        if (isset($_POST["submit"])) {
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if ($check !== false) {
                                //echo "<p>El archivo es una imagen - " . $check["mime"] . ".</p>";
                                $uploadOk = 1;
                            } else {
                                $error_message = "El archivo no es una imagen.";
                                $uploadOk = 0;
                            }
                        }

                        //Si el archivo que desea subir existe se dispara este error
                        if (file_exists($target_file) && $uploadOk) {
                            $error_message = "El archivo que intentas subir ya existe.";
                            $uploadOk = 0;
                        }

                        //Si el archivo que desea subir existe no es de estos 4 tipos, se dispara este error
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $uploadOk) {
                            $error_message = "solo se admiten archivos con este formato: JPG, JPEG, PNG y GIF.";
                            $uploadOk = 0;
                        }

                        //Si el archivo ocupa más de 7.000.000 bytes se dispara el error
                        if ($_FILES["fileToUpload"]["size"] > 7000000 && $uploadOk) {
                            $error_message = "el archivo es demasiado grande.";
                            $uploadOk = 0;
                        }

                        if ($uploadOk == 1) {
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                $usuario = test_input($_POST["user"]);
                                $newImageId = createImage($target_file, $descripcion, $usuario);
                                header('Location: ver_imagen.php?imagen=' . $newImageId);
                            }
                        } else {
                            
                        }
                    }
                    ?>


                    <div class="formulario col-sm-12 col-md-9">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

                            <fieldset>
                                <legend>Formulario para subir una imagen</legend>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Seleccione la imagen</span>
                                    </div>
                                    <input type="file" name="fileToUpload" required class="form-control" id="fileToUpload"/>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" >
                                        <span class="input-group-text">Descripción de la imagen</span>
                                    </div>

                                    <textarea name="desc" class="form-control" rows="10" cols="100" maxlength="1024" required id="descripcion"></textarea>


                                </div>

                                <div hidden>
                                    <input type="number" name="user" value="<?php echo $_SESSION["usuario"] ?>" readonly="true"></input>
                                </div>

                                <div class="btn-group btn-group-sm btn-group-md">
                                    <input type="button" value="Volver atrás" onclick="goBack()" class="btn"/>
                                    <input type="reset" value="Resetear formulario" class="btn"/>
                                    <input type="submit" value="Subir imagen" class="btn btn-primary"/>
                                </div>
                            </fieldset>

                        </form>
                    </div>

                    <?php
                } else {
                    ?>
                    <div class="alert alert-danger col-sm-12 col-md-9">
                        <p><strong>¡Error!</strong> Se ha producido un error. Por favor, vuelva a la página principal</p>
                        <input type="button" onclick="goToIndex()" value="Volver a la página principal"/>
                    </div>
                    <?php
                }
                ?>      

            </div>

            <?php include './footer.php'; ?>


            <?php

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>
        </div>

        <script src="javascript/general.js"/>
    </body>
    
    
    
</html>
