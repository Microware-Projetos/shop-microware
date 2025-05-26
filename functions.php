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
   
    register_sidebar( array(
        'name' => esc_html__( 'Footer Widget Area', 'storebiz' ),
        'id'   => 'storebiz-footer-widget-area',
        'description'  => esc_html__( 'The Footer Widget Area', 'storebiz' ),
        'before_widget'=> '<div class="col wow fadeInUp"><aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside></div>',
        'before_title' => '<h5 class="widget-title">',
        'after_title'  => '</h5>',
    ) );
 
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
 
 
//Upload
// Add file upload field to the checkout page
add_action( 'woocommerce_review_order_before_payment', 'Custom_Checkout_file_upload_field' );
 
function Custom_Checkout_file_upload_field() {
    ?>
    <style>
        #custom-file-upload-wrapper {
            border: 2px dashed var(--bs-primary);
            padding: 1.5rem;
            background-color: #f9f2ff;
            border-radius: 10px;
            margin-top: 20px;
        }
 
        #custom-file-upload-wrapper label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--bs-primary);
            font-size: 1.1rem;
        }
 
        #custom-file-upload-wrapper input[type="file"] {
            border: 2px solid #ccc;
            padding: 10px;
            background: #fff;
            cursor: pointer;
            width: 100%;
        }
 
        #custom-file-warning {
            margin-top: 10px;
            color: #b10000;
            font-size: 0.95rem;
            font-weight: bold;
        }
    </style>
 
    <div id="custom-file-upload-wrapper" class="form-row form-row-wide" style="display:none;">
        <label for="Custom_Checkout_file">⚠️ Obrigatório: Anexe a Ordem de Compra</label>
        <input type="file" id="Custom_Checkout_file" name="Custom_Checkout_file" />
        <input type="hidden" name="Custom_Checkout_file_field" id="Custom_Checkout_file_field" />
        <div id="Custom_Checkout_filelist"></div>
        <div id="custom-file-warning">* Este campo é obrigatório nesse método de pagamento.</div>
    </div>
 
    <script type="text/javascript">
        jQuery(function($){
            function togglePaymentMethods() {
                var tipoPessoa = $('#billing_persontype').val();
                var paymentMethodCheque = $('.payment_method_cheque');
                
                if (tipoPessoa === '2') { // 2 = Pessoa Jurídica
                    paymentMethodCheque.closest('li').show();
                    // Se não houver método selecionado, seleciona o cheque
                    if (!$('input[name="payment_method"]:checked').length) {
                        $('#payment_method_cheque').prop('checked', true).trigger('change');
                    }
                } else {
                    paymentMethodCheque.closest('li').hide();
                    // Se o método cheque estiver selecionado, muda para transferência bancária
                    if ($('#payment_method_cheque').is(':checked')) {
                        $('#payment_method_bacs').prop('checked', true).trigger('change');
                    }
                }
            }

            function toggleFileUpload() {
                var selectedPayment = $('input[name="payment_method"]:checked').val();
                var tipoPessoa = $('#billing_persontype').val();
                
                if (selectedPayment === 'cheque' && tipoPessoa === '2') {
                    $('#custom-file-upload-wrapper').slideDown();
                } else {
                    $('#custom-file-upload-wrapper').slideUp();
                }
            }
 
            // Executa as funções quando a página carrega
            $(document).ready(function() {
                setTimeout(function() {
                    togglePaymentMethods();
                    toggleFileUpload();
                }, 1000);
            });
 
            // Monitora mudanças no tipo de pessoa
            $(document.body).on('change', '#billing_persontype', function() {
                setTimeout(function() {
                    togglePaymentMethods();
                    toggleFileUpload();
                    $('body').trigger('update_checkout');
                }, 500);
            });
 
            // Monitora mudanças no método de pagamento
            $(document.body).on('change', 'input[name="payment_method"]', function() {
                toggleFileUpload();
            });

            // Monitora atualizações do checkout
            $(document.body).on('updated_checkout', function() {
                togglePaymentMethods();
                toggleFileUpload();
            });
        });
    </script>
    <?php
}
 
 
add_action( 'woocommerce_checkout_process', 'Custom_Checkout_validate_upload_if_cheque' );
 
function Custom_Checkout_validate_upload_if_cheque() {
    // Verifica se a forma de pagamento é cheque
    if ( isset( $_POST['payment_method'] ) && $_POST['payment_method'] === 'cheque' ) {
 
        // Verifica se o campo oculto (com o link do upload) foi preenchido
        if ( empty( $_POST['Custom_Checkout_file_field'] ) ) {
            wc_add_notice( 'O envio do arquivo é obrigatório para pagamentos com cheque.', 'error' );
        }
 
    }
}
 
 
// jQuery Script to handle the file upload via AJAX
add_action( 'wp_footer', 'Custom_Checkout_file_upload_script' );
function Custom_Checkout_file_upload_script() {
    if ( is_checkout() ) : ?>
        <script>
            jQuery( function( $ ) {
 
                $( '#Custom_Checkout_file' ).change( function() {
 
                    if ( ! this.files.length ) {
                        $( '#Custom_Checkout_filelist' ).empty();
                    } else {
 
                        const file = this.files[0];
                        const formData = new FormData();
                        formData.append( 'Custom_Checkout_file', file );
 
                        // Show a preview of the file
                        if (file.type.startsWith('image/')) {
                            $('#Custom_Checkout_filelist').html('<img src="' + URL.createObjectURL(file) + '" width="200"><span>' + file.name + '</span>');
                        } else if (file.type === 'application/pdf') {
                            $('#Custom_Checkout_filelist').html('<span>' + file.name + ' (PDF file)</span>');
                        } else {
                            $('#Custom_Checkout_filelist').html('<span>' + file.name + ' (Unsupported Preview - File Uploaded)</span>');
                        }
 
                        // Upload the file via AJAX
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>?action=Custom_Checkoutupload',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            processData: false,
                            success: function ( response ) {
                                $( '#Custom_Checkout_file_field' ).val( response );
                            }
                        });
 
                    }
 
                } );
 
                          // Intercepta o envio do formulário
                          $('form.checkout').on('checkout_place_order', function(e) {
                    if ($('#payment_method_cheque').is(':checked')) {
                        // Verifica se o upload foi completado ou se o campo do arquivo está vazio
                        if (!uploadCompleted || $('#Custom_Checkout_file_field').val() === '') {
                            e.preventDefault();  // Bloqueia o envio do pedido
                            alert('Por favor, envie o arquivo antes de finalizar o pedido.');
                            return false;
                        }
                    }
                });
 
            } );
        </script>
    <?php
    endif;
}
 
// Handle the file upload via AJAX
add_action( 'wp_ajax_Custom_Checkoutupload', 'Custom_Checkout_file_upload' );
add_action( 'wp_ajax_nopriv_Custom_Checkoutupload', 'Custom_Checkout_file_upload' );
 
function Custom_Checkout_file_upload(){
 
    $upload_dir = wp_upload_dir();
    $allowed_file_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf'); // Add allowed file types here.
 
    if ( isset( $_FILES[ 'Custom_Checkout_file' ] ) ) {
        $file_name = $_FILES[ 'Custom_Checkout_file' ][ 'name' ];
        $file_ext = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
 
        if ( in_array( $file_ext, $allowed_file_types ) ) {
            $path = $upload_dir[ 'path' ] . '/' . basename( $file_name );
 
            if( move_uploaded_file( $_FILES[ 'Custom_Checkout_file' ][ 'tmp_name' ], $path ) ) {
                echo $upload_dir[ 'url' ] . '/' . basename( $file_name );
            }
        } else {
            echo 'File type not allowed.';
        }
    }
    die;
}
 
// Save the uploaded file URL to order meta
add_action( 'woocommerce_checkout_update_order_meta', 'Custom_Checkout_save_what_we_added' );
 
function Custom_Checkout_save_what_we_added( $order_id ){
 
    if( ! empty( $_POST[ 'Custom_Checkout_file_field' ] ) && ( $order = wc_get_order( $order_id ) ) ) {
        $order->update_meta_data( 'Custom_Checkout_file_field', sanitize_text_field( $_POST[ 'Custom_Checkout_file_field' ] ) );
        $order->save();
    }
 
}
 
// Display the uploaded file in the admin order page
add_action( 'woocommerce_admin_order_data_after_order_details', 'Custom_Checkout_order_meta_general' );
 
function Custom_Checkout_order_meta_general( $order ){
 
    $file = $order->get_meta( 'Custom_Checkout_file_field' );
 
    if( $file ) {
        echo '<h3>&nbsp;</h3>';
       
        $file_extension = pathinfo( $file, PATHINFO_EXTENSION );
       
        if ( in_array( $file_extension, array('jpg', 'jpeg', 'png', 'gif') ) ) {
            echo '<a href="' . esc_url( $file ) . '" target="_blank" style="text-decoration: none;">
                    <div style="padding: 10px 15px; background-color: #007cba; color: white; border-radius: 4px; text-align: center; display: inline-block; cursor: pointer;">
                        Ver arquivo enviado
                    </div>
                  </a>';
        } elseif ( $file_extension === 'pdf' ) {
            echo '<a href="' . esc_url( $file ) . '" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                    <div style="padding: 10px 15px; background-color: #007cba; color: white; border-radius: 4px; text-align: center; display: inline-block; cursor: pointer;">
                        Ver arquivo enviado
                    </div>
                  </a>';
        } else {
            echo '<a href="' . esc_url( $file ) . '" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                    <div style="padding: 10px 15px; background-color: #007cba; color: white; border-radius: 4px; text-align: center; display: inline-block; cursor: pointer;">
                        Ver arquivo enviado
                    </div>
                  </a>';
        }
    }
}
 
add_action('pre_get_posts', 'ordenar_produtos_preco_maior_para_menor');
function ordenar_produtos_preco_maior_para_menor($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
 
    // Verifica se é a página da loja ou de categoria
    if (is_shop() || is_product_category()) {
        // Apenas se o usuário não tiver escolhido outra ordenação manualmente
        if (!isset($_GET['orderby'])) {
            $query->set('orderby', 'meta_value_num');
            $query->set('meta_key', '_price');
            $query->set('order', 'DESC');
        }
    }
}
 
add_action('wp_footer', function() {
    if (is_checkout()) : ?>
    <script>
    jQuery(function($) {
        $('form.checkout').on('change', 'input[name="payment_method"]', function() {
            setTimeout(function() {
                $('body').trigger('update_checkout');
            }, 100);
        });
    });
    </script>
    <?php endif;
});
 
add_filter('woocommerce_cart_item_thumbnail', 'custom_cart_item_thumbnail_full', 10, 3);
 
function custom_cart_item_thumbnail_full($thumbnail, $cart_item, $cart_item_key) {
    $product_id = $cart_item['product_id'];
    $external_image = get_post_meta($product_id, '_external_image_url', true);
 
    if ($external_image) {
        // Garante que a imagem vai aparecer em todos os lugares (cart page, mini cart, etc)
        $thumbnail = sprintf(
            '<img src="%s" alt="%s" style="max-width: 100px; height: auto;" />',
            esc_url($external_image),
            esc_attr(get_the_title($product_id))
        );
    }
 
    return $thumbnail;
}
 
 
// Tornar o campo Bairro obrigatório no WooCommerce
function custom_make_bairro_required( $fields ) {
    $fields['billing']['billing_neighborhood']['required'] = true;
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'custom_make_bairro_required' );
 
// FIM
 
 
// Adiciona a coluna de imagem personalizada para produtos no painel administrativo
// Adiciona a coluna de imagem externa na primeira posição
add_filter('manage_edit-product_columns', 'add_external_image_column', 10, 1);
function add_external_image_column($columns) {
    // Remove a coluna de imagem padrão
    unset($columns['thumbnail']);
 
    // Cria uma nova coluna chamada "Imagem Externa" e coloca na primeira posição
    $columns = array(
        'external_image' => __('Imagem Externa'), // Nome da nova coluna
    ) + $columns; // Adiciona a nova coluna antes das outras
 
    return $columns;
}
 
// Exibe a imagem externa na nova coluna
add_action('manage_product_posts_custom_column', 'show_external_image_column', 10, 2);
function show_external_image_column($column, $post_id) {
    if ($column === 'external_image') {
        // Obtém a URL da imagem externa
        $external_image = get_post_meta($post_id, '_external_image_url', true);
       
        if ($external_image) {
            echo '<img src="' . esc_url($external_image) . '" style="width: 60px; height: 60px; object-fit: cover;" />';
        } else {
            echo 'Sem Imagem Externa';
        }
    }
}
 
//Slider
function storebiz_customize_register_banners($wp_customize) {
    $wp_customize->add_section('custom_shop_section', array(
        'title'    => __('Banners da Loja', 'storebiz'),
        'priority' => 30,
    ));
 
    for ($i = 1; $i <= 10; $i++) {
        // Configuração da imagem do banner
        $setting_id = 'custom_shop_banner_' . $i;
        $wp_customize->add_setting($setting_id, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
 
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $setting_id, array(
            'label'    => __('Banner ' . $i, 'storebiz'),
            'section'  => 'custom_shop_section',
            'settings' => $setting_id,
        )));

        // Configuração do link do banner
        $link_setting_id = 'custom_shop_banner_link_' . $i;
        $wp_customize->add_setting($link_setting_id, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
 
        $wp_customize->add_control($link_setting_id, array(
            'label'    => __('Link do Banner ' . $i, 'storebiz'),
            'section'  => 'custom_shop_section',
            'type'     => 'url',
            'settings' => $link_setting_id,
        ));
    }
}
add_action('customize_register', 'storebiz_customize_register_banners');

// Função para exibir o slider com links
function storebiz_display_banner_slider() {
    ?>
    <div class="shop-banner-slider swiper">
        <div class="swiper-wrapper">
            <?php
            for ($i = 1; $i <= 10; $i++) {
                $banner_url = get_theme_mod('custom_shop_banner_' . $i);
                $banner_link = get_theme_mod('custom_shop_banner_link_' . $i);
                
                if (!empty($banner_url)) {
                    echo '<div class="swiper-slide">';
                    if (!empty($banner_link)) {
                        echo '<a href="' . esc_url($banner_link) . '" target="_blank">';
                    }
                    echo '<img src="' . esc_url($banner_url) . '" alt="Banner ' . $i . '">';
                    if (!empty($banner_link)) {
                        echo '</a>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <?php
}

function storebiz_load_swiper_assets() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
 
    wp_add_inline_script('swiper-js', "
        const swiper = new Swiper('.shop-banner-slider', {
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            }
        });
    ");
}
add_action('wp_enqueue_scripts', 'storebiz_load_swiper_assets');
 
function storebiz_enqueue_checkout_styles() {
    if (is_checkout()) {
        wp_enqueue_style('storebiz-checkout-mobile', get_template_directory_uri() . '/assets/css/checkout-mobile.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'storebiz_enqueue_checkout_styles');
 
function storebiz_enqueue_mobile_checkout_styles() {
    if (is_checkout()) {
        wp_enqueue_style('storebiz-mobile-checkout', get_template_directory_uri() . '/assets/css/mobile-checkout.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'storebiz_enqueue_mobile_checkout_styles');
 
add_filter( 'woocommerce_checkout_fields', 'customizar_campo_empresa' );
function customizar_campo_empresa( $fields ) {
    // Deixa o campo visível, mas com uma classe personalizada para esconder via JS
    $fields['billing']['billing_company']['required'] = false; // Deixa opcional no PHP
    $fields['billing']['billing_company']['label'] = 'Empresa (Razão Social)';
    $fields['billing']['billing_company']['class'] = array('form-row-wide', 'empresa-field'); // Classe personalizada
    $fields['billing']['billing_company']['priority'] = 30;
    return $fields;
}
 
add_action( 'wp_footer', 'mostrar_empresa_apenas_para_pj' );
function mostrar_empresa_apenas_para_pj() {
    if ( is_checkout() ) : ?>
        <script type="text/javascript">
        jQuery(function($){
            function exibirCampoEmpresa() {
                var tipoPessoa = $('#billing_persontype').val();
                var campoEmpresa = $('#billing_company_field');
 
                if (tipoPessoa === '2') { // 2 = Pessoa Jurídica
                    campoEmpresa.show();
                    $('#billing_company').prop('required', true);
                } else {
                    campoEmpresa.hide();
                    $('#billing_company').prop('required', false);
                }
            }
 
            exibirCampoEmpresa(); // Ao carregar a página
            $('#billing_persontype').on('change', exibirCampoEmpresa); // Quando muda
        });
        </script>
    <?php endif;
}
 
// Adiciona o campo de telefone ao formulário de registro
function wooc_extra_register_fields() {
    ?>
    <p class="form-row form-row-wide">
        <label for="tipo_pessoa"><?php _e( 'Tipo de Pessoa', 'woocommerce' ); ?></label>
        <select name="tipo_pessoa" id="tipo_pessoa" class="input-select">
            <option value="fisica" <?php if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'fisica' ) echo 'selected'; ?>>Pessoa Física</option>
            <option value="juridica" <?php if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'juridica' ) echo 'selected'; ?>>Pessoa Jurídica</option>
        </select>
    </p>
 
    <div id="fisica_fields" style="display: none;">
        <p class="form-row form-row-first">
            <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
        </p>
        <p class="form-row form-row-last">
            <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
        </p>
    </div>
 
    <div id="juridica_fields" style="display: none;">
        <p class="form-row form-row-first">
            <label for="billing_company"><?php _e( 'Razão Social', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_company" id="billing_company" value="<?php if ( ! empty( $_POST['billing_company'] ) ) esc_attr_e( $_POST['billing_company'] ); ?>" />
        </p>
    </div>
 
    <p class="form-row form-row-wide" id="cpf_field" style="display: none;">
        <label for="billing_cpf"><?php _e( 'CPF', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_cpf" id="billing_cpf" value="<?php if ( ! empty( $_POST['billing_cpf'] ) ) esc_attr_e( $_POST['billing_cpf'] ); ?>" />
    </p>
 
    <p class="form-row form-row-wide" id="cnpj_field" style="display: none;">
        <label for="billing_cnpj"><?php _e( 'CNPJ', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_cnpj" id="billing_cnpj" value="<?php if ( ! empty( $_POST['billing_cnpj'] ) ) esc_attr_e( $_POST['billing_cnpj'] ); ?>" />
    </p>
    <div class="clear"></div>
 
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoPessoa = document.getElementById('tipo_pessoa');
        const cpfField = document.getElementById('cpf_field');
        const cnpjField = document.getElementById('cnpj_field');
        const razaoField = document.getElementById('billing_company');
        const fisicaFields = document.getElementById('fisica_fields');
        const juridicaFields = document.getElementById('juridica_fields');
 
        function toggleFields() {
            if (tipoPessoa.value === 'fisica') {
                fisicaFields.style.display = 'block';
                cpfField.style.display = 'block';
                cnpjField.style.display = 'none';
                razaoField.style.display = 'none';
                juridicaFields.style.display = 'none';
            } else {
                fisicaFields.style.display = 'none';
                cpfField.style.display = 'none';
                cnpjField.style.display = 'block';
                razaoField.style.display = 'block';
                juridicaFields.style.display = 'block';
            }
        }
 
        tipoPessoa.addEventListener('change', toggleFields);
        toggleFields(); // chamada inicial
    });
    </script>
 
    <?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
 
/**
 * Validando os campos extras do registro
 */
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) && $_POST['tipo_pessoa'] === 'fisica' ) {
        $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required for person type "fisica"!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) && $_POST['tipo_pessoa'] === 'fisica' ) {
        $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required for person type "fisica"!', 'woocommerce' ) );
    }
    if ( isset( $_POST['tipo_pessoa'] ) && empty( $_POST['tipo_pessoa'] ) ) {
        $validation_errors->add( 'tipo_pessoa_error', __( '<strong>Error</strong>: Tipo de pessoa é obrigatório!', 'woocommerce' ) );
    }
    if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'fisica' && empty( $_POST['billing_cpf'] ) ) {
        $validation_errors->add( 'billing_cpf_error', __( '<strong>Error</strong>: CPF é obrigatório para pessoa física!', 'woocommerce' ) );
    }
    if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'juridica' && ( empty( $_POST['billing_cnpj'] ) || empty( $_POST['billing_company'] ) ) ) {
        $validation_errors->add( 'billing_cnpj_error', __( '<strong>Error</strong>: CNPJ e Razão Social são obrigatórios para pessoa jurídica!', 'woocommerce' ) );
    }
    return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
 
/**
 * Salvando os campos extras no registro
 */
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['tipo_pessoa'] ) ) {
        update_user_meta( $customer_id, 'tipo_pessoa', sanitize_text_field( $_POST['tipo_pessoa'] ) );
    }
 
    if ( isset( $_POST['billing_first_name'] ) ) {
        // Atualiza o primeiro nome no WordPress
        $user_data = array(
            'ID'           => $customer_id,
            'first_name'   => sanitize_text_field( $_POST['billing_first_name'] )
        );
        wp_update_user( $user_data );
       
        // Atualiza o primeiro nome no WooCommerce
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
   
    if ( isset( $_POST['billing_last_name'] ) ) {
        // Atualiza o sobrenome no WordPress
        $user_data = array(
            'ID'           => $customer_id,
            'last_name'    => sanitize_text_field( $_POST['billing_last_name'] )
        );
        wp_update_user( $user_data );
       
        // Atualiza o sobrenome no WooCommerce
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
   
 
    if ( isset( $_POST['billing_cpf'] ) ) {
        update_user_meta( $customer_id, 'billing_cpf', sanitize_text_field( $_POST['billing_cpf'] ) );
    }
    if ( isset( $_POST['billing_cnpj'] ) ) {
        update_user_meta( $customer_id, 'billing_cnpj', sanitize_text_field( $_POST['billing_cnpj'] ) );
    }
    if ( isset( $_POST['billing_company'] ) ) {
        update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
 
// Personalizando a página de detalhes da conta para exibir Razão Social e CNPJ para Pessoa Jurídica
// Adiciona os campos personalizados no formulário de edição de conta
function custom_woocommerce_account_fields() {
    $user_id = get_current_user_id();
    $tipo_pessoa = get_user_meta($user_id, 'tipo_pessoa', true); // Tipo de pessoa (física ou jurídica)
   
    if ($tipo_pessoa == 'juridica') {
        $razao_social = get_user_meta($user_id, 'billing_company', true);
        $cnpj = get_user_meta($user_id, 'billing_cnpj', true);
       
        ?>
        <p class="form-row form-row-wide">
            <label for="billing_company"><?php esc_html_e( 'Razão Social', 'woocommerce' ); ?></label>
            <input type="text" class="input-text" name="billing_company" id="billing_company" value="<?php echo esc_attr( $razao_social ); ?>" />
        </p>
       
        <p class="form-row form-row-wide">
            <label for="billing_cnpj"><?php esc_html_e( 'CNPJ', 'woocommerce' ); ?></label>
            <input type="text" class="input-text" name="billing_cnpj" id="billing_cnpj" value="<?php echo esc_attr( $cnpj ); ?>" />
        </p>
        <?php
    }
}
add_action( 'woocommerce_edit_account_form_start', 'custom_woocommerce_account_fields', 10 );
 
// Salva os campos personalizados (Razão Social e CNPJ)
function custom_save_woocommerce_account_fields($user_id) {
    // Verifica se os campos existem e salva os valores
    if (isset($_POST['billing_company'])) {
        update_user_meta($user_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
    }
 
    if (isset($_POST['billing_cnpj'])) {
        update_user_meta($user_id, 'billing_cnpj', sanitize_text_field($_POST['billing_cnpj']));
    }
}
add_action('woocommerce_save_account_details', 'custom_save_woocommerce_account_fields', 10, 1);
 
function custom_login_message_translation($translated_text, $text, $domain) {
    if ($text === 'Your account with %s is using a temporary password. We emailed you a link to change your password.') {
        $translated_text = 'Sua conta com %s está usando uma senha temporária. Enviamos um link para você alterá-la.';
    }
    return $translated_text;
}
add_filter('gettext', 'custom_login_message_translation', 20, 3);
 

 
// Categorias
function storebiz_customize_register($wp_customize) {
    // Adiciona uma seção
    $wp_customize->add_section('custom_category_order_section', array(
        'title' => 'Ordem das Categorias',
        'priority' => 160,
    ));
 
    // Pega todas as categorias principais
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0
    ]);
 
    $choices = [];
    foreach ($categories as $cat) {
        $choices[$cat->term_id] = $cat->name;
    }
 
    // Campo para ordenar categorias
    $wp_customize->add_setting('custom_category_order', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
 
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'custom_category_order',
        array(
            'label' => 'Ordem Manual das Categorias (IDs separados por vírgula)',
            'section' => 'custom_category_order_section',
            'type' => 'text',
            'description' => 'Exemplo: 3,8,2,5. Use os IDs das categorias principais na ordem desejada.',
        )
    ));
}
add_action('customize_register', 'storebiz_customize_register');

add_filter('woocommerce_add_to_cart_validation', 'limitar_quantidade_estoque', 10, 3);

function limitar_quantidade_estoque($is_valid, $product_id, $quantity) {
    $product = wc_get_product($product_id);
    $estoque_disponivel = $product->get_stock_quantity();

    // Verifica se a quantidade do produto no carrinho é maior que o estoque
    if ($quantity > $estoque_disponivel) {
        wc_add_notice(
            sprintf('Você não pode adicionar mais de %d unidades de %s no carrinho.', $estoque_disponivel, $product->get_name()),
            'error'
        );
        return false; // Bloqueia a adição ao carrinho
    }
    
    return $is_valid; // Permite a adição ao carrinho
}

// Função para controlar a exibição do endereço de entrega
function custom_cart_needs_shipping_address($needs_shipping) {
    if (is_checkout()) {
        // Verifica se é pessoa jurídica (tipo 2)
        if (isset($_POST['billing_persontype']) && $_POST['billing_persontype'] === '2') {
            return false;
        }
    }
    return $needs_shipping;
}
add_filter('woocommerce_cart_needs_shipping_address', 'custom_cart_needs_shipping_address');

// Adiciona JavaScript para controlar o checkbox e o tipo de pessoa
add_action('wp_footer', 'custom_checkout_person_type_script');
function custom_checkout_person_type_script() {
    if (is_checkout()) : ?>
        <script type="text/javascript">
            jQuery(function($) {
                // Função para controlar o estado do checkbox e tipo de pessoa
                function handleShippingAddress() {
                    var tipoPessoa = $('#billing_persontype').val();
                    var shippingCheckbox = $('#ship-to-different-address-checkbox');
                    var shippingWrapper = $('.shipping_address');
                    var shippingCheckboxWrapper = $('#ship-to-different-address');

                    if (tipoPessoa === '2') { // Pessoa Jurídica
                        // Desmarca e esconde o checkbox
                        shippingCheckbox.prop('checked', false);
                        shippingCheckboxWrapper.hide();
                        shippingWrapper.hide();
                        
                        // Força o WooCommerce a reconhecer que não precisa de endereço de entrega
                        $('input[name="ship_to_different_address"]').val('0');
                    } else { // Pessoa Física
                        // Mostra o checkbox
                        shippingCheckboxWrapper.show();
                    }
                }

                // Executa quando a página carrega
                handleShippingAddress();

                // Monitora mudanças no tipo de pessoa
                $(document.body).on('change', '#billing_persontype', function() {
                    handleShippingAddress();
                    // Não dispara update_checkout aqui para evitar o bug de voltar para pessoa física
                });

                // Previne que o checkbox seja marcado para pessoa jurídica
                $(document.body).on('change', '#ship-to-different-address-checkbox', function() {
                    if ($('#billing_persontype').val() === '2') {
                        $(this).prop('checked', false);
                        $('.shipping_address').hide();
                    }
                });

                // Monitora atualizações do checkout
                $(document.body).on('updated_checkout', function() {
                    handleShippingAddress();
                });
            });
        </script>
    <?php endif;
}

// Remove o checkbox de endereço de entrega para pessoa jurídica
add_filter('woocommerce_ship_to_different_address_checked', 'custom_ship_to_different_address_checked');
function custom_ship_to_different_address_checked($checked) {
    if (isset($_POST['billing_persontype']) && $_POST['billing_persontype'] === '2') {
        return false;
    }
    return $checked;
}

add_action('wp_footer', 'customizar_mensagem_input_quantidade');
function customizar_mensagem_input_quantidade() {
    if (is_product() || is_cart()) {
        $titulo = get_theme_mod('modal_quantidade_titulo', '🚨 ATENÇÃO: OPORTUNIDADE ESPECIAL PARA GRANDES PEDIDOS! 🚨');
        $destaque = get_theme_mod('modal_quantidade_destaque', 'Você acabou de superar o limite padrão (10 unidades) e isso é ótimo!');
        $vip = get_theme_mod('modal_quantidade_vip', '👉 Queremos oferecer condições VIP exclusivas para você:');
        $beneficio1 = get_theme_mod('modal_quantidade_beneficio1', 'Descontos progressivos (quanto mais comprar, maior o desconto!)');
        $beneficio2 = get_theme_mod('modal_quantidade_beneficio2', 'Valores personalizados abaixo da tabela');
        $beneficio3 = get_theme_mod('modal_quantidade_beneficio3', 'Pagamentos com vantagens (personalize conforme sua necessidade!)');
        $acao = get_theme_mod('modal_quantidade_acao', 'CLIQUE AQUI para falar com nosso time comercial AGORA:');
        $email = get_theme_mod('modal_quantidade_email', 'vendas.online@microware.com.br');
        $final = get_theme_mod('modal_quantidade_final', 'GARANTA SEU DESCONTO ANTES QUE O ESTOQUE ACABE! 🚀💵');
        $limite = get_theme_mod('modal_quantidade_limite', '10');
        ?>
        <style>
        #microware-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
        }
        #microware-modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        #microware-modal-close {
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        #microware-modal-content p {
            margin: 1em 0;
        }
        #copy-email {
            margin-top: 20px;
            padding: 12px 24px;
            background: #000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        #copy-email:hover {
            background: #333;
        }
        .email-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .email-link:hover {
            text-decoration: underline;
        }
        .beneficio-icone {
            color: #7c3aed;
            font-size: 1.1em;
            margin-right: 4px;
        }
        </style>
        <div id="microware-modal">
            <div id="microware-modal-content">
                <span id="microware-modal-close">&times;</span>
                <p><span style="font-size:1.2em;"><strong><?php echo esc_html($titulo); ?></strong></span></p>
                <p><?php echo esc_html($destaque); ?></p>
                <p><strong><?php echo esc_html($vip); ?></strong></p>
                <ul style="padding-left: 1.2em; margin: 0 0 1em 0;">
                    <li><span class="beneficio-icone">✔</span> <strong><?php echo esc_html($beneficio1); ?></strong></li>
                    <li><span class="beneficio-icone">✔</span> <strong><?php echo esc_html($beneficio2); ?></strong></li>
                    <li><span class="beneficio-icone">✔</span> <strong><?php echo esc_html($beneficio3); ?></strong></li>
                </ul>
                <p><strong><?php echo esc_html($acao); ?></strong></p>
                <p>📧 <a href="mailto:<?php echo esc_attr($email); ?>" class="email-link"><?php echo esc_html($email); ?></a></p>
                <p><strong style="font-size:1.1em;"><?php echo esc_html($final); ?></strong></p>
                <div style="text-align: center;">
                    <button id="copy-email">Copiar e-mail</button>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('microware-modal');
            const closeBtn = document.getElementById('microware-modal-close');
            const copyBtn = document.getElementById('copy-email');
            const emailText = '<?php echo esc_js($email); ?>';
            const limiteQuantidade = <?php echo esc_js($limite); ?>;
            document.querySelectorAll('input.qty').forEach(function (input) {
                input.setAttribute('max', limiteQuantidade);
                input.addEventListener('invalid', function (event) {
                    if (input.validity.rangeOverflow) {
                        input.setCustomValidity("Máximo de " + limiteQuantidade + " unidades por pedido.");
                        modal.style.display = 'block';
                    } else {
                        input.setCustomValidity("");
                    }
                });
                input.addEventListener('input', function () {
                    input.setCustomValidity("");
                });
            });
            closeBtn.onclick = function () {
                modal.style.display = 'none';
            }
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
            copyBtn.onclick = function () {
                navigator.clipboard.writeText(emailText).then(function () {
                    copyBtn.textContent = "E-mail copiado!";
                    setTimeout(() => copyBtn.textContent = "Copiar e-mail", 2000);
                });
            }
        });
        </script>
        <?php
    }
}

/**
 * Altera o texto do botão Adicionar ao Carrinho
 */
function custom_woocommerce_product_add_to_cart_text() {
    return __('Comprar', 'storebiz');
}
add_filter('woocommerce_product_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text');

function breadcrumb_personalizado() {
    if ( is_front_page() ) return;

    echo '<p id="breadcrumbs"><a href="' . esc_url(home_url()) . '">Início</a> &raquo; ';

    if ( is_singular('product') ) {
        global $post;
        $terms = get_the_terms($post->ID, 'product_cat');

        if ($terms && !is_wp_error($terms)) {
            // Vamos buscar a categoria com maior profundidade (mais específica)
            $deepest_term = null;
            $max_depth = -1;

            foreach ($terms as $term) {
                $depth = 0;
                $parent = $term->parent;

                while ($parent) {
                    $depth++;
                    $parent_term = get_term($parent, 'product_cat');
                    $parent = $parent_term->parent;
                }

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                    $deepest_term = $term;
                }
            }

            if ($deepest_term) {
                // Obter todos os ancestrais da subcategoria mais profunda
                $ancestors = get_ancestors($deepest_term->term_id, 'product_cat');
                $ancestors = array_reverse($ancestors);

                foreach ($ancestors as $ancestor_id) {
                    $ancestor = get_term($ancestor_id, 'product_cat');
                    echo '<a href="' . esc_url(get_term_link($ancestor)) . '">' . esc_html($ancestor->name) . '</a> &raquo; ';
                }

                echo '<a href="' . esc_url(get_term_link($deepest_term)) . '">' . esc_html($deepest_term->name) . '</a> &raquo; ';
            }
        }

        echo '<span>' . esc_html(get_the_title()) . '</span>';

    } elseif ( is_product_category() ) {
        $term = get_queried_object();
        $ancestors = get_ancestors($term->term_id, 'product_cat');
        $ancestors = array_reverse($ancestors);

        foreach ($ancestors as $ancestor_id) {
            $ancestor = get_term($ancestor_id, 'product_cat');
            echo '<a href="' . esc_url(get_term_link($ancestor)) . '">' . esc_html($ancestor->name) . '</a> &raquo; ';
        }

        echo '<span>' . esc_html($term->name) . '</span>';
    }

    echo '</p>';
}

// Adiciona seção de configurações do modal de quantidade no personalizador
function storebiz_customize_register_modal_quantidade($wp_customize) {
    $wp_customize->add_section('modal_quantidade_section', array(
        'title'    => __('Configurações do Modal de Quantidade', 'storebiz'),
        'priority' => 30,
    ));

    // Título
    $wp_customize->add_setting('modal_quantidade_titulo', array(
        'default'           => '🚨 ATENÇÃO: OPORTUNIDADE ESPECIAL PARA GRANDES PEDIDOS! 🚨',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_titulo', array(
        'label'    => __('Título', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Mensagem de destaque
    $wp_customize->add_setting('modal_quantidade_destaque', array(
        'default'           => 'Você acabou de superar o limite padrão (10 unidades) e isso é ótimo!',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_destaque', array(
        'label'    => __('Mensagem de Destaque', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Chamada VIP
    $wp_customize->add_setting('modal_quantidade_vip', array(
        'default'           => '👉 Queremos oferecer condições VIP exclusivas para você:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_vip', array(
        'label'    => __('Chamada VIP', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Benefícios
    $wp_customize->add_setting('modal_quantidade_beneficio1', array(
        'default'           => 'Descontos progressivos (quanto mais comprar, maior o desconto!)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_beneficio1', array(
        'label'    => __('Benefício 1', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('modal_quantidade_beneficio2', array(
        'default'           => 'Valores personalizados abaixo da tabela',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_beneficio2', array(
        'label'    => __('Benefício 2', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('modal_quantidade_beneficio3', array(
        'default'           => 'Pagamentos com vantagens (personalize conforme sua necessidade!)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_beneficio3', array(
        'label'    => __('Benefício 3', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Chamada para ação
    $wp_customize->add_setting('modal_quantidade_acao', array(
        'default'           => 'CLIQUE AQUI para falar com nosso time comercial AGORA:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_acao', array(
        'label'    => __('Chamada para Ação', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // E-mail
    $wp_customize->add_setting('modal_quantidade_email', array(
        'default'           => 'vendas.online@microware.com.br',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('modal_quantidade_email', array(
        'label'    => __('E-mail de Contato', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'email',
    ));

    // Mensagem final
    $wp_customize->add_setting('modal_quantidade_final', array(
        'default'           => 'GARANTA SEU DESCONTO ANTES QUE O ESTOQUE ACABE! 🚀💵',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_final', array(
        'label'    => __('Mensagem Final', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Limite de quantidade
    $wp_customize->add_setting('modal_quantidade_limite', array(
        'default'           => '10',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('modal_quantidade_limite', array(
        'label'    => __('Limite de Quantidade', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 100,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'storebiz_customize_register_modal_quantidade');
