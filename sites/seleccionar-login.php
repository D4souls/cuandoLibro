<?php 
include('../scripts/php/seguridad/seguridad.php');
include('../scripts/php/seguridad/conexion.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#695CFE" />
    <link href="../css/login.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="img/logo-alt.png">
    <title>CL | Iniciar Sesión</title>
</head>

<body>
    <div class="container-login">
        <div class="form-login">
            <form>
                <h1 class="title">Modo de inicio de sesión</h1>
                <button type="button" class="addButton" onclick="goToDashboard()">Administrador</button>
                <br>
                <button type="button" class="saveButton" onclick="goToMyPortal()">My-portal</button>
            </form>
        </div>
    </div>
</body>

<script>
    function goToDashboard(){
        window.location.href = "dashboard.php";
    }

    function goToMyPortal(){
        window.location.href = "my-portal.php";
    }
</script>

</html>