<?php
// Conferir disponibilidade da Weather_API
if ( ! class_exists( 'Weather_API' ) ) {
    include_once WP_PLUGIN_DIR . '/weather-info-plugin/includes/class-weather-api.php';
}

// Obter clima
function get_weather_info( $latitude, $longitude ) {
    $options = get_option( 'wip_settings' );
    $api_key = isset( $options['wip_text_field_0'] ) ? $options['wip_text_field_0'] : '';

    if ( empty( $api_key ) ) {
        return 'API Key não configurada.';
    } else {
        $weather_api = new Weather_API( $api_key );
        return $weather_api->get_weather( $latitude, $longitude );
    }
}

// Obter previsão do tempo
function get_weather_forecast( $latitude, $longitude ) {
    $options = get_option( 'wip_settings' );
    $api_key = isset( $options['wip_text_field_0'] ) ? $options['wip_text_field_0'] : '';

    if ( empty( $api_key ) ) {
        return 'API Key não configurada.';
    } else {
        $weather_api = new Weather_API( $api_key );
        $forecast = $weather_api->get_forecast( $latitude, $longitude );

        if ( is_wp_error( $forecast ) || empty( $forecast ) ) {
            return 'Erro ao obter a previsão do tempo.';
        }

        return $forecast;
    }
}
?>
