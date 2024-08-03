<?php
// Enfileirar estilos e scripts
function weather_info_theme_enqueue_styles() {
    wp_enqueue_style( 'weather-info-theme-style', get_template_directory_uri() . '/assets/css/style.css' );
    wp_enqueue_script( 'weather-info-theme-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'weather_info_theme_enqueue_styles' );

// Incluir funções do tema
require get_template_directory() . '/includes/weather-template-functions.php';

// Ocultar a barra do WordPress
function weather_info_hide_admin_bar() {
    if ( current_user_can( 'subscriber' ) && !is_admin() ) {
        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'weather_info_hide_admin_bar' );
?>
