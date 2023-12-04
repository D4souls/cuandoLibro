<?php
//vemos si el usuario y contraseña es válido
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $user = $_POST["user"];

    $query_comprobarpasswd = "SELECT * FROM userweb WHERE username = ?";
    $stmt_comprobar = $conexion->prepare($query_comprobarpasswd);
    $stmt_comprobar->bind_param("s", $user);
    $stmt_comprobar->execute();
    $stmt_comprobar->store_result();
    $stmt_comprobar->bind_result($id, $usernameweb, $db_password, $rol, $dniusuarioweb, $lastlogout, $datePasswordChange);

    if ($stmt_comprobar->fetch()) {
        $stmt_comprobar->close();
        if ($datePasswordChange === null) {
            if ($password == $db_password) {
                $_SESSION["autentificado"] = "SI";
                $_SESSION["ultimoAcceso"] = date("d-m-Y H:i:s");
                $_SESSION["userwebdni"] = $dniusuarioweb;
                if ($rol == 1) {
                    header("Location: ../../../sites/my-portal.php");
                    exit();
                } else {
                    header("Location: ../../../sites/dashboard.php");
                    exit();
                }
            } else {
                $error_message = "Credenciales no válidas";
                header("Location: ../../../index.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            // verifica en SHA-256
            $hashed_password_input = hash('sha256', $password);

            if ($hashed_password_input === $db_password) {
                $_SESSION["autentificado"] = "SI";
                $_SESSION["ultimoAcceso"] = date("d-m-Y H:i:s");
                $_SESSION["userwebdni"] = $dniusuarioweb;
                if ($rol == 1) {
                    header("Location: ../../../sites/my-portal.php");
                    exit();
                } else {
                    header("Location: ../../../sites/dashboard.php");
                    exit();
                }
            } else {
                $error_message = "Credenciales no válidas";
                header("Location: ../../../index.php?error=" . urlencode($error_message));
                exit();
            }
        }
    } else {
        $stmt_comprobar->close();
        $error_message = "Usuario no encontrado";
        header("Location: ../../../index.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    $conexion->close();
    header("Location: ../../../index.php");
    exit();
}

