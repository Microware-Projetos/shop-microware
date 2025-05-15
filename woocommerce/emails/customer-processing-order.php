<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 9.8.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Função para obter a imagem do produto (externa ou padrão)
function get_product_image_for_email($product) {
    $external_image = get_post_meta($product->get_id(), '_external_image_url', true);
    
    if ($external_image) {
        return '<img src="' . esc_url($external_image) . '" style="width: 100px; height: auto; margin-right: 10px;" />';
    }
    
    // Se não houver imagem externa, usa a imagem padrão do WooCommerce
    return $product->get_image('thumbnail');
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<p>
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	/* translators: %s: Customer first name */
	printf( esc_html__( 'Olá %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Olá,', 'woocommerce' ) );
}
?>
</p>

<p><?php esc_html_e( 'Obrigado pelo seu pedido na loja Microware!', 'woocommerce' ); ?></p>

<p><?php esc_html_e( 'Recebemos seu pedido e ele está atualmente em espera até que possamos confirmar que seu pagamento foi processado.', 'woocommerce' ); ?></p>

<p><?php esc_html_e( 'Assim que a sua encomenda for enviada você irá receber um código para que possa acompanhar seu pedido.', 'woocommerce' ); ?></p>

<p><?php esc_html_e( 'Aqui está um lembrete do que você pediu:', 'woocommerce' ); ?></p>

<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

// Adiciona imagens aos itens do pedido no email
add_filter('woocommerce_email_order_items_table', function($table, $order, $args) {
    foreach ($order->get_items() as $item) {
        $product = $item->get_product();
        if ($product) {
            $image = get_product_image_for_email($product);
            $item->set_meta('_product_image', $image);
        }
    }
    return $table;
}, 10, 3);

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
