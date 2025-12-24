<?php
require_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Acceso Restringido</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php renderNavigation(); ?>
    <main>
        <h1>Acceso Restringido</h1>
        <div class="login-container">
            <?php
            require_once 'auth.php';
            
            // Handle login submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
                $username = trim($_POST['username']);
                $password = $_POST['password'];
                
                if (login($username, $password)) {
                    // Redirect to originally requested page or default
                    $redirect_url = $_SESSION['redirect_url'] ?? 'contact.php';
                    unset($_SESSION['redirect_url']);
                    header('Location: ' . $redirect_url);
                    exit();
                } else {
                    echo '<div class="message-error">Usuario o contraseña incorrectos</div>';
                }
            }
            
            // Show success message if logged out
            if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
                echo '<div class="message-success">Has cerrado sesión correctamente</div>';
            }
            ?>
            
            <form action="" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">Iniciar Sesión</button>
            </form>
            
            <div class="login-info">
                <p><small>Usuario: admin | Contraseña: password123</small></p>
            </div>
        </div>
    </main>
</body>
</html>
