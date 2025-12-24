<?php
require_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Mi o_O</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
</head>
<body>
    <?php renderNavigation(); ?>
    <div class="about-container">
        <main id="abt-main">
            <aside>
                <p>Donde encontrarme!</p>
                <div class="links">
                    <?php
                    try {
                        require_once 'admin/database.php';
                        $pdo = getDatabaseConnection();
                        $query = "SELECT * FROM social_links WHERE is_nsfw = 0 ORDER BY platform ASC";
                        $stmt = $pdo->query($query);
                        
                        // Debug: Show number of results
                        $count = $stmt->rowCount();
                        echo "<!-- Debug: Found $count SFW social links -->";
                        
                        if ($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch()) {
                                // Remove leading slash from image path if present
                                $icon_path = ltrim($row['icon_path'], '/');
                                echo "<!-- Debug: Link - {$row['display_text']} - Icon: $icon_path -->";
                                echo '<a href="' . htmlspecialchars($row['url']) . '" target="_blank">';
                                echo '<img src="' . $icon_path . '" alt="' . htmlspecialchars($row['alt_text']) . '">';
                                echo htmlspecialchars($row['display_text']);
                                echo '</a>';
                            }
                        } else {
                            echo "<!-- Debug: No SFW social links found -->";
                        }
                    } catch(PDOException $e) {
                        echo '<!-- Database error: ' . htmlspecialchars($e->getMessage()) . ' -->';
                        // Fallback links in case database fails
                        echo '<a href="https://psi-sulfur.tumblr.com/" target="_blank">';
                        echo '<img src="img/tumblr.png" alt="Tumblr Logo">';
                        echo 'Blog Personal/Principal';
                        echo '</a>';
                    }
                    ?>
                </div>
                <hr>
                <div id="toggle">
                    <button data-target="nsfw" data-toggle="true">
                        Click aquí si eres un cochino!
                    </button>
                </div>
                <div id="nsfw" class="links toggle-section">
                    <p>Estos incluyen material erótico ficticio, ¡advertencia!</p>
                    <?php
                    try {
                        $query = "SELECT * FROM social_links WHERE is_nsfw = 1 ORDER BY platform ASC";
                        $stmt = $pdo->query($query);
                        
                        if ($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch()) {
                                // Remove leading slash from image path if present
                                $icon_path = ltrim($row['icon_path'], '/');
                                echo '<a href="' . htmlspecialchars($row['url']) . '" target="_blank">';
                                echo '<img src="' . $icon_path . '" alt="' . htmlspecialchars($row['alt_text']) . '">';
                                echo htmlspecialchars($row['display_text']);
                                echo '</a>';
                            }
                        }
                    } catch(PDOException $e) {
                        echo '<!-- Database error: ' . htmlspecialchars($e->getMessage()) . ' -->';
                        // Fallback NSFW links in case database fails
                        echo '<a href="https://akels-x.tumblr.com/" target="_blank">';
                        echo '<img src="img/tumblr.png" alt="Tumblr Logo">';
                        echo 'Blog erótico';
                        echo '</a>';
                    }
                    ?>
                </div>
                <p>Estos son los que realmente me importan lmao</p>
            </aside>

            <div class="info">
                <div id="abt">
                    <h1>Sobre mí</h1>
                    <p>
                        <img src="/img/god lorde.gif" alt="" id="wowo">
                        Ellop, este es el idiota profesional, artista por hobby, y pervertido de medio tiempo.
                    </p>
                    <?php
                        $labels_dir = "img/labels";
                        $labels = scandir($labels_dir);
                        echo '<div class="marquee-container">';
                        echo '<div class="marquee">';
                        foreach ($labels as $label) {
                            if (preg_match("/\.(jpg|jpeg|png|gif|bmp|webp|svg)$/i", $label)) {
                                echo '<div class="marquee-item">';
                                echo "<img src='img/labels/$label' alt='$label'>";
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                        echo '</div>';
                    ?>
                </div>
                <div id="sympath">
                    <p>
                        Personajes que son LITERALMENTE YO <br>
                        (no soy kinnie) (casi todos me avergüenzan) 
                    </p>
                    <?php
                    try {
                        $query = "SELECT * FROM character_sprites ORDER BY id";
                        $stmt = $pdo->query($query);
                        
                        // Debug: Show number of results
                        $count = $stmt->rowCount();
                        echo "<!-- Debug: Found $count character sprites -->";
                        
                        if ($stmt->rowCount() > 0) {
                            while($row = $stmt->fetch()) {
                                $id = strtolower(str_replace(' ', '-', $row['character_name']));
                                // Remove leading slash and add synpaths subdirectory
                                $image_path = 'img/synpaths/' . basename(ltrim($row['image_path'], '/'));
                                echo "<!-- Debug: Character - {$row['character_name']} - Image: $image_path -->";
                                echo '<img src="' . $image_path . '" alt="' . htmlspecialchars($row['alt_text']) . '" id="' . $id . '" title="' . htmlspecialchars($row['title']) . '">';
                            }
                        } else {
                            echo "<!-- Debug: No character sprites found -->";
                        }
                    } catch(PDOException $e) {
                        echo '<!-- Database error: ' . htmlspecialchars($e->getMessage()) . ' -->';
                        // Fallback character sprites in case database fails
                        echo '<img src="img/synpaths/tord.png" alt="Tord from Eddsworld" id="tord" title="Tord from Eddsworld">';
                        echo '<img src="img/synpaths/homura.png" alt="Homura Akemi" id="homura" title="Homura Akemi">';
                    }
                    $pdo = null; // Close connection
                    ?>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Toggle functionality for NSFW section
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('#toggle button');
            const nsfwSection = document.getElementById('nsfw');
            
            if (toggleButton && nsfwSection) {
                toggleButton.addEventListener('click', function() {
                    nsfwSection.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>