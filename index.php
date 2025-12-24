<?php
require_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OwO</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php renderNavigation(); ?>
    <main>
        <h1>
    Página de prueba
</h1>
<p>Esta página es para probar PHP y JS.</p>
<div class="marquee-container">
    <?php 
    require_once 'database.php';
    try {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("SELECT name, link, image_data FROM buttons");
        $buttons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($buttons)) {
            echo '<div class="marquee">';
            foreach ($buttons as $button) {
                // Convert binary image data to base64 for display
                $imageData = base64_encode($button['image_data']);
                $imageSrc = 'data:image/png;base64,' . $imageData;
                echo '<div class="marquee-item">';
                echo '<a href="' . htmlspecialchars($button['link'], ENT_QUOTES, 'UTF-8') . '" target="_blank">';
                echo '<img src="' . $imageSrc . '" alt="' . htmlspecialchars($button['name'], ENT_QUOTES, 'UTF-8') . '" class="button">';
                echo '</a></div>';
            }
            echo '</div>';
        } else {
            echo '<p>No buttons found in database.</p>';
        }
    } catch(PDOException $e) {
        echo '<p>Error loading buttons: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    ?>
</div>
    </main>
</body>
</html>