<?php
require_once 'layout.php';
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
            $dir_img = "img/portfolio/";
            $img = scandir($dir_img);
            foreach ($img as $value) {
                if (preg_match("/\.(jpg|jpeg|png|gif|bmp|webp|svg)$/i", $value)) {
                    $name = pathinfo($value, PATHINFO_FILENAME);
                    echo "<div class='filter'><img src='img/portfolio/$value' alt='$name' class='gallery'></div>";
                }
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