<?php
require_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php renderNavigation(); ?>

    <main>
        <h1>Dibuja aquí</h1>
        <div id="canvas-container">
            <div class="color-picker-container">
                <div class="custom-color-picker">
                    <div id="colorPreview" style="background-color: #000000; width: 50px; height: 50px; border: 2px solid var(--txt); border-radius: 4px;"></div>
                    <div class="color-controls">
                        <div class="canvas-picker-container">
                            <canvas id="colorCanvas" width="200" height="200"></canvas>
                            <div class="color-cursor" id="colorCursor"></div>
                        </div>
                        <div class="brightness-container">
                            <label>Brightness:</label>
                            <input type="range" id="brightnessSlider" min="0" max="100" value="100">
                        </div>
                        <div class="hex-input-group">
                            <label>HEX:</label>
                            <input type="text" id="hexInput" value="#000000" maxlength="7">
                        </div>
                    </div>
                    <div>
                        <input type="range" name="Tamaño" id="sizeSlider" min="1" max="50" value="5">
                        <label for="sizeSlider">Tamaño: <span id="sizeValue">5</span>px</label>
                    </div>
                </div>
            </div>
            <canvas id="myCanvas" style="width: 25em; height: 25em;">
                <p>El canvas no es compatible con su navegador.</p>
            </canvas>
        </div>
        <div id="controls">
            <button id="clearBtn">Limpiar</button>
            <button id="undoBtn">Deshacer</button>
            <button id="saveBtn">Guardar</button>
            <button id="sendBtn">Enviar</button>
        </div>
        <div id="message">
            <?php
            // Start session for flash messages
            session_start();
            
            // Include database configuration
            require_once 'admin/database.php';
            
            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['msj'])) {
                $message = trim($_POST['msj']);
                
                if (!empty($message)) {
                    try {
                        $pdo = getDatabaseConnection();
                        
                        // Insert message into database
                        $stmt = $pdo->prepare("INSERT INTO messages (message, ip_address, user_agent) VALUES (?, ?, ?)");
                        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
                        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
                        
                        $result = $stmt->execute([$message, $ip_address, $user_agent]);
                        
                        if ($result) {
                            $_SESSION['flash_message'] = ['type' => 'success', 'text' => '¡Mensaje enviado con éxito!'];
                            require_once 'admin/telegram.php';
                            $telegramMessage = "Nuevo mensaje: " . $message;
                            sendTelegramMessage($telegramMessage);
                        } else {
                            $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error al guardar el mensaje'];
                        }
                    } catch(PDOException $e) {
                        error_log("Failed to save message: " . $e->getMessage());
                        $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Error de base de datos. Inténtalo de nuevo.'];
                    }
                } else {
                    $_SESSION['flash_message'] = ['type' => 'error', 'text' => 'Por favor, escribe un mensaje'];
                }
                
                // Redirect to prevent form resubmission
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
            
            // Display flash message if exists
            if (isset($_SESSION['flash_message'])) {
                $flash = $_SESSION['flash_message'];
                $class = $flash['type'] === 'success' ? 'message-success' : 'message-error';
                echo '<div class="' . $class . '">' . htmlspecialchars($flash['text']) . '</div>';
                unset($_SESSION['flash_message']);
            }
            ?>
            <form action="" method="POST">
                <input type="text" name="msj" id="msj" placeholder="Escribe tu mensaje aquí..." required>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </main>
    <script src="/js/contact.js"></script>
</body>
</html>