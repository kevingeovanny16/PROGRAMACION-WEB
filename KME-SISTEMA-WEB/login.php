<?php
require_once "auth.php";

if (estaLogueado()) {
    header("Location: index.php");
    exit;
}

$mensajeError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $usuarioValido = "admin";
    $passwordValida = "KME2026";

    if ($usuario === $usuarioValido && $password === $passwordValida) {
        $_SESSION["usuario_autenticado"] = true;
        $_SESSION["nombre_usuario"] = $usuario;
        header("Location: index.php");
        exit;
    } else {
        $mensajeError = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | KME Inventario y Ventas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
    <main class="login-wrapper">
        <section class="login-card">
            <h1>KME Inventario y Ventas</h1>
            <p class="subtitle-login">Acceso al sistema</p>

            <?php if ($mensajeError !== ""): ?>
                <div class="login-error"><?php echo htmlspecialchars($mensajeError); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" class="btn btn-primary login-btn">Ingresar</button>
            </form>

            <div class="login-help">
                <p><strong>Usuario de prueba:</strong> admin</p>
                <p><strong>Contraseña:</strong> KME2026</p>
            </div>
        </section>
    </main>
</body>
</html>