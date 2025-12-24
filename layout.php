<?php
include_once 'auth.php';

function renderNavigation() {
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $nav_items = [
        'index.php' => 'Inicio',
        'about.php' => 'Sobre Mi',
        'galeria.php' => 'Galería', 
        'contact.php' => 'Contacto'
    ];
    
    if (isLoggedIn()) {
        unset($nav_items['login.php']);
        $nav_items['dibujos_guardados.php'] = 'Dibujos guardados';
        $nav_items['mensajes.php'] = 'Mensajes';
    }
    
    echo '<nav>';
    foreach ($nav_items as $page => $title) {
        $class = ($current_page === $page) ? 'active' : '';
        echo '<a href="' . $page . '" class="' . $class . '">' . $title . '</a>';
    }
    echo '</nav>';
}
?>
