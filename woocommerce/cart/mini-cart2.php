<?php
/**
 * Mini-cart
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<ul class="woocommerce-mini-cart cart_list product_list_widget cart-items shopping-cart-items mobile-friendly">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> mobile-cart-item">
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						'woocommerce_cart_item_remove_link',
						sprintf(
							'<a href="%s" class="remove remove_from_cart_button mobile-remove-btn" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'storebiz' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						),
						$cart_item_key
					);
					?>
					<?php if ( empty( $product_permalink ) ) : ?>
						<div class="item-img mobile-item-img">
							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<span class="item-name mobile-item-name">
							<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="mobile-product-link">
							<div class="item-img mobile-item-img">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<span class="item-name mobile-item-name">
								<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</a>
					<?php endif; ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity item-price mobile-quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<div class="shopping-cart-header mobile-cart-header">
		<div class="shopping-cart-total mobile-cart-total">
			<span class="lighter-text"><?php _e( 'Sub Total:', 'storebiz' ); ?></span>
			<span class="main-color-text"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</div>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<div class="shoppingcart-bottom mobile-cart-buttons">
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-primary mobile-cart-btn"><?php echo esc_html_e('Cart','storebiz'); ?></a>
		</div>
		<div class="shoppingcart-bottom mobile-cart-buttons">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-primary mobile-checkout-btn"><?php echo esc_html_e('Checkout','storebiz'); ?></a>
		</div>

		<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message mobile-empty-message"><?php esc_html_e( 'No products in the cart.', 'storebiz' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>

<style>
@media screen and (max-width: 768px) {
    .mobile-friendly {
        padding: 10px;
    }
    
    .mobile-cart-item {
        display: flex;
        flex-direction: column;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .mobile-item-img {
        width: 80px;
        height: 80px;
        margin-bottom: 10px;
    }
    
    .mobile-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .mobile-item-name {
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .mobile-quantity {
        font-size: 13px;
        color: #666;
    }
    
    .mobile-remove-btn {
        position: absolute;
        right: 0;
        top: 10px;
        font-size: 20px;
        padding: 5px;
    }
    
    .mobile-cart-header {
        padding: 15px;
    }
    
    .mobile-cart-total {
        font-size: 16px;
        margin-bottom: 15px;
    }
    
    .mobile-cart-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .mobile-cart-btn,
    .mobile-checkout-btn {
        width: 100%;
        padding: 12px;
        text-align: center;
        font-size: 16px;
    }
    
    .mobile-empty-message {
        text-align: center;
        padding: 20px;
        font-size: 16px;
    }
}
</style>

<?php 
/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
<div class="shopping-cart mobile-friendly">
	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<ul class="woocommerce-mini-cart cart_list product_list_widget cart-items shopping-cart-items mobile-friendly">
			<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> mobile-cart-item">
						<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button mobile-remove-btn" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr__( 'Remove this item', 'storebiz' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						?>
						<?php if ( empty( $product_permalink ) ) : ?>
							<div class="item-img mobile-item-img">
								<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<span class="item-name mobile-item-name">
								<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>" class="mobile-product-link">
								<div class="item-img mobile-item-img">
									<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
								<span class="item-name mobile-item-name">
									<?php echo $product_name; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
							</a>
						<?php endif; ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity item-price mobile-quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</li>
					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
			?>
		</ul>
		<div class="shopping-cart-header mobile-cart-header">
			<div class="shopping-cart-total mobile-cart-total">
				<span class="lighter-text"><?php _e( 'Sub Total:', 'storebiz' ); ?></span>
				<span class="main-color-text"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
			</div>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<div class="shoppingcart-bottom mobile-cart-buttons">
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-primary mobile-cart-btn"><?php echo esc_html_e('Cart','storebiz'); ?></a>
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-primary mobile-checkout-btn"><?php echo esc_html_e('Checkout','storebiz'); ?></a>
			</div>
			<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
		</div>
	<?php else : ?>

		<p class="woocommerce-mini-cart__empty-message mobile-empty-message"><?php esc_html_e( 'No products in the cart.', 'storebiz' ); ?></p>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>	
	<?php
	$fragments['div.shopping-cart'] = ob_get_clean();
	return $fragments;
}
