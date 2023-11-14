<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["autentificado"]) || $_SESSION["autentificado"] != "SI") {
    // Si no está autenticado, redirige a la página de inicio
    header("Location: ../../../../index.php");
    exit();
}

include("conexion.php");
$timestamp = date("Y-m-d H:i:s");
$userwebdni = $_SESSION["userwebdni"];
$query_update_lastlogout = "UPDATE userweb SET lastlogout = ? WHERE dniusuarioweb = ?";
$query_update_lastlogout = $conexion->prepare($query_update_lastlogout);
$query_update_lastlogout->bind_param("ss", $timestamp, $userwebdni);
$query_update_lastlogout->execute();
$query_update_lastlogout->close();

// Destruye la sesión
session_destroy();

// Redirige a la página de inicio después de cerrar sesión
header("Location: ../../../../index.php");
exit();
