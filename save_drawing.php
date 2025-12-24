<?php
// Completely clean start - no whitespace, no BOM
// Clear all output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Prevent any output before JSON
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

// Get raw POST data first
$rawPost = file_get_contents('php://input');
if ($rawPost) {
    parse_str($rawPost, $_POST);
}

// Include database configuration
require_once 'admin/database.php';

try {
    $pdo = getDatabaseConnection();
} catch(PDOException $e) {
    // Clear all output buffers before error response
    while (ob_get_level()) {
        ob_end_clean();
    }
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Get image data from POST request
$imageData = $_POST['imageData'] ?? '';
$title = $_POST['title'] ?? 'Untitled Drawing';

// Debug: Log received data
error_log("Received imageData length: " . strlen($imageData));
error_log("Received title: " . $title);

// Validate input
if (empty($imageData)) {
    // Clear all output buffers before error response
    while (ob_get_level()) {
        ob_end_clean();
    }
    echo json_encode(['success' => false, 'message' => 'No se proporcionaron datos de imagen']);
    exit();
}

// Validate title length
if (strlen($title) > 255) {
    // Clear all output buffers before error response
    while (ob_get_level()) {
        ob_end_clean();
    }
    echo json_encode(['success' => false, 'message' => 'El título es demasiado largo']);
    exit();
}

// Remove data URL prefix to get base64 data
$imageData = str_replace('data:image/png;base64,', '', $imageData);
$imageData = base64_decode($imageData);

if ($imageData === false) {
    // Clear all output buffers before error response
    while (ob_get_level()) {
        ob_end_clean();
    }
    echo json_encode(['success' => false, 'message' => 'Datos de imagen inválidos']);
    exit();
}

// Insert into database
$stmt = $pdo->prepare("INSERT INTO picasso (title, image_data, created_at) VALUES (?, ?, NOW())");

try {
    $result = $stmt->execute([$title, $imageData]);
    
    // Clear all output buffers before response
    while (ob_get_level()) {
        ob_end_clean();
    }
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => '¡Dibujo guardado con éxito!']);
        require_once 'admin/telegram.php';
        $telegramMessage = "Nuevo dibujo guardado: " . $title;
        sendTelegramMessage($telegramMessage);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el dibujo']);
    }
} catch(PDOException $e) {
    error_log("Failed to save drawing to database: " . $e->getMessage());
    // Clear all output buffers before error response
    while (ob_get_level()) {
        ob_end_clean();
    }
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>
