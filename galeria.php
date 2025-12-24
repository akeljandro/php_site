<?php
require_once 'layout.php';
require_once 'admin/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="/js/galeria.js"></script>
</head>
<body>
    <?php renderNavigation(); ?>
    <main>
        <h1>Galería</h1>
    </main>
    <div id="galeria">
        
        <?php
            try {
                $pdo = getDatabaseConnection();
                
                // Get portfolio items ordered by year and number
                $stmt = $pdo->query("SELECT year, number, intellectual_property, pictures_url FROM portfolio ORDER BY year DESC, number DESC");
                $portfolio_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($portfolio_items) > 0) {
                    // Group items by year
                    $items_by_year = [];
                    foreach ($portfolio_items as $item) {
                        $items_by_year[$item['year']][] = $item;
                    }
                    
                    // Display items grouped by year
                    foreach ($items_by_year as $year => $items) {
                        echo "<div class='year-section'>";
                        echo "<h2 class='year-title'>" . htmlspecialchars($year) . "</h2>";
                        echo "<div class='gallery-grid'>";
                        
                        foreach ($items as $item) {
                            echo "<div class='filter'><img src='" . htmlspecialchars($item['pictures_url']) . "' alt='" . htmlspecialchars($item['intellectual_property']) . "' class='gallery'></div>";
                        }
                        
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='no-items'><p>No hay elementos en la galería aún.</p></div>";
                }
                
            } catch(PDOException $e) {
                echo "<div class='error'><p>Error al cargar la galería: " . htmlspecialchars($e->getMessage()) . "</p></div>";
            }
        ?>
        <div id="lightbox">
            <span class="close">&times;</span>
            <a class="prev">&#10094;</a>
            <a class="next">&#10095;</a>
            <img class="modal-content" id="img01">
        </div>
    </div>
</body>
</html>