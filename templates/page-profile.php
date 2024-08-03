<?php
/* Template Name: Profile Page */

get_header();

if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    // Processar atualização de perfil
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['action'] ) && $_POST['action'] === 'update' ) {
        $errors = [];

        $email = sanitize_email( $_POST['user_email'] );
        $cep = sanitize_text_field( $_POST['cep'] );
        $address = sanitize_text_field( $_POST['address'] );
        $number = sanitize_text_field( $_POST['number'] );
        $neighborhood = sanitize_text_field( $_POST['neighborhood'] );
        $city = sanitize_text_field( $_POST['city'] );
        $state = sanitize_text_field( $_POST['state'] );
        $latitude = sanitize_text_field( $_POST['latitude'] );
        $longitude = sanitize_text_field( $_POST['longitude'] );

        if ( empty( $email ) || empty( $cep ) || empty( $address ) || empty( $city ) || empty( $state ) ) {
            $errors[] = 'Todos os campos são obrigatórios.';
        }

        if ( empty( $errors ) ) {
            wp_update_user([
                'ID' => $user_id,
                'user_email' => $email
            ]);

            update_user_meta( $user_id, 'cep', $cep );
            update_user_meta( $user_id, 'address', $address );
            update_user_meta( $user_id, 'number', $number );
            update_user_meta( $user_id, 'neighborhood', $neighborhood );
            update_user_meta( $user_id, 'city', $city );
            update_user_meta( $user_id, 'state', $state );
            update_user_meta( $user_id, 'latitude', $latitude );
            update_user_meta( $user_id, 'longitude', $longitude );

            echo '<div class="alert alert-success">Perfil atualizado com sucesso.</div>';
        }
    }
    ?>

    <section class="title">
        <h1>Olá, <?php echo esc_html( get_user_meta( $user_id, 'first_name', true ) ); ?>!</h1>
        <p><a href="<?php echo esc_html(wp_logout_url('/perfil'));?>">Logout</a></p>
    </section>

    <h2>Atualizar dados</h2>
    <p>Mantenha seu endereço atualizado para conferir a previsão do tempo.</p>
    <?php if ( isset( $errors ) && ! empty( $errors ) ): ?>
        <div class="alert alert-danger">
            <?php foreach ( $errors as $error ): ?>
                <span><?php echo $error; ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="user_email">E-mail</label>
            <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo esc_attr( $current_user->user_email ); ?>" required>
        </div>
        <div class="form-group">
            <label for="cep">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" value="<?php echo esc_attr( get_user_meta( $user_id, 'cep', true ) ); ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Endereço</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo esc_attr( get_user_meta( $user_id, 'address', true ) ); ?>" required>
        </div>
        <div class="form-group">
            <label for="number">Número</label>
            <input type="number" class="form-control" id="number" name="number" value="<?php echo esc_attr( get_user_meta( $user_id, 'number', true ) ); ?>">
        </div>
        <div class="form-group">
            <label for="neighborhood">Bairro</label>
            <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="<?php echo esc_attr( get_user_meta( $user_id, 'neighborhood', true ) ); ?>">
        </div>
        <div class="form-group">
            <label for="city">Cidade</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo esc_attr( get_user_meta( $user_id, 'city', true ) ); ?>" required>
        </div>
        <div class="form-group">
            <label for="state">Estado</label>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo esc_attr( get_user_meta( $user_id, 'state', true ) ); ?>" required>
        </div>
        <input type="hidden" name="latitude" id="latitude" value="<?php echo esc_attr( get_user_meta( $user_id, 'latitude', true ) ); ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?php echo esc_attr( get_user_meta( $user_id, 'longitude', true ) ); ?>">
        <input type="hidden" name="action" value="update">
        <button type="submit" class="mt-5 btn btn-primary btn-lg w-100 text-white">Salvar</button>
    </form>

    <?php
} else {
    // Processar formulário de registro
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['action'] ) && $_POST['action'] === 'register' ) {
        $errors = [];

        $name = sanitize_text_field($_POST['user_name']);
        $email = sanitize_email( $_POST['user_email'] );
        $password = esc_attr( $_POST['user_pass'] );
        $cep = sanitize_text_field( $_POST['cep'] );
        $address = sanitize_text_field( $_POST['address'] );
        $number = sanitize_text_field( $_POST['number'] );
        $neighborhood = sanitize_text_field( $_POST['neighborhood'] );
        $city = sanitize_text_field( $_POST['city'] );
        $state = sanitize_text_field( $_POST['state'] );
        $latitude = sanitize_text_field( $_POST['latitude'] );
        $longitude = sanitize_text_field( $_POST['longitude'] );

        $username = $email;

        if ( empty( $username ) || empty( $name ) || empty( $email ) || empty( $password ) || empty( $cep ) || empty( $address ) || empty( $city ) || empty( $state ) ) {
            $errors[] = 'Todos os campos são obrigatórios.';
        }

        if ( empty( $errors ) ) {
            $userdata = [
                'user_login' => $username,
                'user_email' => $email,
                'user_pass' => $password,
                'first_name' => $name,
                'role' => 'subscriber'
            ];
            $user_id = wp_insert_user( $userdata );

            if ( is_wp_error( $user_id ) ) {
                $errors[] = $user_id->get_error_message();
            } else {
                update_user_meta( $user_id, 'cep', $cep );
                update_user_meta( $user_id, 'address', $address );
                update_user_meta( $user_id, 'number', $number );
                update_user_meta( $user_id, 'neighborhood', $neighborhood );
                update_user_meta( $user_id, 'city', $city );
                update_user_meta( $user_id, 'state', $state );
                update_user_meta( $user_id, 'latitude', $latitude );
                update_user_meta( $user_id, 'longitude', $longitude );

                wp_set_current_user( $user_id );
                wp_set_auth_cookie( $user_id );

                wp_redirect( home_url('/tempo') );
                exit;
            }
        }
    }

    // Processar formulário de login
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['action'] ) && $_POST['action'] === 'login' ) {
        $username = sanitize_user( $_POST['log'] );
        $password = esc_attr( $_POST['pwd'] );

        $creds = [
            'user_login' => $username,
            'user_password' => $password,
            'remember' => true
        ];

        $user = wp_signon( $creds, false );

        if ( is_wp_error( $user ) ) {
            $errors[] = $user->get_error_message();
        } else {
            wp_redirect( home_url('/tempo') );
            exit;
        }
    }
    ?>

    <div class="row">
        <div class="col-md-6">
            <h2>Login</h2>
            <?php if ( isset( $errors ) && ! empty( $errors ) && $_POST['action'] === 'login' ): ?>
                <div class="alert alert-danger">
                    <?php foreach ( $errors as $error ): ?>
                        <span><?php echo $error; ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="log">Nome de Usuário ou E-mail</label>
                    <input type="text" class="form-control" id="log" name="log" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Senha</label>
                    <input type="password" class="form-control" id="pwd" name="pwd" required>
                </div>
                <input type="hidden" name="action" value="login">
                <button type="submit" class="mt-5 btn btn-primary btn-lg w-100 text-white">Login</button>
            </form>
        </div>
        <div class="mt-5 mt-md-0 col-md-6">
            <h2>Registrar</h2>
            <?php if ( isset( $errors ) && ! empty( $errors ) && $_POST['action'] === 'register' ): ?>
                <div class="alert alert-danger">
                    <?php foreach ( $errors as $error ): ?>
                        <span><?php echo $error; ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_name">Nome</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" required>
                </div>
                <div class="form-group">
                    <label for="user_email">E-mail</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" required>
                </div>
                <div class="form-group">
                    <label for="user_pass">Senha</label>
                    <input type="password" class="form-control" id="user_pass" name="user_pass" required>
                </div>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" required>
                </div>
                <div class="form-group">
                    <label for="address">Endereço</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="number">Número</label>
                    <input type="number" class="form-control" id="number" name="number">
                </div>
                <div class="form-group">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" class="form-control" id="neighborhood" name="neighborhood">
                </div>
                <div class="form-group">
                    <label for="city">Cidade</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="state">Estado</label>
                    <input type="text" class="form-control" id="state" name="state" required>
                </div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="action" value="register">
                <button type="submit" class="mt-5 btn btn-secondary btn-lg w-100 text-white">Registrar</button>
            </form>
        </div>
    </div>

    <?php
}

wp_enqueue_script( 'weather-info-js-admin', site_url( '/wp-content/plugins/Weather-Info-for-WordPress/assets/js/weather-info.js' ), array('jquery'), null, true );

get_footer();
