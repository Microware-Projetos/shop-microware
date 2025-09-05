<?php
/**
 * Mini-cart Moderno
 *
 * Substitui o mini-cart padrão com design moderno, hover animado e badges elegantes.
 *
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>

    <ul class="woocommerce-mini-cart modern-cart-list">
        <?php
        do_action( 'woocommerce_before_mini_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                
                // Imagem padrão baseada na categoria
                $placeholder_image = get_site_url() . '/wp-content/themes/storebiz/assets/images/Acessórios.png';
                if (has_term('desktop', 'product_cat', $product_id)) $placeholder_image = get_site_url() . '/wp-content/themes/storebiz/assets/images/Desktop.png';
                if (has_term('notebook', 'product_cat', $product_id)) $placeholder_image = get_site_url() . '/wp-content/themes/storebiz/assets/images/Desktop.png';
                if (has_term('Acessórios', 'product_cat', $product_id)) $placeholder_image = get_site_url() . '/wp-content/themes/storebiz/assets/images/Acessórios.png';
                if (has_term('Serviço', 'product_cat', $product_id)) $placeholder_image = get_site_url() . '/wp-content/themes/storebiz/assets/images/Serviço.png';

                $product_image = $_product->get_image();
                if (empty($product_image) || strpos($product_image, 'placeholder') !== false) {
                    $product_image = '<img src="' . esc_url($placeholder_image) . '" alt="' . esc_attr($product_name) . '" class="modern-cart-thumb" />';
                }
                
                $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $product_image, $cart_item, $cart_item_key );
                $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                <li class="modern-cart-item">
                    <?php
                    echo apply_filters(
                        'woocommerce_cart_item_remove_link',
                        sprintf(
                            '<a href="%s" class="remove modern-remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                            esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                            esc_attr( $product_id ),
                            esc_attr( $cart_item_key ),
                            esc_attr( $_product->get_sku() )
                        ),
                        $cart_item_key
                    );
                    ?>

                    <?php echo $thumbnail; ?>
                    
                    <div class="modern-cart-content">
                        <?php if ( empty( $product_permalink ) ) : ?>
                            <span class="modern-cart-name"><?php echo wp_kses_post($product_name); ?></span>
                        <?php else : ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>" class="modern-cart-name-link">
                                <span class="modern-cart-name"><?php echo wp_kses_post($product_name); ?></span>
                            </a>
                        <?php endif; ?>
                        
                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                        <span class="modern-cart-qty"><?php echo sprintf('%s × %s', $cart_item['quantity'], $product_price); ?></span>
                    </div>
                </li>
                <?php
            }
        }

        do_action( 'woocommerce_mini_cart_contents' );
        ?>
    </ul>

    <p class="modern-cart-total">
        <?php do_action( 'woocommerce_widget_shopping_cart_total' ); ?>
    </p>

    <div class="modern-cart-buttons">
        <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-primary btn-cart"><?php esc_html_e('Ver Carrinho','storebiz'); ?></a>
        <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-primary btn-checkout"><?php esc_html_e('Finalizar Compra','storebiz'); ?></a>
    </div>

    <style>
        /* Mini-cart moderno */
        .modern-cart-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .modern-cart-item {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            padding: 16px 40px 16px 16px;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
            background: #fff;
            transition: all 0.3s ease;
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            gap: 12px;
        }

        .modern-cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .modern-cart-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .modern-cart-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .modern-cart-name {
            font-weight: 600;
            font-size: 14px;
            line-height: 1.3;
            color: #333;
            margin: 0;
            word-wrap: break-word;
        }

        .modern-cart-name-link {
            text-decoration: none;
            color: inherit;
        }

        .modern-cart-name-link:hover .modern-cart-name {
            color: #007bff;
        }

        .modern-remove {
            position: absolute;
            top: 6px;
            right: 6px;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.95);
            color: #999;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            backdrop-filter: blur(4px);
            z-index: 10;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .modern-remove:hover {
            background: #e74c3c;
            color: #fff;
            border-color: #c0392b;
            transform: scale(1.05);
            box-shadow: 0 2px 6px rgba(231, 76, 60, 0.3);
        }

        .modern-remove:active {
            transform: scale(0.95);
        }

        .modern-cart-total {
            font-weight: 600;
            text-align: center;
            margin: 12px 0;
            font-size: 16px;
        }

        .modern-cart-buttons {
            display: flex;
            gap: 12px;
            flex-direction: column;
            padding: 16px 12px 12px 12px;
            margin-top: 8px;
        }

        .modern-cart-buttons .btn {
            width: 100%;
            border-radius: 8px;
            padding: 14px 20px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .modern-cart-buttons .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .modern-cart-buttons .btn:hover::before {
            left: 100%;
        }

        .modern-cart-buttons .btn-cart {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .modern-cart-buttons .btn-cart:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .modern-cart-buttons .btn-checkout {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border: 1px solid #0056b3;
        }

        .modern-cart-buttons .btn-checkout:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.3);
        }

        .modern-cart-buttons .btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @media (max-width: 480px) {
            .modern-cart-item {
                padding: 12px 35px 12px 12px;
                gap: 10px;
            }

            .modern-cart-thumb {
                width: 60px;
                height: 60px;
                border-radius: 8px;
                margin-top: 2px;
            }

            .modern-cart-name {
                font-size: 13px;
            }

            .modern-cart-qty {
                font-size: 12px;
            }

            .modern-remove {
                width: 18px;
                height: 18px;
                font-size: 10px;
                top: 4px;
                right: 4px;
            }

            .modern-cart-buttons {
                padding: 12px 8px 8px 8px;
                gap: 10px;
            }

            .modern-cart-buttons .btn {
                padding: 12px 16px;
                font-size: 13px;
                border-radius: 6px;
            }
        }

        @media (max-width: 360px) {
            .modern-cart-buttons {
                padding: 10px 6px 6px 6px;
                gap: 8px;
            }

            .modern-cart-buttons .btn {
                padding: 10px 12px;
                font-size: 12px;
            }
        }
    </style>

<?php else : ?>

    <p class="modern-cart-empty"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
