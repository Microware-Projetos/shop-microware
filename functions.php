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
			function toggleFileUpload() {
				var selectedPayment = $('input[name="payment_method"]:checked').val();
				if (selectedPayment === 'cheque') {
					$('#custom-file-upload-wrapper').slideDown();
				} else {
					$('#custom-file-upload-wrapper').slideUp();
				}
			}

			toggleFileUpload();

			$('form.checkout').on('change', 'input[name="payment_method"]', toggleFileUpload);
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
    }
}
add_action('customize_register', 'storebiz_customize_register_banners');

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
                delay: 5000
            }
        });
    ");
}
add_action('wp_enqueue_scripts', 'storebiz_load_swiper_assets');
