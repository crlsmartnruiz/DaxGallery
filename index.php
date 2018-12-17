<?php
session_start();
//session_destroy();

include_once './db_access.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"/>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="css/main.css"/>   
        <!--<script src="javascript/general.js"/>-->
    </head>
    <body>
        <div class='container'>
            <?php include './mensaje-saludo.php'; ?>

            <?php include './mensaje.php'; ?>

            <div class='row'>
                <?php include './menus.php'; ?>     

                <div class="col-sm-12 col-md-9">
                    <?php
                    $offset = 6;
                    $url = $_SERVER['REQUEST_URI'];
                    $parts = parse_url($url);

                    //Imagenes propias
                    if (isset($parts['query'])) {
                        parse_str($parts['query'], $query);

                        //Se llama a mostrar solo las fotos privadas
                        if ($query['propias'] == 1) {
                            if (isset($_SESSION["usuario"])) {
                                $arrayImagenes = findImagesByUsuario($_SESSION["usuario"], $offset);
                                ?>

                                <div id="lista-imagenes" class='lista-imagenes content row'>
                                    <?php recorrerArray($arrayImagenes); ?>
                                </div>

                                <?php
                            } else {//Si no hay usuario con sesion iniciada
                                ?>
                                <div id="lista-imagenes" class='lista-imagenes content row'>
                                    <div class="alert alert-danger col-12">
                                        <p><strong>¡Error!</strong> Se ha producido un error. Por favor, vuelva a la página principal</p>
                                        <input type="button" onclick="goToIndex()" value="Volver a la página principal"/>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div id="lista-imagenes" class='lista-imagenes content row'>
                                <div class="alert alert-danger col-12">
                                    <p><strong>¡Error!</strong> Se ha producido un error. Por favor, vuelva a la página principal</p>
                                    <input type="button" onclick="goToIndex()" value="Volver a la página principal"/>
                                </div>
                            </div>
                            <?php
                        }
                        //Imagenes públicas
                    } else {
                        $arrayImagenes = findAllImages($offset);
                        ?>
                        <div id="lista-imagenes" class='lista-imagenes content row'>
                            <?php recorrerArray($arrayImagenes); ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="panel-botones col-12 text-center">
                        <input type="button" value="Cargar más" onclick="cargarMas()" class="btn"/>
                    </div>
                </div>
            </div>

            <?php include './footer.php'; ?>

            <!--<script src="javascript/general.js" type="text/javascript"/>-->

            <script>
                offset = 6;

                function goToIndex() {
                    window.location.href = 'index';
                }

                function cargarMas() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            //console.log(this.responseText);
                            document.getElementById("lista-imagenes").innerHTML = this.responseText;
                        }
                    };
                    console.log('Llamado ' + offset);
                    offset = offset + 3;
                    xmlhttp.open("GET", "cargar_mas.php?offset=" + offset, true);
                    console.log('Llamado ' + offset);
                    xmlhttp.send();
                }
            </script>

            <?php

            function recorrerArray($arrayImagenes) {
                if (count($arrayImagenes) !== 0) {
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
                } else {
                    ?> 
                    <div class="alert alert-info">
                        <p><strong>Información</strong> No hay ninguna imagen alojada en nuestra base de datos en este momento.</p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </body>
</html>
