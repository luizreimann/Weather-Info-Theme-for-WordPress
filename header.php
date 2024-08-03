<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' );?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="bg-primary py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0"><?php bloginfo( 'name' ); ?></h1>
            <nav class="d-flex">
                <a class="nav-link mx-3" href="<?php echo home_url('/tempo'); ?>">Início</a>
                <a class="nav-link" href="<?php echo home_url('/perfil'); ?>">Perfil</a>
            </nav>
        </div>
    </header>
    <main class="container my-5">
