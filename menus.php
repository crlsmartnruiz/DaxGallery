<?php include_once './db_access.php'; ?>

<!DOCTYPE html>
<html>
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
                                    <i class="fas fa-eye"></i>
                                    Ver imágenes públicas
                                </a>
                            </li>
                            <li>
                                <a href='index.php?propias=1'>
                                    <i class="fas fa-lock"></i>
                                    Ver imágenes propias
                                </a>
                            </li>
                            <li>
                                <a href='subir_imagen.php'>
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Subir imagen
                                </a>
                            </li>
                            <li>
                                <a href='cerrar_sesion.php'>
                                    <i class="fas fa-times-circle"></i>
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
                                    <i class="fas fa-lock-open"></i>
                                    Iniciar sesión
                                </a>
                            </li>
                            <li>
                                <a href='registro.php'>
                                    <i class="fas fa-registered"></i>
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
