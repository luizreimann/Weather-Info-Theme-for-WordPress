<?php
/* Template Name: Weather Page */

if ( ! is_user_logged_in() ) {
    wp_redirect( home_url('/perfil') );
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// Obter latitude e longitude
$latitude = get_user_meta( $user_id, 'latitude', true );
$longitude = get_user_meta( $user_id, 'longitude', true );

// Verificar latitude e longitude
if ( empty( $latitude ) || empty( $longitude ) ) {
    echo '<p>Latitude e longitude não cadastradas. Por favor, atualize seu perfil.</p>';
    get_footer();
    exit;
}

// Obter dados da API
$current_weather = get_weather_info( $latitude, $longitude );
$forecast = get_weather_forecast( $latitude, $longitude );

?>

<section class="title">
    <h1>Olá, <?php echo esc_html( get_user_meta( $user_id, 'first_name', true ) ); ?>!</h1>
    <p>Confira o clima para <?php echo esc_html( $current_weather['name'] ); ?>.</p>
</section>

<?php
// Clima atual
if ( is_array( $current_weather ) && isset( $current_weather['main'] ) ) :
    ?>
    <section class="current-weather pt-5">
        <div class="row">
            <div class="col-md-2 text-center">
                <img src="http://openweathermap.org/img/w/<?php echo esc_attr( $current_weather['weather'][0]['icon'] ); ?>.png" alt="Weather Icon" class="w-50">
            </div>
            <div class="col-md-10 text-center text-md-left text-md-start">
                <h2 class="text-capitalize"><?php echo esc_html( $current_weather['weather'][0]['description'] ); ?></h2>
                <p>Temperatura: <?php echo esc_html( $current_weather['main']['temp'] ); ?>°C</p>
                <p>Sensação Térmica: <?php echo esc_html( $current_weather['main']['feels_like'] ); ?>°C</p>
                <p>Umidade do ar: <?php 
                    $humidity = $current_weather['main']['humidity'];
                    echo esc_html($humidity) . "%"; 
                    echo " (" . ($humidity < 30 ? "baixo" : ($humidity <= 60 ? "moderado" : "alto")) . ")";
                ?></p>
                <p>Visibilidade: <?php 
                    $visibility_meters = $current_weather['visibility'];
                    $visibility_kilometers = $visibility_meters / 1000;
                    echo esc_html(number_format($visibility_kilometers, 2)); 
                ?> km</p>
            </div>
        </div>
    </section>
    <?php
else :
    echo '<p>Não foi possível obter os dados climáticos atuais.</p>';
endif;

// Previsão do tempo
if ( is_array( $forecast ) && isset( $forecast['list'] ) ) :
    ?>
    <section class="forecast pt-5">
        <h3>Previsão para os próximos 5 dias</h3>
        <div class="row mt-3">
            <?php 
            for ( $i = 0; $i < 5; $i++ ) :
                $index = $i * 8 + 4; // Ajustar previsão exibida para às 12:00
                if ( isset( $forecast['list'][$index] ) ) :
                    $day_forecast = $forecast['list'][$index];
                    $date = date( 'D', $day_forecast['dt'] );
                    ?>
                    <div class="col text-center mb-2">
                        <div class="card p-3">
                            <h4><?php echo esc_html( $date ); ?></h4>
                            <img src="http://openweathermap.org/img/w/<?php echo esc_attr( $day_forecast['weather'][0]['icon'] ); ?>.png" alt="Weather Icon">
                            <p><?php echo esc_html( $day_forecast['main']['temp'] ); ?>°C</p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </section>
    <?php
else :
    echo '<p>Não foi possível obter a previsão do tempo.</p>';
endif;

get_footer();