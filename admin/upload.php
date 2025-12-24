<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Content</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <?php 
    require_once 'database.php';
    require_once 'auth.php';
    require_once '../layout.php';
    requireAuth();
    renderNavigation(); 
    ?>
    
    <main>
        <div class="card">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $table = $_POST['table'] ?? '';
                $title = $_POST['title'] ?? '';
                $link = $_POST['link'] ?? '';
                $description = $_POST['description'] ?? '';
                $characterName = $_POST['character_name'] ?? '';
                $series = $_POST['series'] ?? '';
                $isNsfw = isset($_POST['is_nsfw']) ? 1 : 0;
                $image = $_FILES['image'] ?? null;
                
                if ($image && $image['error'] === UPLOAD_ERR_OK) {
                    $imageData = file_get_contents($image['tmp_name']);
                    
                    try {
                        $pdo = getDatabaseConnection();
                        
                        switch ($table) {
                            case 'buttons':
                                $stmt = $pdo->prepare("INSERT INTO buttons (name, image_data, link) VALUES (?, ?, ?)");
                                $result = $stmt->execute([$title, $imageData, $link ?: '#']);
                                break;
                                
                            case 'character_sprites':
                                $imagePath = '/img/sprites/' . $image['name'];
                                move_uploaded_file($image['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $imagePath);
                                $stmt = $pdo->prepare("INSERT INTO character_sprites (image_path, alt_text, character_name, title, series) VALUES (?, ?, ?, ?, ?)");
                                $result = $stmt->execute([$imagePath, $description, $characterName ?: $title, $title, $series ?: 'Unknown']);
                                break;
                                
                            case 'social_links':
                                $stmt = $pdo->prepare("INSERT INTO social_links (platform, url, display_text, icon_path, alt_text, is_nsfw) VALUES (?, ?, ?, ?, ?, ?)");
                                $result = $stmt->execute([$title, $link, $title, '/img/icons/' . $image['name'], $title, $isNsfw]);
                                break;
                                
                            default:
                                echo '<p style="color: red;">Invalid table selected.</p>';
                                return;
                        }
                        
                        if ($result) {
                            echo '<p style="color: green;">✓ ' . ucfirst($table) . ' uploaded successfully!</p>';
                        } else {
                            echo '<p style="color: red;">✗ Failed to upload ' . $table . '.</p>';
                        }
                    } catch(PDOException $e) {
                        echo '<p style="color: red;">Database error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    }
                } else {
                    echo '<p style="color: red;">Please select a file to upload.</p>';
                }
            }
            ?>
            
            <h2>Upload Content</h2>
            <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="tableSelect">Content Type:</label>
                <select name="table" id="tableSelect" required onchange="toggleFields()">
                    <option value="buttons">Buttons</option>
                    <option value="character_sprites">Character Sprites</option>
                    <option value="social_links">Social Links</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="imageFile">Image File:</label>
                <input type="file" name="image" id="imageFile" accept="image/*" required>
            </div>
            
            <div class="form-group">
                <label for="titleInput">Title/Name:</label>
                <input type="text" name="title" id="titleInput" placeholder="Enter title or name" required>
            </div>
            
            <div class="form-group" id="linkGroup">
                <label for="linkInput">Link:</label>
                <input type="url" name="link" id="linkInput" placeholder="https://example.com">
            </div>
            
            <div class="form-group" id="descriptionGroup">
                <label for="descriptionInput">Description:</label>
                <input type="text" name="description" id="descriptionInput" placeholder="Brief description">
            </div>
            
            <div class="form-group" id="characterNameGroup">
                <label for="characterNameInput">Character Name:</label>
                <input type="text" name="character_name" id="characterNameInput" placeholder="Character name">
            </div>
            
            <div class="form-group" id="seriesGroup">
                <label for="seriesInput">Series:</label>
                <input type="text" name="series" id="seriesInput" placeholder="Series name">
            </div>
            
            <div class="form-group" id="nsfwGroup">
                <label>
                    <input type="checkbox" name="is_nsfw" value="1"> NSFW Content
                </label>
            </div>
            
            <button type="submit" class="btn">Upload</button>
        </form>
    </div>
    </main>
    <script>
    function toggleFields() {
        const table = document.getElementById("tableSelect").value;
        const linkGroup = document.getElementById("linkGroup");
        const descriptionGroup = document.getElementById("descriptionGroup");
        const characterNameGroup = document.getElementById("characterNameGroup");
        const seriesGroup = document.getElementById("seriesGroup");
        const nsfwGroup = document.getElementById("nsfwGroup");
        
        // Hide all optional fields first
        linkGroup.style.display = "none";
        descriptionGroup.style.display = "none";
        characterNameGroup.style.display = "none";
        seriesGroup.style.display = "none";
        nsfwGroup.style.display = "none";
        
        // Show relevant fields based on table selection
        switch(table) {
            case "buttons":
                linkGroup.style.display = "block";
                break;
            case "character_sprites":
                descriptionGroup.style.display = "block";
                characterNameGroup.style.display = "block";
                seriesGroup.style.display = "block";
                break;
            case "social_links":
                linkGroup.style.display = "block";
                nsfwGroup.style.display = "block";
                break;
        }
    }
    
    // Initialize on page load
    document.addEventListener("DOMContentLoaded", toggleFields);
    </script>
</body>
</html>
?>