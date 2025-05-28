/**
 * Customer PIX paid email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-pix-paid.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;
use Piggly\WooPixGateway\Core\Entities\PixEntity;

if ( !defined('ABSPATH') ) { exit; }

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/** @var PixEntity $pix */

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<p>
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	/* translators: %s: Customer first name */
	printf( esc_html__( 'Olá %s,', 'wc-piggly-pix' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Olá,', 'wc-piggly-pix' ) );
}
?>
</p>
<p><?php printf( esc_html__( 'O pagamento do seu pedido #%s no valor de %s foi concluído com sucesso.', 'wc-piggly-pix' ), esc_html( $order->get_order_number() ), \wc_price($pix->getAmount()) ); ?></p>
<p><?php printf(__( '<a href="%s">Clique aqui</a> para visualizar seu pedido', 'wc-piggly-pix' ), $order->get_view_order_url()); ?></p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

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