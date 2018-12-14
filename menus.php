<?php include_once './db_access.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
    <body>
        <div class="col-sm-12 col-md-3">
            <?php
            if (isset($_SESSION["usuario"])) {
                ?>
                <div class='sesion-iniciada container'>
                    <div class='saludo row'>
                        <p class='col-12'>Hola, <?php echo findUsuarioByUserID($_SESSION["usuario"])->getNombre() ?></p>
                    </div>


                    <div class='menu row'>
                        <ul class='col-12' style='padding: 0'>
                            <li>
                                <a href='index.php'>
                                    Ver imágenes públicas
                                </a>
                            </li>
                            <li>
                                <a href='index.php?propias=1'>
                                    Ver imágenes propias
                                </a>
                            </li>
                            <li>
                                <a href='subir_imagen.php'>
                                    Subir imagen
                                </a>
                            </li>
                            <li>
                                <a href='cerrar_sesion.php'>
                                    Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            } else {
                ?>

                <div class='sesion-no-iniciada container'>
                    <div class='saludo row'>
                        <p class='col-12'>Si no dispones de una cuenta, puedes crear una pulsando en 'Registrarse'.</p>
                        <p class='col-12'>Si ya dispones de una cuenta, puedes entrar en ella en 'Iniciar sesión'.</p>
                    </div>
                    <div class='menu row'>
                        <ul class='col-12' style='padding: 0'>
                            <li>
                                <a href='inicio_sesion.php'>
                                    Iniciar sesión
                                </a>
                            </li>
                            <li>
                                <a href='registro.php'>
                                    Registrarse
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </body>
</html>
