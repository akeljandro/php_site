<?php
// Require authentication to access this page
require_once 'auth.php';
requireAuth();
require_once '../layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería - Dibujos guardados</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <?php renderNavigation(); ?>
    <div class="gallery-container">
        <div class="gallery-header">
            <h1>Galería - Dibujos guardados</h1>
        </div>

        <?php
        // Include database configuration
        require_once 'database.php';

        try {
            $pdo = getDatabaseConnection();
            
            // Get all drawings ordered by creation date (newest first)
            $stmt = $pdo->query("SELECT id, title, created_at FROM picasso ORDER BY created_at DESC");
            $drawings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($drawings) > 0) {
                echo '<div class="gallery-grid">';
                
                foreach ($drawings as $drawing) {
                    echo '<div class="drawing-card">';
                    echo '<img src="view_drawing.php?id=' . $drawing['id'] . '" alt="' . htmlspecialchars($drawing['title']) . '" class="drawing-image">';
                    echo '<div class="drawing-info">';
                    echo '<div class="drawing-title">' . htmlspecialchars($drawing['title']) . '</div>';
                    echo '<div class="drawing-date">' . date('M j, Y g:i A', strtotime($drawing['created_at'])) . '</div>';
                    echo '<div class="drawing-actions">';
                    echo '<button class="download-btn" onclick="downloadDrawing(' . $drawing['id'] . ', \'' . htmlspecialchars($drawing['title']) . '\')">Descargar</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                
                echo '</div>';
            } else {
                echo '<div class="no-drawings">';
                echo '<h3>No hay dibujos guardados aún</h3>';
                echo '<p>¡Comienza a dibujar y guarda tu primera obra de arte!</p>';
                echo '</div>';
            }
            
        } catch(PDOException $e) {
            echo '<div class="error-message">';
            echo '<strong>Error:</strong> No se pudo conectar a la base de datos. ' . htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>
    </div>
</body>
<script>
function downloadDrawing(drawingId, title) {
    // Fetch the drawing image
    fetch('view_drawing.php?id=' + drawingId)
        .then(response => response.blob())
        .then(blob => {
            // Create a temporary URL for the blob
            const url = window.URL.createObjectURL(blob);
            
            // Create a temporary link element
            const link = document.createElement('a');
            link.href = url;
            link.download = title + '.png';
            
            // Trigger the download
            document.body.appendChild(link);
            link.click();
            
            // Clean up
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error al descargar dibujo:', error);
            alert('Error al descargar el dibujo. Inténtalo de nuevo.');
        });
}
</script>
</html>
