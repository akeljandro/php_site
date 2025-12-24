<?php
// generate_buttons_sql.php
$buttons = [
    ['boypussy', 'img/buttons/boypussy.gif', 'https://boypussy.neocities.org/'],
    ['doqmeat', 'img/buttons/doqmeat.png', 'https://doqmeat.com/'],
    ['Leirin', 'img/buttons/fzbanner1.png', 'https://leirin.neocities.org/'],
    ['Meriamelie', 'img/buttons/heart-soda.gif', 'https://meriamelie.neocities.org/'],
    ['HumanFinny', 'img/buttons/humanfinny.gif', 'https://humanfinny.neocities.org/'],
    ['Lars From Mars', 'img/buttons/lars.png', 'https://larsfrommars.neocities.org/'],
    ['Norisowl', 'img/buttons/norisowl_button_face.png', 'https://norisowl.neocities.org/'],
    ['SuperKirbyLover', 'img/buttons/superkirbylover.gif', 'https://superkirbylover.me/'],
    ['Whimsical', 'img/buttons/whimsical.gif', 'http://whimsical.heartette.net/'],
    ['Xiokka', 'img/buttons/xiokka.png', 'https://xiokka.neocities.org/']
];

$output = "-- Button Data SQL\n";
$output .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
$output .= "TRUNCATE TABLE buttons;\n\n";

foreach ($buttons as $button) {
    if (file_exists($button[1])) {
        $base64 = base64_encode(file_get_contents($button[1]));
        $output .= "INSERT INTO buttons (name, image_data, link) VALUES (\n";
        $output .= "    '" . addslashes($button[0]) . "',\n";
        $output .= "    FROM_BASE64('" . $base64 . "'),\n";
        $output .= "    '" . addslashes($button[2]) . "'\n";
        $output .= ");\n\n";
    } else {
        echo "Warning: File not found: {$button[1]}\n";
    }
}

// Save to file
file_put_contents('buttons_data.sql', $output);
echo "SQL file generated: buttons_data.sql\n";