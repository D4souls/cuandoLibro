<?php
//vemos si el usuario y contraseña es váildo
session_start();
include("conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $user = $_POST["user"];

    $query_userweb = "SELECT userpassword FROM userweb WHERE username = ?";
    $query_comprobacion_userweb = $conexion->prepare($query_userweb);
    $query_comprobacion_userweb->bind_param("s", $_POST["user"]);
    $query_comprobacion_userweb->execute();

    // Ahora vamos a almacenar la contraseña que nos devuelve la base de datos

    $query_comprobacion_userweb->store_result();
    $query_comprobacion_userweb->bind_result($db_password);

    if ($query_comprobacion_userweb->fetch()) {
        if ($password == $db_password) {
            $_SESSION["autentificado"] = "SI";
            header("Location: ../../../dashboard.php");
            exit();
        } else {
            // Contraseña incorrecta, redirige al inicio de sesión con mensaje de error
            header("Location: ../../../index.html?error=Contraseña incorrecta");
            exit();
        }
    }

    $query_comprobacion_userweb->close();
} else {
    header("Location: ../../../index.html");
    exit();
}

$conexion->close();
?>