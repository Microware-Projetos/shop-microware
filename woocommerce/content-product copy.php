<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

// Personalização: Adicionar classes CSS baseadas nas categorias do produto
$terms = get_the_terms($post->ID,'product_cat');
if (is_array($terms) && count($terms)) {
	$count = count($terms);
} else {
	$count = 0;
}
$i=0;
if ($count > 0) {
	$term_list = '';
	foreach ($terms as $storebiz_product_term) {
		$i++;
		if ($storebiz_product_term->parent==0) {
			$term_list .= str_replace(' ', '-', strtolower($storebiz_product_term->name));
			if ($count != $i) $term_list .= ' ';
		}
	}
	?>
	<li <?php wc_product_class( strtolower($term_list).'', $product ); ?>>
	<?php } else { ?>
		<li <?php wc_product_class( '', $product ); ?>>
	<?php } ?>
		<div class="product">
			<div class="product-single">
				<div class="product-bg"></div>
				<div class="product-img">
					<?php
					/**
					 * Hook: woocommerce_before_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_open - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item' );
					?>
					<a href="<?php echo esc_url(the_permalink()); ?>">
					<?php
					// Personalização: Suporte para imagem externa
					$external_image = get_post_meta(get_the_ID(), '_external_image_url', true);

					if ($external_image) {
						echo '<img src="' . esc_url($external_image) . '" class="wp-post-image rounded-image" alt="' . esc_attr(get_the_title()) . '" />';
					} elseif (has_post_thumbnail()) {
						// fallback para a imagem destacada
						the_post_thumbnail('', array('class' => 'rounded-image'));
					} else {
						// fallback para a imagem placeholder do WooCommerce, agora usando SVG com logo do cliente
						$svg_path = WP_CONTENT_DIR . '/uploads/banner-logos.svg';
						if (file_exists($svg_path)) {
							$svg_content = file_get_contents($svg_path);
							// Pegue a logo do cliente (exemplo: custom logo do tema)
							if (has_custom_logo()) {
								$custom_logo_id = get_theme_mod('custom_logo');
								$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
								$logo_cliente_1 = esc_url($logo[0]);
							} else {
								$logo_cliente_1 = '';
							}
							// Substitui o placeholder no SVG
							$svg_content = str_replace('{{logo_cliente_1}}', $logo_cliente_1, $svg_content);
							// Exibe o SVG inline
							echo '<div style="width: 100%; height: auto;">' . $svg_content . '</div>';
						} else {
							// Fallback caso o SVG não exista
							$placeholder_image = get_site_url() . '/wp-content/uploads/product_holder.svg';
							echo '<img src="' . esc_url($placeholder_image) . '" class="wp-post-image rounded-image" alt="' . esc_attr(get_the_title()) . '" />';
						}
					}
					?>
					</a>
					<?php if ( $product->is_on_sale() ) : ?>
						<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sale-ribbon"><span class="tag-line">' . esc_html__( 'Sale', 'storebiz' ) . '</span></div>', $post, $product ); ?>
					<?php endif; ?>
				</div>
				<div class="product-content-outer">
					<div class="product-content">
						<div class="pro-rating">
							<?php if ($average = $product->get_average_rating()) : ?>
								<?php echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'storebiz' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'storebiz' ).'</span></div>'; ?>
							<?php endif; ?>
						</div>
						<h3><a href="<?php echo esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>
						<div class="price">
							<?php echo $product->get_price_html(); ?>
						</div>
					</div>
					<div class="product-action">			
						<?php
						/**
						 * Hook: woocommerce_after_shop_loop_item.
						 *
						 * @hooked woocommerce_template_loop_product_link_close - 5
						 * @hooked woocommerce_template_loop_add_to_cart - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item' );
						?>
					</div>
				</div>
			</div>
		</div>
	</li>
