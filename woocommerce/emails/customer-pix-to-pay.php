<?php
/**
 * Verify account e-mail.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/wc-bdm-verify-account.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

use Piggly\WooPixGateway\Core\Endpoints;

if ( !defined('ABSPATH') ) { exit; }
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( esc_html__( 'Olá %s,', 'wc-piggly-pix' ), esc_html( $order->get_billing_first_name() ) ); ?></p>

<p><?php printf( esc_html__( 'Falta pouco! Conclua seu pedido #%s com o Pix', 'wc-piggly-pix' ), esc_html( $order->get_order_number() ) ); ?></p>

<p><?php printf( esc_html__( 'O código Pix do seu pedido #%s foi gerado. Para garantir a conclusão da sua compra, realize o pagamento até %s.', 'wc-piggly-pix' ), 
    esc_html( $order->get_order_number() ),
    esc_html( date_i18n( get_option('date_format'), strtotime('+1 day') ) )
); ?></p>

<h2><?php esc_html_e( 'Como pagar:', 'wc-piggly-pix' ); ?></h2>

<p><?php esc_html_e( 'Via QR Code: Aponte a câmera do app do seu banco para o código abaixo.', 'wc-piggly-pix' ); ?></p>
<p><?php esc_html_e( 'Via Código Pix: Copie e cole a chave no seu internet banking ou app de pagamento.', 'wc-piggly-pix' ); ?></p>

<div style="margin: 20px 0; padding: 15px; background-color: #f8f8f8; border-radius: 5px;">
    <p style="margin: 0;"><strong><?php esc_html_e( 'Código Pix (copiar e colar):', 'wc-piggly-pix' ); ?></strong></p>
    <p style="margin: 10px 0; padding: 10px; background-color: #fff; border: 1px solid #ddd; border-radius: 3px;">
        <?php echo esc_html( $order->get_meta('_pix_code') ); ?>
    </p>
</div>

<p style="color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 3px;">
    <?php esc_html_e( 'Caso o pagamento não seja realizado no prazo, seu pedido será cancelado automaticamente.', 'wc-piggly-pix' ); ?>
</p>

<p><?php esc_html_e( 'Em caso de dúvidas, estamos à disposição!', 'wc-piggly-pix' ); ?></p>

<p><?php printf(__( '<a href="%s" style="display: inline-block; padding: 10px 20px; background-color: #2271b1; color: #ffffff; text-decoration: none; border-radius: 3px;">Clique aqui para acessar a página de pagamento</a>', 'wc-piggly-pix' ), Endpoints::getPaymentUrl($order)); ?></p>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );