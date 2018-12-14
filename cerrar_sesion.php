<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (isset($_SESSION["usuario"])) {
            unset($_SESSION["usuario"]);
            header('Location: index.php');
            if (isset($_SESSION)) {
                session_unset();
                session_destroy();
            }
        } else {
            header('Location: index.php');
        }
        ?>
    </body>
</html>
