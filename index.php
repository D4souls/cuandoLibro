<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#695CFE" />
    <link href="css/login.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="img/logo-alt.png">
    <title>CL | Iniciar Sesión</title>
</head>

<body>
    <div class="container-login">
        <div class="form-login">
            <form method="POST" action="./scripts/php/seguridad/control.php">
                <h1 class="title">Iniciar Sesión</h1>
                <label>
                    <i class='bx bx-user'></i>
                    <input type="text" name="user" placeholder="Usuario...">
                </label>
                <label>
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password" placeholder="Contraseña...">
                </label>
                <a href="#" class="link">Contactar al administrador</a>

                <button id="button">Acceder</button>
            </form>
        </div>
    </div>
</body>

</html>