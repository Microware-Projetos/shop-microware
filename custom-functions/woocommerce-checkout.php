<?php
/**
 * Funcionalidades de Checkout Personalizadas
 * 
 * Este arquivo contém todas as funções relacionadas ao checkout
 * personalizado, incluindo campos obrigatórios e validações.
 */

// Tornar o campo Bairro obrigatório no WooCommerce
function custom_make_bairro_required( $fields ) {
    $fields['billing']['billing_neighborhood']['required'] = true;
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'custom_make_bairro_required' );

// Personalizar campo empresa
add_filter( 'woocommerce_checkout_fields', 'customizar_campo_empresa' );

function customizar_campo_empresa( $fields ) {
    // Deixa o campo visível, mas com uma classe personalizada para esconder via JS
    $fields['billing']['billing_company']['required'] = false; // Deixa opcional no PHP
    $fields['billing']['billing_company']['label'] = 'Empresa (Razão Social)';
    $fields['billing']['billing_company']['class'] = array('form-row-wide', 'empresa-field'); // Classe personalizada
    $fields['billing']['billing_company']['priority'] = 30;
    return $fields;
}

// Mostrar empresa apenas para pessoa jurídica
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

// Controlar endereço de entrega para pessoa jurídica
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

// Script para controlar checkbox e tipo de pessoa
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

// Atualizar checkout quando método de pagamento muda
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

// Limitar quantidade de estoque
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

// Personalizar thumbnail do carrinho
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

// Ordenar produtos por preço (maior para menor)
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

// Alterar texto do botão Adicionar ao Carrinho
function custom_woocommerce_product_add_to_cart_text() {
    return __('Comprar', 'storebiz');
}
add_filter('woocommerce_product_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'custom_woocommerce_product_add_to_cart_text');

add_action('widgets_init', function () {
    unregister_sidebar('woocommerce-sidebar'); // tente isso primeiro
    unregister_sidebar('sidebar-woocommerce');
    unregister_sidebar('woocommerce_widget_area');
});

function esconder_widgets_no_checkout_carrinho() {
    if (is_cart() || is_checkout()) {
        echo '<style>
            .sidebar { display: none !important; }
        </style>';
    }
}
add_action('wp_head', 'esconder_widgets_no_checkout_carrinho');
