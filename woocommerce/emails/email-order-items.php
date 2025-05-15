<?php
/**
 * Email Order Items
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';

foreach ( $items as $item_id => $item ) :
	$product = $item->get_product();
	$purchase_note = $product ? $product->get_purchase_note() : '';
	$product_image = $item->get_meta('_product_image');
	?>
	<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
			<?php
			// Exibe a imagem do produto
			if ($product_image) {
				echo $product_image;
			}

			// Nome do produto
			echo wp_kses_post( apply_filters( 'woocommerce_order_item_name', $item->get_name(), $item, false ) );

			// Quantidade
			echo ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', esc_html( $item->get_quantity() ) ) . '</strong>';

			// Meta dados
			do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

			wc_display_item_meta( $item, array(
				'before'       => '<div class="wc-item-meta"><div>',
				'after'        => '</div></div>',
				'separator'    => '</div><div>',
				'label_before' => '<strong class="wc-item-meta-label">',
				'label_after'  => ':</strong> ',
			) );

			do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
			?>
		</td>
		<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			<?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
		</td>
	</tr>
	<?php if ( $show_purchase_note && $purchase_note ) : ?>
	<tr>
		<td colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
			<?php echo wp_kses_post( wpautop( do_shortcode( $purchase_note ) ) ); ?>
		</td>
	</tr>
	<?php endif; ?>
<?php endforeach; ?>