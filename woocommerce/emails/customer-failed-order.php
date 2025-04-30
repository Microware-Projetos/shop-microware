<?php
/**
 * E-mail de pedido falhado para o cliente
 *
 * Este template pode ser substituído copiando-o para seutheme/woocommerce/emails/customer-failed-order.php.
 *
 * NO ENTANTO, ocasionalmente, o WooCommerce precisará atualizar os arquivos de template e você
 * (o desenvolvedor do tema) precisará copiar os novos arquivos para seu tema para
 * manter a compatibilidade. Tentamos fazer isso o mínimo possível, mas isso acontece.
 * Quando isso ocorrer, a versão do arquivo de template será aumentada e
 * o arquivo README listará quaisquer alterações importantes.
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

/**
 * Hook para o cabeçalho do e-mail do WooCommerce.
 *
 * @hooked WC_Emails::email_header() Exibe o cabeçalho do e-mail
 * @since 3.7.0
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>
<p>
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	/* tradutores: %s: Primeiro nome do cliente */
	printf( esc_html__( 'Olá %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Olá,', 'woocommerce' ) );
}
?>
</p>
<p><?php esc_html_e( "Infelizmente, não conseguimos concluir seu pedido devido a um problema com o seu método de pagamento.", 'woocommerce' ); ?></p>
<?php /* tradutores: %s: Título do site */ ?>
<p><?php printf( esc_html__( "Se você gostaria de continuar com sua compra, por favor, retorne para %s e tente um método de pagamento diferente.", 'woocommerce' ), esc_html( $blogname ) ); ?></p>
<p><?php esc_html_e( 'Os detalhes do seu pedido são os seguintes:', 'woocommerce' ); ?></p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/**
 * Hook para os detalhes do pedido no e-mail.
 *
 * @hooked WC_Emails::order_details() Exibe a tabela de detalhes do pedido.
 * @hooked WC_Structured_Data::generate_order_data() Gera dados estruturados.
 * @hooked WC_Structured_Data::output_structured_data() Exibe dados estruturados.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook para os metadados do pedido no e-mail.
 *
 * @hooked WC_Emails::order_meta() Exibe os metadados do pedido.
 * @since 1.0.0
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook para os detalhes do cliente no e-mail.
 *
 * @hooked WC_Emails::customer_details() Exibe os detalhes do cliente
 * @hooked WC_Emails::email_address() Exibe o endereço de e-mail
 * @since 1.0.0
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Exibe conteúdo adicional definido pelo usuário - isso é configurado nas configurações de cada e-mail.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/**
 * Hook para o rodapé do e-mail do WooCommerce.
 *
 * @hooked WC_Emails::email_footer() Exibe o rodapé do e-mail
 * @since 3.7.0
 */
do_action( 'woocommerce_email_footer', $email );
?>
