
<?php
session_start();
include_once './db_access.php';
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Iniciar sesión - DaxGallery</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php        include_once 'head_template.php';?>
    </head>
    <body >
        <?php
        $errMessaje = $email = $pass = "";

        if (!isset($_SESSION['usuario'])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = test_input($_POST["email"]);
                $pass = test_input($_POST["pass"]);
                $usuario = findUserByEmail($email);

                if ($usuario == NULL) {
                    $errMessaje = "El usuario o la contraseña son incorrectos";
                } else {
                    $hashedPasswordFromDB = $usuario->getPass();
                    if (password_verify($pass, $hashedPasswordFromDB)) {
                        $_SESSION["usuario"] = $usuario->getUserID();
                        print_r($_SESSION);
                        header('Location: index.php?propias=1');
                        exit();
                    } else {
                        $errMessaje = "El usuario o la contraseña son incorrectos";
                    }
                }
            }
        } else {
            echo '<p>Ya estás registrado</p>';
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
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  <?php
                    if (isset($_SESSION['usuario'])) {
                        echo 'hidden';
                    }
                    ?>>
                        <fieldset>
                            <legend>Introduzca los datos de inicio de sesión</legend>

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
                                <input type="password" name="pass" required  class="form-control" id="pwd"/>
                            </div>                          

                            <?php
                            if ($errMessaje != '') {
                                ?>
                                <div class="alert alert-danger">
                                    <span><?php echo "$errMessaje"; ?></span>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="btn-group btn-group-sm">
                                <input type="button" value="Volver atrás" onclick="goBack()" class="btn"/>
                                <input type="reset" value="Resetear formulario" class="btn"/>
                                <input type="submit" value="Iniciar sesión" class="btn btn-primary"/>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <?php include './footer.php'; ?>
        </div>

        <script src="javascript/general.js"/>
    </body>
</html>
