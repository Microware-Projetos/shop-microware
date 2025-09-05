<?php
if ( ! function_exists( 'storebiz_setup' ) ) :
    function storebiz_setup() {
 
/**
 * Define Constants
 */
 
// Root path/URI.
define( 'STOREBIZ_PARENT_DIR', get_template_directory() );
define( 'STOREBIZ_PARENT_URI', get_template_directory_uri() );
 
// Root path/URI.
define( 'STOREBIZ_PARENT_INC_DIR', STOREBIZ_PARENT_DIR . '/inc');
define( 'STOREBIZ_PARENT_INC_URI', STOREBIZ_PARENT_URI . '/inc');
 
    // Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );
 
    /*
     * Let WordPress manage the document title.
     */
    add_theme_support( 'title-tag' );
   
    add_theme_support( 'custom-header' );
   
    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );
   
    //Add selective refresh for sidebar widget
    add_theme_support( 'customize-selective-refresh-widgets' );
   
    /*
     * Make theme available for translation.
     */
    load_theme_textdomain( 'storebiz' );
 
    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary_menu' => esc_html__( 'Primary Menu', 'storebiz' ),
    ) );
 
    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
   
    add_theme_support('custom-logo');
 
    /*
     * WooCommerce Plugin Support
     */
    add_theme_support( 'woocommerce' );
   
    // Gutenberg wide images.
    add_theme_support( 'align-wide' );
   
    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, icons, and column width.
     */
    add_editor_style( array( 'assets/css/editor-style.css', storebiz_google_font() ) );
   
    //Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'storebiz_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );
}
endif;
add_action( 'after_setup_theme', 'storebiz_setup' );
 
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function storebiz_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'storebiz_content_width', 1170 );
}
add_action( 'after_setup_theme', 'storebiz_content_width', 0 );
 
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
 
function storebiz_widgets_init() {
   
    register_sidebar( array(
        'name' => esc_html__( 'Header Right Widget Area', 'storebiz' ),
        'id' => 'storebiz-header-right',
        'description'  => esc_html__( 'Header Right Widget', 'storebiz' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ) );
   
    register_sidebar( array(
        'name' => esc_html__( 'Sidebar Widget Area', 'storebiz' ),
        'id'   => 'storebiz-sidebar-primary',
        'description'  => esc_html__( 'The Primary Widget Area', 'storebiz' ),
        'before_widget'=> '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget-title">',
        'after_title'  => '</h5>',
    ) );
   
    // Comentado porque agora temos um footer fixo
    /*
    register_sidebar( array(
        'name' => esc_html__( 'Footer Widget Area', 'storebiz' ),
        'id'   => 'storebiz-footer-widget-area',
        'description'  => esc_html__( 'The Footer Widget Area', 'storebiz' ),
        'before_widget'=> '<div class="col wow fadeInUp"><aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h5 class="widget-title">',
        'after_title'  => '</h5>',
    ) );
    */
 
    register_sidebar( array(
        'name' => esc_html__( 'WooCommerce Widget Area', 'storebiz' ),
        'id' => 'storebiz-woocommerce-sidebar',
        'description' => esc_html__( 'This Widget area for WooCommerce Widget', 'storebiz' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ) );
}
add_action( 'widgets_init', 'storebiz_widgets_init' );
 
/**
 * All Styles & Scripts.
 */
require_once get_template_directory() . '/inc/enqueue.php';
 
/**
 * Nav Walker fo Bootstrap Dropdown Menu.
 */
 
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
 
/**
 * Implement the Custom Header feature.
 */
require_once get_template_directory() . '/inc/custom-header.php';
 
/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';
 
/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/extras.php';
 
/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/storebiz-customizer.php';

/**
 * Carrega todas as funcionalidades personalizadas
 */
require_once get_template_directory() . '/custom-functions/loader.php';

/**
 * Função para verificar e configurar loja associada ao usuário
 */
function verificar_loja_usuario($user_id) {
    $loja_associada = get_user_meta($user_id, 'loja_associada', true);
    
    // Se não tiver loja associada, vamos verificar outros campos possíveis
    if (empty($loja_associada)) {
        // Verifica outros campos que podem conter a loja
        $possiveis_campos = ['loja', 'store', 'empresa', 'company', 'filial'];
        
        foreach ($possiveis_campos as $campo) {
            $valor = get_user_meta($user_id, $campo, true);
            if (!empty($valor)) {
                update_user_meta($user_id, 'loja_associada', $valor);
                return $valor;
            }
        }
        
        // Se ainda não encontrou, vamos usar o email do usuário para identificar
        $user = get_userdata($user_id);
        if ($user) {
            $email = $user->user_email;
            $username = $user->user_login;
            
            // Mapeamento manual de emails/usuários para lojas específicas
            $mapeamento_lojas = [
                'microware.com.br' => 'microware',
                'admin@microware.com.br' => 'microware',
                'admin' => 'microware',
                // Adicione mais mapeamentos conforme necessário
            ];
            
            // Verifica se existe mapeamento específico
            if (isset($mapeamento_lojas[$email])) {
                $nome_loja = $mapeamento_lojas[$email];
            } elseif (isset($mapeamento_lojas[$username])) {
                $nome_loja = $mapeamento_lojas[$username];
            } else {
                // Extrai apenas o nome da loja do email (parte antes do @)
                $nome_loja = explode('@', $email)[0] ?? 'default';
                
                // Remove números e caracteres especiais, mantém apenas letras
                $nome_loja = preg_replace('/[^a-zA-Z]/', '', $nome_loja);
                
                // Se ficou vazio, usa 'loja' como padrão
                if (empty($nome_loja)) {
                    $nome_loja = 'loja';
                }
            }
            
            update_user_meta($user_id, 'loja_associada', $nome_loja);
            return $nome_loja;
        }
    }
    
    return $loja_associada;
}

add_action('template_redirect', function () {
    $current_path = untrailingslashit(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $user_id = get_current_user_id();
    $current_blog_id = get_current_blog_id();

    $user = wp_get_current_user();
    $is_super_admin = is_super_admin($user_id);
    $is_admin_user = in_array('administrator', $user->roles);

    // Permitir acesso livre para a página /login (ou outra que você definir)
    $allowed_paths = ['/wp-login.php', '/login', "/demo"];

    // Se não estiver logado, redireciona para /login (customizada) no site principal
    if (!is_user_logged_in() && !is_admin()) {
        if (defined('DOING_AJAX') && DOING_AJAX) return;

        if (!in_array($current_path, $allowed_paths)) {
            wp_redirect(network_home_url('/login')); // aqui para /login ao invés de /wp-login.php
            exit;
        }
    }

    // Se estiver logado, mas não for membro do site atual (exceto admin)
    if (is_user_logged_in() && !is_user_member_of_blog($user_id, $current_blog_id) && !$is_super_admin && !$is_admin_user) {
        $sites = get_blogs_of_user($user_id);

        if (!empty($sites)) {
            $first_site = reset($sites);
            wp_redirect($first_site->siteurl);
            exit;
        } else {
            wp_redirect(network_home_url('/login'));
            exit;
        }
    }

    // Se estiver logado e acessar /login no site principal, redireciona pro primeiro site associado
    if (is_user_logged_in() && $current_path === '/login' && is_main_site()) {
        $sites = get_blogs_of_user($user_id);

        if (!empty($sites)) {
            $site = reset($sites);
            wp_redirect($site->siteurl);
            exit;
        } else {
            wp_redirect(home_url('/'));
            exit;
        }
    }
});

add_action('wp_head', function () {
    // Busca o post pelo título "Custom CSS"
    $custom_css_post = get_page_by_title('Custom CSS', OBJECT, 'post');
    
    if ($custom_css_post) {
        $css = $custom_css_post->post_content;
        
        if ($css) {
            echo "<style id='custom-css-from-post'>\n" . $css . "\n</style>";
        }
    }
});

add_filter( 'woocommerce_cart_block_support_enabled', '__return_false' );
add_filter( 'woocommerce_checkout_block_support_enabled', '__return_false' );

add_action('init', function () {
    if (!isset($_GET['jwt']) || !isset($_GET['redirect'])) {
        return;
    }

    $jwt = sanitize_text_field($_GET['jwt']);
    $redirect = esc_url_raw($_GET['redirect']);

    // 1) Valida token JWT
    $validate_response = wp_remote_post(site_url('/wp-json/jwt-auth/v1/token/validate'), [
        'headers' => ['Authorization' => 'Bearer ' . $jwt]
    ]);

    if (is_wp_error($validate_response) || wp_remote_retrieve_response_code($validate_response) !== 200) {
        wp_redirect(site_url('/login?error=jwt_invalid'));
        exit;
    }

    // 2) Busca dados do usuário usando o token
    $user_response = wp_remote_get(site_url('/wp-json/wp/v2/users/me'), [
        'headers' => ['Authorization' => 'Bearer ' . $jwt]
    ]);

    if (is_wp_error($user_response) || wp_remote_retrieve_response_code($user_response) !== 200) {
        wp_redirect(site_url('/login?error=jwt_invalid'));
        exit;
    }

    $user_data = json_decode(wp_remote_retrieve_body($user_response), true);

    if (empty($user_data['id'])) {
        wp_redirect(site_url('/login?error=jwt_invalid'));
        exit;
    }

    // 3) Login do usuário via WP
    $user_id = intval($user_data['id']);
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id, true); // true para remember (cookie persistente)

    // 4) Redireciona para URL solicitada
    wp_safe_redirect($redirect);
    exit;
});


add_filter( 'woocommerce_checkout_fields', function( $fields ) {
    // Debug para ver quais campos são obrigatórios
    error_log(print_r($fields['billing'], true));
    return $fields;
});

add_filter('woocommerce_checkout_fields', function($fields) {
    if (isset($fields['billing']['billing_neighborhood'])) {
        $fields['billing']['billing_neighborhood']['required'] = false;
    }
    return $fields;
});

/**
 * Adiciona menu "Criador de Lojas" no painel de administração
 */
add_action('admin_menu', function() {
    add_menu_page(
        'Criador de Lojas', // Título da página
        '🚀 Criador de Lojas', // Título do menu com emoji
        'manage_options', // Capacidade necessária
        'criador-lojas', // Slug do menu
        function() {
            // Redireciona para o link externo
            wp_redirect('http://shop.microware.com.br:14322');
            exit;
        },
        'dashicons-admin-site', // Ícone personalizado
        30 // Posição no menu
    );
});

/**
 * Adiciona "Criador de Lojas" no menu de multisites
 */
add_action('admin_menu', function() {
    if (is_multisite() && is_network_admin()) {
        add_submenu_page(
            'sites.php', // Parent slug (menu Sites)
            'Criador de Lojas', // Título da página
            '🚀 Criador de Lojas', // Título do menu com emoji
            'manage_sites', // Capacidade necessária
            'criador-lojas-network', // Slug do menu
            function() {
                // Redireciona para o link externo
                wp_redirect('http://shop.microware.com.br:14322');
                exit;
            }
        );
    }
});

/**
 * Adiciona "Criador de Lojas" no menu Aparência
 */
add_action('admin_menu', function() {
    add_submenu_page(
        'themes.php', // Parent slug (menu Aparência)
        'Criador de Lojas', // Título da página
        '🚀 Criador de Lojas', // Título do menu com emoji
        'edit_theme_options', // Capacidade necessária
        'criador-lojas-appearance', // Slug do menu
        function() {
            // Redireciona para o link externo
            wp_redirect('http://shop.microware.com.br:14322');
            exit;
        }
    );
}, 20);

/**
 * Adiciona "Criador de Lojas" na barra de administração
 */
add_action('admin_bar_menu', function($wp_admin_bar) {
    // Verifica se o usuário tem permissão
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Adiciona no menu "Meus Sites" se for multisite
    if (is_multisite()) {
        $wp_admin_bar->add_node(array(
            'parent' => 'my-sites-super-admin',
            'id'     => 'criador-lojas-admin-bar',
            'title'  => '<span class="ab-icon dashicons dashicons-admin-site" style="margin-right: 5px;"></span>Criador de Lojas',
            'href'   => 'http://shop.microware.com.br:14322',
            'meta'   => array(
                'target' => '_blank',
                'title'  => 'Abrir Criador de Lojas em nova aba'
            )
        ));
    }
    
    // Adiciona no menu principal da barra de administração (apenas se não for multisite ou se for super admin)
    if (!is_multisite() || current_user_can('manage_network')) {
        $wp_admin_bar->add_node(array(
            'id'     => 'criador-lojas-main',
            'title'  => '<span class="ab-icon dashicons dashicons-admin-site" style="margin-right: 5px;"></span>Criador de Lojas',
            'href'   => 'http://shop.microware.com.br:14322',
            'meta'   => array(
                'target' => '_blank',
                'title'  => 'Abrir Criador de Lojas em nova aba'
            )
        ));
    }
}, 100);

/**
 * Adiciona "Criador de Lojas" no menu de personalização (Customizer)
 */
add_action('customize_register', function($wp_customize) {
    // Verifica se o usuário tem permissão
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    
    // Adiciona uma nova seção no customizer
    $wp_customize->add_section('criador_lojas_section', array(
        'title'       => 'Criador de Lojas',
        'description' => 'Acesse o sistema de criação de lojas para gerenciar suas lojas virtuais',
        'priority'    => 200,
        'capability'  => 'edit_theme_options'
    ));
    
    // Adiciona um controle personalizado para o botão
    $wp_customize->add_setting('criador_lojas_button', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'capability'        => 'edit_theme_options'
    ));
    
    $wp_customize->add_control('criador_lojas_button', array(
        'label'       => 'Abrir Sistema',
        'description' => '<div style="margin-top: 15px;"><a href="http://shop.microware.com.br:14322" target="_blank" class="button button-primary" style="width: 100%; text-align: center; padding: 12px; font-size: 14px; font-weight: 600;"><span class="dashicons dashicons-admin-site" style="margin-right: 8px; font-size: 16px;"></span>🚀 Abrir Criador de Lojas</a></div><p style="margin-top: 10px; font-style: italic; color: #666;">Clique no botão acima para acessar o sistema de criação de lojas em uma nova aba</p>',
        'section'     => 'criador_lojas_section',
        'type'        => 'text',
        'input_attrs' => array(
            'style' => 'display: none;'
        )
    ));
});

/**
 * Adiciona CSS personalizado para o botão no customizer e ícones nos menus
 */
add_action('customize_controls_print_styles', function() {
    ?>
    <style>
        #customize-control-criador_lojas_button .description a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        #customize-control-criador_lojas_button .description a:hover {
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        #customize-control-criador_lojas_button .description p {
            margin-top: 10px;
            font-style: italic;
            color: #666;
        }
    </style>
    <?php
});

/**
 * Adiciona CSS personalizado para ícones nos menus de administração
 */
add_action('admin_head', function() {
    ?>
    <style>
        /* Ícone para o submenu no menu Aparência */
        #adminmenu .wp-submenu a[href*="criador-lojas-appearance"]::before {
            content: "\f319"; /* dashicons-admin-site */
            font-family: 'dashicons';
            margin-right: 8px;
            font-size: 14px;
            color: #a7aaad;
        }
        
        /* Ícone para o submenu no menu Sites (multisite) */
        #adminmenu .wp-submenu a[href*="criador-lojas-network"]::before {
            content: "\f319"; /* dashicons-admin-site */
            font-family: 'dashicons';
            margin-right: 8px;
            font-size: 14px;
            color: #a7aaad;
        }
        
        /* Hover effect para os ícones dos submenus */
        #adminmenu .wp-submenu a[href*="criador-lojas"]:hover::before {
            color: #72aee6;
        }
        
        /* Estilo especial para o menu principal */
        #adminmenu .wp-menu-image.dashicons-admin-site::before {
            color: #a7aaad;
        }
        
        #adminmenu .current .wp-menu-image.dashicons-admin-site::before,
        #adminmenu .wp-has-current-submenu .wp-menu-image.dashicons-admin-site::before {
            color: #fff;
        }
        
        /* Estilo para emojis nos menus */
        #adminmenu a[href*="criador-lojas"] .wp-menu-name {
            font-size: 13px;
        }
        
        /* Animação sutil para o menu principal */
        #adminmenu .wp-menu-image.dashicons-admin-site {
            transition: all 0.3s ease;
        }
        
        #adminmenu .current .wp-menu-image.dashicons-admin-site,
        #adminmenu .wp-has-current-submenu .wp-menu-image.dashicons-admin-site {
            transform: scale(1.1);
        }

        .term-description{
          display: none;
        }
    </style>
    <?php
});

function customizer_logos_position($wp_customize) {
    $wp_customize->add_section('logos_position_section', array(
        'title' => 'Posição dos Logos do Banner',
        'priority' => 30,
    ));

    $wp_customize->add_setting('logo1_x', array(
        'default' => 158,
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_setting('logo2_x', array(
        'default' => 35,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('logo1_x', array(
        'label' => 'Posição X do Logo do Cliente',
        'section' => 'logos_position_section',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 500,
            'step' => 1,
        ),
    ));
    $wp_customize->add_control('logo2_x', array(
        'label' => 'Posição X do Logo da Microware',
        'section' => 'logos_position_section',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 0,
            'max' => 500,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'customizer_logos_position');

add_filter('woocommerce_placeholder_img_src', 'custom_placeholder_conditional');
function custom_placeholder_conditional($image_url) {
    if (is_product()) {
        global $post;

        // Se o produto estiver na categoria "desktop"
        if (has_term('desktop', 'product_cat', $post->ID)) {
            return get_stylesheet_directory_uri() . '/assets/images/Desktop.png';
        }

        // Se estiver na categoria "notebook"
        if (has_term('notebook', 'product_cat', $post->ID)) {
            return get_stylesheet_directory_uri() . '/assets/images/Desktop.png';
        }

        // Se estiver na categoria "Acessórios"
        if (has_term('Acessórios', 'product_cat', $post->ID)) {
            return get_stylesheet_directory_uri() . '/assets/images/Acessórios.png';
        }

        // Se estiver na categoria "Acessórios"
        if (has_term('Serviço', 'product_cat', $post->ID)) {
            return get_stylesheet_directory_uri() . '/assets/images/Serviço.png';
        }           

        // Categoria padrão (fallback)
        return get_stylesheet_directory_uri() . '/assets/images/Acessórios.png';
    }

    return $image_url;
}


add_filter('woocommerce_available_payment_gateways', function($gateways) {
    // Ordem desejada
    $ordem = [
        'wc_piggly_pix_gateway',         // PIX
        'itau-shopline',                 // Itaú Shopline
        'paypal-brasil-spb-gateway',     // PayPal
        'cheque'                         // Cheque (opcional)
    ];

    $novo = [];
    foreach ($ordem as $id) {
        if (isset($gateways[$id])) {
            $novo[$id] = $gateways[$id];
        }
    }

    // Adiciona os restantes que não foram listados
    foreach ($gateways as $id => $gateway) {
        if (!isset($novo[$id])) {
            $novo[$id] = $gateway;
        }
    }

    return $novo;
});

// Ordenação padrão das categorias da loja
add_filter('woocommerce_product_categories', 'ordenar_categorias_padrao', 10, 2);
function ordenar_categorias_padrao($terms, $args) {
    // Define a ordem padrão desejada
    $ordem_padrao = [
        'Desktop',
        'Notebook', 
        'Workstation',
        'Dockstation',
        'Display',
        'Monitor',
        'Telefonia',
        'Tablet',
        'Acessório',
        'Serviço'
    ];

    // Se não há termos, retorna vazio
    if (empty($terms) || is_wp_error($terms)) {
        return $terms;
    }

    // Array para armazenar os termos ordenados
    $termos_ordenados = [];

    // Primeiro, adiciona os termos que estão na lista de ordem padrão
    foreach ($ordem_padrao as $nome_categoria) {
        foreach ($terms as $key => $term) {
            if ($term->name === $nome_categoria) {
                $termos_ordenados[] = $term;
                unset($terms[$key]); // Remove para não repetir
                break;
            }
        }
    }

    // Depois, adiciona os demais termos que não estavam na lista de ordem padrão
    foreach ($terms as $term) {
        $termos_ordenados[] = $term;
    }

    return $termos_ordenados;
}

// Ordenação padrão para get_terms (usado nos templates)
add_filter('woocommerce_product_categories_args', 'modificar_args_categorias_padrao');
function modificar_args_categorias_padrao($args) {
    // Verifica se não há ordem manual definida
    $manual_order = get_theme_mod('custom_category_order', '');
    
    if (empty($manual_order)) {
        // Define a ordem padrão desejada
        $ordem_padrao = [
            'Desktop',
            'Notebook', 
            'Workstation',
            'Dockstation',
            'Display',
            'Monitor',
            'Telefonia',
            'Tablet',
            'Acessório',
            'Serviço'
        ];

        // Busca os IDs das categorias na ordem desejada
        $ids_ordenados = [];
        foreach ($ordem_padrao as $nome_categoria) {
            $term = get_term_by('name', $nome_categoria, 'product_cat');
            if ($term && !is_wp_error($term)) {
                $ids_ordenados[] = $term->term_id;
            }
        }

        // Se encontrou categorias na ordem padrão, usa elas
        if (!empty($ids_ordenados)) {
            $args['include'] = $ids_ordenados;
            $args['orderby'] = 'include';
            $args['order'] = 'ASC';
        }
    }

    return $args;
}

// Função para definir a ordem padrão das categorias (pode ser chamada no functions.php)
function definir_ordem_padrao_categorias($ordem_categorias = []) {
    // Se não foi passada uma ordem, usa a padrão
    if (empty($ordem_categorias)) {
        $ordem_categorias = [
            'Desktop',
            'Notebook', 
            'Workstation',
            'Dockstation',
            'Display',
            'Monitor',
            'Telefonia',
            'Tablet',
            'Acessório',
            'Serviço'
        ];
    }
    
    // Salva a ordem no tema mod para uso global
    set_theme_mod('ordem_padrao_categorias', $ordem_categorias);
}

// Função para obter a ordem padrão das categorias
function obter_ordem_padrao_categorias() {
    $ordem_salva = get_theme_mod('ordem_padrao_categorias', []);
    
    if (empty($ordem_salva)) {
        // Retorna a ordem padrão se não houver configuração salva
        return [
            'Desktop',
            'Notebook', 
            'Workstation',
            'Dockstation',
            'Display',
            'Monitor',
            'Telefonia',
            'Tablet',
            'Acessório',
            'Serviço'
        ];
    }
    
    return $ordem_salva;
}

// Atualiza a função de ordenação para usar a configuração salva
function aplicar_ordem_padrao_categorias($terms) {
    if (empty($terms) || is_wp_error($terms)) {
        return $terms;
    }

    // Obtém a ordem padrão (salva ou padrão)
    $ordem_padrao = obter_ordem_padrao_categorias();

    // Array para armazenar os termos ordenados
    $termos_ordenados = [];

    // Primeiro, adiciona os termos que estão na lista de ordem padrão
    foreach ($ordem_padrao as $nome_categoria) {
        foreach ($terms as $key => $term) {
            if ($term->name === $nome_categoria) {
                $termos_ordenados[] = $term;
                unset($terms[$key]); // Remove para não repetir
                break;
            }
        }
    }

    // Depois, adiciona os demais termos que não estavam na lista de ordem padrão
    foreach ($terms as $term) {
        $termos_ordenados[] = $term;
    }

    return $termos_ordenados;
}

