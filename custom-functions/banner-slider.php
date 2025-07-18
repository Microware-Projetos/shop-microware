<?php
/**
 * Funcionalidades de Banner/Slider
 * 
 * Este arquivo contém todas as funções relacionadas ao sistema
 * de banners e sliders da loja.
 */

// Registrar configurações de banner no customizer
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

// Carregar assets do Swiper
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

// Carregar estilos CSS personalizados
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


