<?php
/* Template Name: Login Simples */

// Processar o formulário de login
if ($_POST['action'] == 'login') {
    $username = sanitize_text_field($_POST['username']);
    $password = $_POST['password'];
    
    $user = wp_authenticate($username, $password);
    
    if (is_wp_error($user)) {
        $error_message = 'Usuário ou senha incorretos.';
    } else {
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        
        // Redirecionar para a página inicial ou dashboard
        $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : home_url();
        wp_redirect($redirect_to);
        exit;
    }
}

// Processar logout
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    wp_logout();
    $success_message = 'Logout realizado com sucesso!';
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #181c24;
            font-family: Arial, sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: #232837;
            padding: 2rem;
            box-shadow: 0 0 24px rgba(0,0,0,0.25);
            border-radius: 16px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #fff;
        }

        .error-message {
            background: #dc2626;
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .success-message {
            background: #059669;
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        input[type="email"], input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 1rem;
            border: 1px solid #2e3448;
            border-radius: 8px;
            background: #181c24;
            color: #fff;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="email"]:focus, input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #4f8cff;
            box-shadow: 0 0 0 2px rgba(79, 140, 255, 0.2);
        }

        button, input[type="submit"] {
            background-color: #4f8cff;
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            width: 100%;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            margin-bottom: 10px;
            transition: background 0.2s;
        }

        button:hover, input[type="submit"]:hover {
            background: #2563eb;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #fff;
            font-weight: 500;
        }

        .links {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #2e3448;
        }

        .links a {
            color: #4f8cff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .passwordless-message {
            margin-top: 1rem;
            color: green;
        }

        #woofc-count {
            display: none !important;
        }

    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Entrar</h2>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (!is_user_logged_in()): ?>
            <form method="post" action="">
                <input type="hidden" name="action" value="login">
                <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>">
                
                <div class="form-group">
                    <label for="username">Usuário ou E-mail</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <input type="submit" value="Entrar">
            </form>
            
            <div class="links">
                <a href="<?php echo wp_lostpassword_url(); ?>">Esqueceu sua senha?</a><br>
                <a href="<?php echo wp_registration_url(); ?>">Criar conta</a>
            </div>
        <?php else: ?>
            <p style="color: #fff; margin-bottom: 1rem;">
                Olá, <?php echo wp_get_current_user()->display_name; ?>!
            </p>
            <a href="<?php echo wp_logout_url(home_url()); ?>" class="button">Sair</a>
        <?php endif; ?>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>

