<?php

session_start();
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
