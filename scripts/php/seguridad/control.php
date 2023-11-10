<?php
//vemos si el usuario y contraseña es váildo
session_start();
var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if ($_POST["user"]=="miguel" && $_POST["password"]=="qwerty"){
        //usuario y contraseña válidos
        //defino una sesion y guardo datos
        $_SESSION["autentificado"]= "SI";
        header("Location: ../../../dashboard.php");
        exit();
    }else {
        //si no existe le mando otra vez a la portada
        header("Location: ../../../index.html");
        exit();
    }
} else {
    header("Location: ../../../index.html");
    exit();
}
?>