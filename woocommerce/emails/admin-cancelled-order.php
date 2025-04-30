<?php
/**
 * E-mail de pedido cancelado para o administrador
 *
 * Este template pode ser sobrescrito copiando-o para seu tema em:
 * yourtheme/woocommerce/emails/admin-cancelled-order.php.
 *
 * NO ENTANTO, ocasionalmente o WooCommerce precisará atualizar os arquivos de template,
 * e você (o desenvolvedor do tema) precisará copiar os novos arquivos para o seu tema
 * para manter a compatibilidade. Tentamos fazer isso o mínimo possível, mas pode acontecer.
 * Quando isso ocorrer, a versão do arquivo de template será atualizada e o readme listará
 * quaisquer mudanças importantes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 9.8.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Exibe o cabeçalho do e-mail
*/
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
echo $email_improvements_enabled ? '<div class="email-introduction">' : '';
/* tradutores: %1$s: Número do pedido. %2$s: Nome completo do cliente */
$text = __( 'Notificação para informar que o pedido #%1$s pertencente a %2$s foi cancelado:', 'woocommerce' );
if ( $email_improvements_enabled ) {
	/* tradutores: %1$s: Número do pedido. %2$s: Nome completo do cliente */
	$text = __( 'Estamos entrando em contato para informar que o pedido #%1$s de %2$s foi cancelado.', 'woocommerce' );
}
?>
<p><?php printf( esc_html( $text ), esc_html( $order->get_order_number() ), esc_html( $order->get_formatted_billing_full_name() ) ); ?></p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/*
 * @hooked WC_Emails::order_details() Exibe a tabela de detalhes do pedido.
 * @hooked WC_Structured_Data::generate_order_data() Gera dados estruturados.
 * @hooked WC_Structured_Data::output_structured_data() Exibe dados estruturados.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Exibe os metadados do pedido.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Exibe os detalhes do cliente
 * @hooked WC_Emails::email_address() Exibe o endereço de e-mail
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Exibe o conteúdo adicional definido pelo usuário - configurado nas configurações de cada e-mail.
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
