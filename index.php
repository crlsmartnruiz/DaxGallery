<?php
session_start();
//session_destroy();

include_once './db_access.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Imágenes - DaxGallery</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>      
        <?php        include_once 'head_template.php';?>
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

                    if (sizeof($arrayImagenes) !== 0) {
                        ?>
                        <div class="panel-botones col-12 text-center">
                            <input type="button" value="Cargar más" onclick="cargarMas()" class="btn"/>
                        </div>

                        <?php
                    }
                    ?>
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
