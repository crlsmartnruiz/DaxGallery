<?php
session_start();
?>
<?php
include_once './db_access.php';
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
        <?php
        $error_en_registro = FALSE;
        $name = $email = $pass = "";

        if (!isset($_SESSION['usuario'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = test_input($_POST["email"]);
                $pass = test_input($_POST["pass"]);
                $name = test_input($_POST["name"]);
                $options = [
                    'cost' => 11,
                ];
                $hash = password_hash($pass, PASSWORD_BCRYPT, $options);
                $nuevoId = createUser($name, $email, $hash);

                if ($nuevoId != 0) {
                    $pathname = "images/" . $nuevoId;
                    mkdir($pathname, "0777", TRUE);
                    header('Location: index.php');
                } else {
                    $error_en_registro = TRUE;
                }
            }
        } else {
            echo '<p>Ya ha iniciado</p>';
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>

        <div class="container">
            <?php include './mensaje-saludo.php'; ?>

            <?php include './mensaje.php'; ?>

            <div class="row">
                <?php include './menus.php'; ?>       

                <div class="formulario col-sm-12 col-md-9">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <fieldset>
                            <legend>Introduzca los datos de registro</legend>

                            <?php
                            if ($error_en_registro) {
                                ?>
                                <div class="alert alert-danger col-12">
                                    <p><strong>¡Error!</strong> Se ha producido un error. El correo electrónico con el que desea registrarse ya está en uso.</p>
                                </div>
                                <?php
                                
                                $error_en_registro = FALSE;
                            }
                            ?>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text">Nombre:</span>
                                </div>
                                <input type="text" name="name" required class="form-control" id="nombre"/>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text">Email:</span>
                                </div>
                                <input type="email" name="email" required class="form-control" id="email"/>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text">Contraseña:</span>
                                </div>
                                <input type="password" name="pass" required class="form-control" id="pass1"/>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend" >
                                    <span class="input-group-text">Repita la contraseña:</span>
                                </div>
                                <input type="password" name="pass2" required class="form-control" id="pass2"/>
                            </div>


                            <div class="btn-group btn-group-sm">
                                <input type="button" value="Volver atrás" onclick="goBack()" class="btn"/>
                                <input type="reset" value="Resetear formulario" class="btn"/>
                                <input type="submit" value="Registrarse" class="btn btn-primary"/>
                            </div>
                        </fieldset>
                    </form>

                </div>
            </div>


            <?php include './footer.php'; ?>   


        </div>


        <script>
            var pass1 = document.getElementById("pass1")
                    , pass2 = document.getElementById("pass2");

            function validatePassword() {
                if (pass1.value !== pass2.value) {
                    pass2.setCustomValidity("Las contraseñas no coinciden");
                } else {
                    pass2.setCustomValidity('');
                }
            }

            pass1.onchange = validatePassword;
            pass2.onkeyup = validatePassword;
        </script>

        <!--<script src="javascript/general.js"/>-->



    </body>
</html>
