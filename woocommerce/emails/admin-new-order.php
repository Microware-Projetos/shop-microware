<?php
/**
 * E-mail de novo pedido para o administrador
 *
 * Este template pode ser sobrescrito ao copiá-lo para yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * @package WooCommerce\Templates\Emails\HTML
 * @version 9.8.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

defined( 'ABSPATH' ) || exit;

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Exibe o cabeçalho do e-mail
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
echo $email_improvements_enabled ? '<div class="email-introduction">' : '';

$text = __( 'Você recebeu o seguinte pedido de %s:', 'woocommerce' );
if ( $email_improvements_enabled ) {
	$text = __( 'Você recebeu um novo pedido de %s:', 'woocommerce' );
}
?>
<p><?php printf( esc_html( $text ), esc_html( $order->get_formatted_billing_full_name() ) ); ?></p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/*
 * @hooked WC_Emails::order_details() Mostra os detalhes do pedido.
 * @hooked WC_Structured_Data::generate_order_data() Gera os dados estruturados.
 * @hooked WC_Structured_Data::output_structured_data() Exibe os dados estruturados.
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Mostra os metadados do pedido.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Mostra os dados do cliente
 * @hooked WC_Emails::email_address() Mostra o e-mail do cliente
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Conteúdo adicional definido pelo usuário - configurado nas opções de cada e-mail.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Exibe o rodapé do e-mail
 */
do_action( 'woocommerce_email_footer', $email );
