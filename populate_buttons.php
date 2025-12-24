<?php
// Populate buttons table with image files
// This script reads image files and inserts them into the database

require_once 'admin/database.php';

$buttons_dir = '/img/buttons/';
$buttons_data = [
    'boypussy' => ['file' => 'boypussy.gif', 'url' => 'https://boypussy.neocities.org/'],
    'doqmeat' => ['file' => 'doqmeat.png', 'url' => 'https://doqmeat.com/'],
    'Leirin' => ['file' => 'fzbanner1.png', 'url' => 'https://leirin.neocities.org/'],
    'Meriamelie' => ['file' => 'heart-soda.gif', 'url' => 'https://meriamelie.neocities.org/'],
    'HumanFinny' => ['file' => 'humanfinny.gif', 'url' => 'https://humanfinny.neocities.org/'],
    'Lars From Mars' => ['file' => 'lars.png', 'url' => 'https://larsfrommars.neocities.org/'],
    'Norisowl' => ['file' => 'norisowl_button_face.png', 'url' => 'https://norisowl.neocities.org/'],
    'SuperKirbyLover' => ['file' => 'superkirbylover.gif', 'url' => 'https://superkirbylover.me/'],
    'Whimsical' => ['file' => 'whimsical.gif', 'url' => 'http://whimsical.heartette.net/'],
    'Xiokka' => ['file' => 'xiokka.png', 'url' => 'https://xiokka.neocities.org/']
];

try {
    $pdo = getDatabaseConnection();
    
    echo "<h2>Populating Buttons Table</h2>";
    echo "<p>Reading image files and inserting into database...</p>";
    
    $inserted = 0;
    $errors = [];
    
    foreach ($buttons_data as $name => $data) {
        $file_path = $buttons_dir . $data['file'];
        
        if (!file_exists($file_path)) {
            $errors[] = "File not found: $file_path";
            continue;
        }
        
        $image_data = file_get_contents($file_path);
        if ($image_data === false) {
            $errors[] = "Failed to read file: $file_path";
            continue;
        }
        
        try {
            $stmt = $pdo->prepare("INSERT IGNORE INTO buttons (name, image_data, link) VALUES (?, ?, ?)");
            $result = $stmt->execute([$name, $image_data, $data['url']]);
            
            if ($result) {
                $inserted++;
                echo "<p style='color: green;'>✓ Inserted: $name</p>";
            } else {
                $errors[] = "Failed to insert: $name";
            }
        } catch(PDOException $e) {
            $errors[] = "Database error for $name: " . $e->getMessage();
        }
    }
    
    echo "<h3>Summary:</h3>";
    echo "<p>Successfully inserted: $inserted buttons</p>";
    
    if (!empty($errors)) {
        echo "<h3>Errors:</h3>";
        foreach ($errors as $error) {
            echo "<p style='color: red;'>✗ $error</p>";
        }
    }
    
    // Verify the data
    echo "<h3>Current buttons in database:</h3>";
    $stmt = $pdo->query("SELECT name, LENGTH(image_data) as image_size, link FROM buttons");
    $buttons = $stmt->fetchAll();
    
    if (empty($buttons)) {
        echo "<p>No buttons found in database.</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Name</th><th>Image Size</th><th>Link</th></tr>";
        foreach ($buttons as $button) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($button['name']) . "</td>";
            echo "<td>" . $button['image_size'] . " bytes</td>";
            echo "<td>" . htmlspecialchars($button['link']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
} catch(Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
