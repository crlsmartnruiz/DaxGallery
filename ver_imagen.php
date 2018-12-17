<?php
session_start();
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
    </head>
    <body>
        <div class='container'>
            <?php include './mensaje-saludo.php'; ?>

            <?php include './mensaje.php'; ?>

            <div class='row'>
                <?php
                include './menus.php';

                $url = $_SERVER['REQUEST_URI'];
                $parts = parse_url($url);
                parse_str($parts['query'], $query);
                $imagen = findImageByImageId($query['imagen']);
                ?>

                <div class='content col-sm-12 col-md-9 container'>
                    <?php if ($imagen == NULL) { ?>
                        <div class="alert alert-danger col-12">
                            <p><strong>¡Error!</strong> Se ha producido un error. Por favor, vuelva a la página principal</p>
                            <input type="button" onclick="goToIndex()" value="Volver a la página principal"/>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class='imagen'>
                            <img src='<?php echo $imagen->getRuta() ?>' class='img-thumbnail'/>
                        </div>

                        <div class='panel-botones row' >
                            <?php
                            if (isset($_SESSION['usuario'])) {
                                if ($_SESSION['usuario'] == $imagen->getUsuario()) {
                                    ?>
                                    <div class='grupo-botones col-sm-12 row' >
                                        <?php if ($imagen->getPublicada() == 1) {
                                            ?> 
                                            <input type='button' value='Hacer imagen privada' onclick="mostrarMensaje(2)" class='boton btn col-sm-12 col-md-6'/>
                                            <?php
                                        } else {
                                            ?> 
                                            <input type='button' value='Hacer imagen publica' onclick="mostrarMensaje(0)" class='boton btn col-sm-12 col-md-6'/>
                                        <?php }
                                        ?>

                                        <input  type='button' value='Borrar imagen' onclick="mostrarMensaje(1)" class='boton btn col-sm-12 col-md-6'/>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class='grupo-botones col-sm-12 row' >
                                    <input type='button' value='Dislikes: <?php echo $imagen->getDislikes() ?>' onclick='dislike(<?php echo $imagen->getImageId() ?>);pintarCanvas()' id='btnDislike' class='btn col-sm-12 col-md-4'/>
                                    <canvas id='myCanvas' width='200' height='20' class='col-sm-12 col-md-4'></canvas>
                                    <input type='button' value='Likes: <?php echo $imagen->getLikes() ?>' onclick='like(<?php echo $imagen->getImageId() ?>);pintarCanvas()' id='btnLike' class='btn col-sm-12 col-md-4'/>
                                </div>


                                <?php
                            } else {
                                ?>
                                <p class="col-sm-12 col-md-4 text-center">Dislikes: <?php echo $imagen->getDislikes() ?></p>
                                <canvas id='myCanvas' width='200' height='20' class='col-sm-12 col-md-4'></canvas>
                                <p class="col-sm-12 col-md-4 text-center">Likes: <?php echo $imagen->getLikes() ?></p>
                                <?php
                            }
                            ?>
                        </div>


                        <div class = 'tabla table-responsive'>
                            <table id = 'datos' class='table table-bordered'>
                                <tr>
                                    <td>
                                        <p>Descripción: </p>
                                    </td>
                                    <td >
                                        <p>
                                            <?php echo $imagen->getDesc() ?>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td >
                                        <p>Autor:</p>
                                    </td>

                                    <td >
                                        <p><?php echo findUsuarioByUserID($imagen->getUsuario())->getNombre() ?></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p>Fecha de subida:</p>
                                    </td>

                                    <td>
                                        <p>
                                            <?php
                                            $fecha = strtotime($imagen->getFecha());
                                            setlocale(LC_TIME, "es_ES");
                                            echo strftime("%A, %d de %B de %Y", $fecha);
                                            ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>


                        </div>

                        <div class="text-center panel-botones">
                            <?php
                            $arrayIds = findAllImageIds();

                            if ($arrayIds != NULL) {
                                $index = array_search($imagen->getImageId(), $arrayIds);

                                if (isset($index)) {
                                    if (isset($arrayIds[($index - 1) % sizeof($arrayIds)])) {
                                        ?>
                                        <a href="ver_imagen.php?imagen=<?php echo $arrayIds[($index - 1) % sizeof($arrayIds)] ?>" class="btn btn-primary">Anterior</a>

                                        <?php
                                    }

                                    if (isset($arrayIds[($index + 1) % sizeof($arrayIds)])) {
                                        ?>

                                        <a href="ver_imagen.php?imagen=<?php echo $arrayIds[($index + 1) % sizeof($arrayIds)] ?>" class="btn btn-primary">Siguiente</a>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>  
                </div>
            </div>

            <?php include './footer.php'; ?>   
        </div>

        <script>
            const BORRAR_IMAGEN = 1;
            const RESUMEN_BORRAR_IMAGEN = '¿Borrar imagen?';
            const DETALLE_BORRAR_IMAGEN = '¿Está seguro de que desea borrar la imagen? Esta imagen se perderá permanentemente.';

            const PUBLICAR_IMAGEN = 0;
            const RESUMEN_PUBLICAR_IMAGEN = '¿Publicar imagen?';
            const DETALLE_PUBLICAR_IMAGEN = '¿Está seguro de que desea publicar la imagen? Esta imagen podrá ser vista por todos los usuarios de DaxGallery.';

            const PRIVATIZAR_IMAGEN = 2;
            const RESUMEN_PRIVATIZAR_IMAGEN = '¿Publicar imagen?';
            const DETALLE_PRIVATIZAR_IMAGEN = '¿Está seguro de que desea publicar la imagen? Esta imagen podrá ser vista por todos los usuarios de DaxGallery.';

            var likes = <?php echo $imagen->getLikes() ?>;
            var dislikes = <?php echo $imagen->getDislikes() ?>;

            function pintarCanvas() {
                var canvas = document.getElementById('myCanvas');
                var ctx = canvas.getContext('2d');

                var suma = likes + dislikes;

                var propLikes = 100;
                var propDislikes = 100;

                console.log(suma);

                if (suma !== 0) {
                    var width = canvas.width;

                    var porcLikes = likes / suma;
                    var porcDislikes = dislikes / suma;

                    propLikes = width * porcLikes;
                    propDislikes = width * porcDislikes;
                }

                ctx.fillStyle = '#FF0000';
                ctx.fillRect(0, 0, propDislikes, 20);

                ctx.fillStyle = '#00FF00';
                ctx.fillRect(propDislikes, 0, propLikes, 20);
            }

            function mostrarMensaje(codigo) {
                $("#myModal").modal().show();
                var modalFooter = document.getElementById('foot');

                var resumen = document.getElementById('resumen');
                var detalle = document.getElementById('detalle');

                var btnNo = document.createElement('input');
                btnNo.type = "button";
                btnNo.value = "No";
                btnNo.id = "btn_no";
                btnNo.className = "btn";

                var btnSi = document.createElement('input');
                btnSi.type = "button";
                btnSi.value = "Sí, estoy seguro";
                btnSi.id = "btn_si";
                btnSi.className = "btn btn-primary";

                if (codigo == PUBLICAR_IMAGEN) {
                    resumen.innerHTML = RESUMEN_PUBLICAR_IMAGEN;
                    detalle.innerHTML = DETALLE_PUBLICAR_IMAGEN;

                    btnNo.onclick = function () {
                        cerrarMensaje();
                    };

                    btnSi.onclick = function () {
                        llamarAPublicarImagen();
                        cerrarMensaje();
                    };
                } else if (codigo == BORRAR_IMAGEN) {
                    resumen.innerHTML = RESUMEN_BORRAR_IMAGEN;
                    detalle.innerHTML = DETALLE_BORRAR_IMAGEN;

                    btnNo.onclick = function () {
                        cerrarMensaje();
                    };

                    btnSi.onclick = function () {
                        cerrarMensaje();
                        window.location.assign("borrar_imagen.php" + location.search);
                    };
                } else if (codigo == PRIVATIZAR_IMAGEN) {
                    resumen.innerHTML = RESUMEN_PRIVATIZAR_IMAGEN;
                    detalle.innerHTML = DETALLE_PRIVATIZAR_IMAGEN;

                    btnNo.onclick = function () {
                        cerrarMensaje();
                    };

                    btnSi.onclick = function () {
                        llamarAPublicarImagen();
                        cerrarMensaje();
                    };
                }
                modalFooter.appendChild(btnNo);
                modalFooter.appendChild(btnSi);
            }

            function cerrarMensaje() {
                var panelMensaje = document.getElementById('foot');

                var btnNo = document.getElementById("btn_no");
                if (btnNo != undefined) {
                    panelMensaje.removeChild(btnNo);
                }

                var btnSi = document.getElementById("btn_si");
                if (btnSi != undefined) {
                    panelMensaje.removeChild(btnSi);
                }

                $("#myModal").modal('hide');
            }

            function llamarAPublicarImagen() {
                window.location.href = 'publicar_imagen.php?image=' + <?php echo $imagen->getImageId() ?>;
            }

            function like(imageId) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        document.getElementById("btnLike").value = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getlikes.php?image=" + imageId, true);
                xmlhttp.send();

                likes = parseInt(document.getElementById("btnLike").value.split(":")[1].trim()) + 1;
                document.getElementById("btnLike").value = "Likes: " + likes;
            }

            function dislike(imageId) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                        document.getElementById("btnDislike").value = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getdislikes.php?image=" + imageId, true);
                xmlhttp.send();

                dislikes = parseInt(document.getElementById("btnDislike").value.split(":")[1].trim()) + 1;
                document.getElementById("btnDislike").value = "Dislikes: " + dislikes;
            }

            window.onload = function () {
                pintarCanvas();
            }

        </script>

        <!--<script src="javascript/general.js"/>-->

    </body>
</html>
