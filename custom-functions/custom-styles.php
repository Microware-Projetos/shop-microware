<?php
/**
 * Estilos Personalizados Globais
 * 
 * Este arquivo gerencia os estilos CSS personalizados que são aplicados
 * globalmente em todos os sites do multisite WordPress.
 * 
 * @package Storebiz
 * @since 1.0.0
 */

// Previne acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Função para adicionar estilos personalizados globalmente em todos os sites do multisite
 */
function storebiz_add_global_custom_styles() {
    // Verifica se o arquivo CSS personalizado existe
    $custom_css_file = get_template_directory() . '/assets/css/custom-styles.css';
    
    if (file_exists($custom_css_file)) {
        // Se o arquivo existe, carrega ele normalmente (já está sendo feito no enqueue.php)
        return;
    } else {
        // Se o arquivo não existir, adiciona os estilos inline como fallback
        $custom_css = '
        .shop-categories-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px #ddd;
            padding: 20px;
            height: 100%;
        }

        .category-title {
            background-color: var(--bs-primary);
            color: white;
            padding: 10px 15px;
            font-size: 18px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .shop-categories-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .shop-categories-list li {
            margin-bottom: 10px;
        }

        .shop-categories-list li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 8px 12px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .shop-categories-list li a:hover {
            background-color: #f5f5f5;
            color: var(--bs-primary);
        }

        .shop-banner-box img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }

        .woocommerce-checkout .woocommerce {
            background-color: #f9f9f9;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .woocommerce-checkout .col2-set {
            display: flex;
            flex-direction: column;
        }

        .woocommerce-checkout .col-1,
        .woocommerce-checkout .col-2 {
            width: 100% !important;
            margin: 0 0 2rem 0;
        }

        .wp-post-image {
            padding: 20px;
            box-sizing: border-box;
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        ul.products li.product {
          height: 100%;
          display: flex;
        }

        ul.products li.product > .product {
          display: flex;
          flex-direction: column;
          justify-content: space-between;
          height: 100%;
          width: 100%;
          background: #fff;
          padding: 10px;
          box-sizing: border-box;
        }

        .product-content-outer {
          flex: 1;
          display: flex;
          flex-direction: column;
          justify-content: space-between;
        }

        .product-content h3 {
          line-height: 1.6em;
          height: 3.2em;
          overflow: hidden;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          margin-bottom: 10px;
        }

        .product-img {
          height: 250px;
          display: flex;
          align-items: center;
          justify-content: center;
          overflow: hidden;
        }

        .product-img img {
          max-height: 100%;
          width: auto;
          object-fit: contain;
        }

        form.cart button#idx-calc_shipping {
            margin-top: 5px;
            margin-right: 5px;
            margin-top: 30px;
        }';
        
        wp_add_inline_style('storebiz-main', $custom_css);
    }
}

/**
 * Função para adicionar estilos CSS personalizados via arquivo
 */
function storebiz_enqueue_custom_styles() {
    // Carrega os estilos personalizados globais
    wp_enqueue_style(
        'storebiz-custom-styles', 
        get_template_directory_uri() . '/assets/css/custom-styles.css', 
        array(), 
        '1.0.0'
    );
}

// Hooks
add_action('wp_enqueue_scripts', 'storebiz_enqueue_custom_styles', 15);
add_action('wp_enqueue_scripts', 'storebiz_add_global_custom_styles', 20); 

