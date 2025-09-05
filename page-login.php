<?php
// Processamento do login
$login_error = '';
$login_success = false;
$forgot_message = '';

// Processamento do login
if ($_POST && isset($_POST['log']) && isset($_POST['pwd'])) {
    // Verificar nonce
    if (!wp_verify_nonce($_POST['login_nonce'], 'custom_login_nonce')) {
        $login_error = 'Erro de segurança. Tente novamente.';
    } else {
        $creds = array(
            'user_login' => sanitize_text_field($_POST['log']),
            'user_password' => $_POST['pwd'],
            'remember' => isset($_POST['rememberme'])
        );
        
        $user = wp_signon($creds, is_ssl());
        
        if (is_wp_error($user)) {
            $error_code = $user->get_error_code();
            switch ($error_code) {
                case 'invalid_username':
                    $login_error = 'Usuário ou email não encontrado.';
                    break;
                case 'incorrect_password':
                    $login_error = 'Senha incorreta.';
                    break;
                case 'empty_username':
                    $login_error = 'Digite seu usuário ou email.';
                    break;
                case 'empty_password':
                    $login_error = 'Digite sua senha.';
                    break;
                default:
                    $login_error = $user->get_error_message();
            }
        } else {
            // Login bem-sucedido
            $login_success = true;
            
            // Determinar para onde redirecionar
            if (isset($_POST['redirect_to']) && !empty($_POST['redirect_to'])) {
                $redirect_to = $_POST['redirect_to'];
            } else {
                // Verificar se o usuário é admin ou tem acesso ao dashboard
                if (user_can($user->ID, 'manage_options') || user_can($user->ID, 'edit_posts')) {
                    $redirect_to = admin_url();
                } else {
                    // Para usuários comuns, redirecionar para a página inicial ou loja
                    $redirect_to = home_url();
                }
            }
            
            wp_redirect($redirect_to);
            exit;
        }
    }
}

// Processamento de "Esqueceu a senha?"
if ($_POST && isset($_POST['forgot_password'])) {
    if (!wp_verify_nonce($_POST['forgot_nonce'], 'custom_forgot_nonce')) {
        $forgot_message = 'Erro de segurança. Tente novamente.';
    } else {
        $user_login = sanitize_text_field($_POST['user_login']);
        
        if (empty($user_login)) {
            $forgot_message = 'Digite seu email ou nome de usuário.';
        } else {
            $user = get_user_by('login', $user_login);
            if (!$user) {
                $user = get_user_by('email', $user_login);
            }
            
            if ($user) {
                $key = get_password_reset_key($user);
                if (!is_wp_error($key)) {
                    $reset_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login');
                    
                    // Enviar email personalizado
                    $to = $user->user_email;
                    $subject = 'Recuperação de senha - ' . get_bloginfo('name');
                    $message = "Olá {$user->display_name},\n\n";
                    $message .= "Você solicitou a recuperação de sua senha.\n\n";
                    $message .= "Para redefinir sua senha, clique no link abaixo:\n";
                    $message .= $reset_link . "\n\n";
                    $message .= "Se você não solicitou esta recuperação, ignore este email.\n\n";
                    $message .= "Atenciosamente,\n" . get_bloginfo('name');
                    
                    $headers = array('Content-Type: text/plain; charset=UTF-8');
                    
                    if (wp_mail($to, $subject, $message, $headers)) {
                        $forgot_message = 'Link de recuperação enviado para seu email!';
                    } else {
                        $forgot_message = 'Erro ao enviar email. Tente novamente.';
                    }
                } else {
                    $forgot_message = 'Erro ao gerar link de recuperação. Tente novamente.';
                }
            } else {
                $forgot_message = 'Usuário ou email não encontrado.';
            }
        }
    }
}


?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/login/styles.css">
<!-- Main content -->
<main>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="container">
            <!-- Logo no topo da seção hero -->
            <div class="logo-container">
                <div class="dots-left">
                    <?php for ($i = 1; $i <= 26; $i++): ?>
                        <div class="dot dot-left-<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>
                
                <img src="<?php echo get_template_directory_uri(); ?>/login/logo.png" alt="Microware" class="logo">
                
                <div class="dots-right">
                    <?php for ($i = 1; $i <= 26; $i++): ?>
                        <div class="dot dot-right-<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="hero-grid">
                <!-- Left content - Login Form -->
                <div class="hero-content">
                    <div class="hero-text">
                        <h1 class="hero-title">
                            Seja bem-vindo a sua<br>
                            <span class="text-microware-red">loja de tecnologia</span><br>
                            <span class="text-microware-red">personalizada!</span>
                        </h1>
                    </div>

                    <!-- Login form -->
                    <div class="login-form">
                        <p class="hero-subtitle">
                            Sua jornada de compras de TI começa aqui. Faça login para continuar.
                        </p>
                        
                        <?php if ($login_error): ?>
                            <div class="login-error" style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffcdd2;">
                                <strong>Erro:</strong> <?php echo esc_html($login_error); ?>
                            </div>
                        <?php endif; ?>
                        

                        
                        <!-- Tab de Login -->
                        <div class="tab-content active" id="login-tab">
                            <form class="form" method="post" action="">
                                <?php wp_nonce_field('custom_login_nonce', 'login_nonce'); ?>
                                <?php if (isset($_GET['redirect_to'])): ?>
                                    <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_GET['redirect_to']); ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="user_login" class="form-label">Email</label>
                                    <input 
                                        id="user_login"
                                        name="log"
                                        type="text"
                                        class="form-input"
                                        placeholder="seu@email.com"
                                        value="<?php echo isset($_POST['log']) ? esc_attr($_POST['log']) : ''; ?>"
                                        required
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="user_pass" class="form-label">Senha</label>
                                    <input 
                                        id="user_pass"
                                        name="pwd"
                                        type="password"
                                        class="form-input"
                                        placeholder="••••••••"
                                        required
                                    >
                                </div>
                                
                                <div class="form-footer">
                                <a href="#" class="forgot-password" id="show-forgot-form" style="color: white; text-decoration: none; margin-bottom: 15px; display: block;">
                                    Esqueceu a senha?
                                </a>
                                <button type="submit" class="btn-login">
                                    Entrar
                                </button>
                            </div>
                            </form>
                        </div>
                        
                        <!-- Tab de Esqueceu a senha -->
                        <div class="tab-content" id="forgot-tab" style="display: none;">
                            <?php if ($forgot_message): ?>
                                <div class="forgot-message" style="background: <?php echo strpos($forgot_message, 'sucesso') !== false ? '#e8f5e8' : '#fff3cd'; ?>; color: <?php echo strpos($forgot_message, 'sucesso') !== false ? '#2e7d32' : '#856404'; ?>; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid <?php echo strpos($forgot_message, 'sucesso') !== false ? '#c8e6c9' : '#ffeaa7'; ?>;">
                                    <?php echo esc_html($forgot_message); ?>
                                </div>
                            <?php endif; ?>
                            
                            <form class="form" method="post" action="">
                                <?php wp_nonce_field('custom_forgot_nonce', 'forgot_nonce'); ?>
                                <div class="form-group" style="display: flex; flex-direction: column; margin-bottom: 20px;">
                                    <label for="forgot_email" class="form-label" style="display: block; margin-bottom: 8px; color: white; font-weight: 500; text-align: left;">Email ou nome de usuário</label>
                                    <input 
                                        id="forgot_email"
                                        name="user_login"
                                        type="text"
                                        class="form-input"
                                        placeholder="seu@email.com"
                                        value="<?php echo isset($_POST['user_login']) ? esc_attr($_POST['user_login']) : ''; ?>"
                                        required
                                        style="width: 100%; box-sizing: border-box;"
                                    >
                                </div>
                                <div class="form-footer">
                                    <a href="#" class="back-to-login" id="show-login-form" style="color: white; text-decoration: none; margin-bottom: 15px; display: block;">
                                        ← Voltar ao login
                                    </a>
                                    <button type="submit" name="forgot_password" class="btn-login" style="padding: 12px 24px; font-size: 14px; min-width: auto;">
                                        Enviar link de recuperação
                                    </button>
                                </div>
                            </form>
                        </div>
                        

                    </div>
                </div>

                <!-- Right content - Hero Image -->
                <div>
                <div class="hero-image-container">
                    <div class="hero-image-wrapper">
                        <video 
                            class="hero-image" 
                            autoplay 
                            muted 
                            loop 
                            playsinline
                            style="width: 100%; height: 120%; object-fit: cover; border-radius: inherit;"
                        >
                            <source src="<?php echo get_template_directory_uri(); ?>/login/video_webpage_01_handbrake_107.mp4" type="video/mp4">
                            <!-- Fallback para a imagem caso o vídeo não carregue -->
                            <img src="<?php echo get_template_directory_uri(); ?>/login/hero-woman.jpg" alt="Mulher usando tecnologia" style="width: 100%; height: 100%; object-fit: cover;">
                        </video>
                    </div>
                </div>
                <p class="hero-image-text">
                    <span class="text-bold">Tecnologia sob medida</span><br>
                    para sua operação
                </p>
              </div>


            </div>
            
            <!-- Scroll Down Indicator -->
            <div class="scroll-indicator">
                <div class="scroll-arrow">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 13l5 5 5-5"/>
                        <path d="M7 6l5 5 5-5"/>
                    </svg>
                </div>
                <span class="scroll-text">Role para baixo</span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                       <img src="<?php echo get_template_directory_uri(); ?>/login/icons/1.png" alt="Padronização Segura e Inteligente" class="feature-icon-image">
                    </div>
                    <h3 class="feature-title">Padronização<br>Segura e Inteligente</h3>
                    <p class="feature-description">Sua equipe só vê o que <br> foi aprovado. Nada fora <br>do padrão, nenhum <br>risco na compra.</p> 
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/login/icons/2.png" alt="Comunicação Interna" class="feature-icon-image">
                    </div>
                    <h3 class="feature-title">Comunicação<br>Interna</h3>
                    <p class="feature-description">Agilize os processos entre<br>áreas com um ambiente <br>exclusivo e alinhado às <br>diretrizes da empresa.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                       <img src="<?php echo get_template_directory_uri(); ?>/login/icons/3.png" alt="Gestão centralizada" class="feature-icon-image">
                    </div>
                    <h3 class="feature-title">Gestão<br>Centralizada</h3>
                    <p class="feature-description">Todas as solicitações em <br>um só lugar. Menos ruído,<br>mais controle, mais <br>agilidade pra quem aprova.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Future Section -->
    <section class="future-section">
        <div class="future-background"></div>
        <div class="container">
            <div class="future-content">
                <h2 class="future-title">
                    O Futuro da Aquisição <br>de Produtos de TI
                    <span class="text-bold"><br>Começa Aqui.</span>
                </h2>
                
                <div class="future-badge-container">
                    <div class="future-text-content">
                        <p class="future-subtitle">
                            Com a sua loja exclusiva, sua empresa tem acesso a uma vitrine inteligente 
                            de TI, com <span class="text-white-bold">curadoria, segurança e controle</span>.
                        </p>

                        <div class="future-benefits">
                            <div class="benefit-item">
                                <div class="benefit-check">
                                    <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20,6 9,17 4,12"/>
                                    </svg>
                                </div>
                                <p class="benefit-text">
                                    Tenha acesso aos produtos disponibilizados pela sua empresa, 
                                    com condições pré-aprovadas e <span class="text-white">alinhadas às suas políticas internas</span>
                                </p>
                            </div>
                            
                            <div class="benefit-item">
                                <div class="benefit-check">
                                    <svg class="check-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="20,6 9,17 4,12"/>
                                    </svg>
                                </div>
                                <p class="benefit-text">
                                    <span class="text-white-bold">Quer mais opções?</span> Entre em<br>
                                    contato conosco e ajustamos a loja <br> conforme suas necessidades.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="exclusive-badge">
                       <img src="<?php echo get_template_directory_uri(); ?>/login/icons/6.png" alt="Exclusivo para clientes Microware" class="badge-icon">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">
                Comece agora a equipar seu time <br> com
                <span class="text-bold">o melhor da tecnologia.</span>
            </h2>
            
            <button class="btn-cta">
                Quero a minha loja!
            </button>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginTab = document.getElementById('login-tab');
    const forgotTab = document.getElementById('forgot-tab');
    const showForgotForm = document.getElementById('show-forgot-form');
    const showLoginForm = document.getElementById('show-login-form');
    
    // Função para mostrar formulário de recuperação
    function showForgotPassword() {
        loginTab.style.display = 'none';
        forgotTab.style.display = 'block';
    }
    
    // Função para voltar ao login
    function showLogin() {
        forgotTab.style.display = 'none';
        loginTab.style.display = 'block';
    }
    
    // Event listeners
    if (showForgotForm) {
        showForgotForm.addEventListener('click', function(e) {
            e.preventDefault();
            showForgotPassword();
        });
    }
    
    if (showLoginForm) {
        showLoginForm.addEventListener('click', function(e) {
            e.preventDefault();
            showLogin();
        });
    }
    
    // Verificar se há mensagens de recuperação para mostrar o formulário correto
    <?php if ($forgot_message): ?>
        showForgotPassword();
    <?php endif; ?>
    
    // Scroll Indicator Control
    const scrollIndicator = document.querySelector('.scroll-indicator');
    
    if (scrollIndicator) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                scrollIndicator.style.opacity = '0';
                scrollIndicator.style.pointerEvents = 'none';
            } else {
                scrollIndicator.style.opacity = '1';
                scrollIndicator.style.pointerEvents = 'auto';
            }
        });
        
        // Smooth scroll ao clicar no indicador
        scrollIndicator.addEventListener('click', function() {
            const featuresSection = document.querySelector('.features-section');
            if (featuresSection) {
                featuresSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
});
</script>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="#" class="footer-link">Termos de Uso</a>
                <span class="footer-separator">|</span>
                <a href="#" class="footer-link">Política de Privacidade</a>
            </div>
        </div>
    </footer>
