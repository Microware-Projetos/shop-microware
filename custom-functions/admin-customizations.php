<?php
/**
 * Personalizações do Painel Administrativo
 * 
 * Este arquivo contém todas as funções relacionadas às
 * personalizações do painel administrativo do WordPress.
 */

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

// Função para obter a imagem do produto (externa ou padrão)
function get_product_image_url($product_id, $size = 'full') {
    // Primeiro verifica se existe imagem externa
    $external_image = get_post_meta($product_id, '_external_image_url', true);
    
    if ($external_image) {
        return $external_image;
    }
    
    // Se não houver imagem externa, usa a imagem padrão do WooCommerce
    $product = wc_get_product($product_id);
    if ($product) {
        $image_id = $product->get_image_id();
        if ($image_id) {
            $image_url = wp_get_attachment_image_url($image_id, $size);
            return $image_url;
        }
    }
    
    // Fallback para placeholder
    return wc_placeholder_img_src($size);
}

// Filtro para usar imagem externa em miniaturas
add_filter('woocommerce_product_get_image', 'use_external_image_in_thumbnails', 10, 2);

function use_external_image_in_thumbnails($image, $product) {
    if (!$product) return $image;
    
    $external_image = get_post_meta($product->get_id(), '_external_image_url', true);
    
    if ($external_image) {
        // Cria uma nova imagem HTML com a URL externa
        $image_html = sprintf(
            '<img src="%s" alt="%s" class="wp-post-image" />',
            esc_url($external_image),
            esc_attr($product->get_name())
        );
        return $image_html;
    }
    
    return $image;
}

// Filtro para usar imagem externa na galeria
add_filter('woocommerce_single_product_image_thumbnail_html', 'use_external_image_in_gallery', 10, 2);

function use_external_image_in_gallery($html, $post_thumbnail_id) {
    global $product;
    
    if (!$product) return $html;
    
    $external_image = get_post_meta($product->get_id(), '_external_image_url', true);
    
    if ($external_image) {
        // Substitui a imagem da galeria pela externa
        $html = sprintf(
            '<div class="woocommerce-product-gallery__image">' .
            '<img src="%s" alt="%s" class="wp-post-image" />' .
            '</div>',
            esc_url($external_image),
            esc_attr($product->get_name())
        );
    }
    
    return $html;
}

// Configurações de categorias no customizer
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

// Breadcrumb personalizado
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