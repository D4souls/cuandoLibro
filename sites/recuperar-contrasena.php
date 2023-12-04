<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#695CFE" />
    <link href="../css/login.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="../img/logo-alt.png">
    <title>CL | Recuperar contraseña</title>
</head>

<body>
    <div class="container-login">
        <div class="form-login">
            <form method="POST" action="./scripts/php/mail/recover-password.php">
                <h1 class="title">Recuperar contraseña</h1>
                <?php
                $error_message = isset($_GET['error']) ? $_GET['error'] : '';
                ?>
                <div class="error-message text" id="error-message">
                    <?php echo $error_message ?>
                </div>
                <label>
                    <i class='bx bx-envelope'></i>
                    <input type="mail" name="mail" placeholder="Mail de recuperación">
                </label>

                <button id="button">Enviar correo de recuperación</button>
            </form>
        </div>
    </div>
</body>

</html>