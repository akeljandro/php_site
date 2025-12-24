<?php
include_once 'admin/auth.php';

function renderNavigation() {
    $current_page = '/' . ltrim($_SERVER['PHP_SELF'], '/');
    // Debug: uncomment to see the actual value
    // error_log("PHP_SELF: " . $_SERVER['PHP_SELF']);
    // error_log("Current page: " . $current_page);
    
    $nav_items = [
        '/index.php' => 'Inicio',
        '/about.php' => 'Sobre Mi',
        '/galeria.php' => 'Galería', 
        '/contact.php' => 'Contacto'
    ];
    
    if (isLoggedIn()) {
        unset($nav_items['login.php']);
        $nav_items['/admin/dibujos_guardados.php'] = 'Dibujos guardados';
        $nav_items['/admin/mensajes.php'] = 'Mensajes';
        $nav_items['/admin/upload.php'] = 'Subir dibujo';
    }
    
    echo '<nav>';
    foreach ($nav_items as $page => $title) {
        $class = ($current_page === $page) ? 'active' : '';
        echo '<a href="' . $page . '" class="' . $class . '">' . $title . '</a>';
    }
    echo '</nav>';
}
?>
