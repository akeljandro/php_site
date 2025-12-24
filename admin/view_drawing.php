<?php
// Include database configuration
require_once 'database.php';

try {
    $pdo = getDatabaseConnection();
    
    // Get drawing ID from URL parameter
    $id = $_GET['id'] ?? 0;
    
    if (!is_numeric($id) || $id <= 0) {
        header('HTTP/1.0 400 Bad Request');
        exit('Invalid drawing ID');
    }
    
    // Get drawing data from database
    $stmt = $pdo->prepare("SELECT image_data, title FROM picasso WHERE id = ?");
    $stmt->execute([$id]);
    $drawing = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$drawing) {
        header('HTTP/1.0 404 Not Found');
        exit('Drawing not found');
    }
    
    // Output the image
    header('Content-Type: image/png');
    header('Content-Disposition: inline; filename="' . htmlspecialchars($drawing['title']) . '.png"');
    echo $drawing['image_data'];
    
} catch(PDOException $e) {
    header('HTTP/1.0 500 Internal Server Error');
    exit('Database error: ' . $e->getMessage());
}
?>
