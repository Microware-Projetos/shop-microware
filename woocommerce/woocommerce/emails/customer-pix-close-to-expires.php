<?php
/**
 * Customer PIX close to expires email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-pix-close-to-expires.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

use Piggly\WooPixGateway\Core\Endpoints;
use Piggly\WooPixGateway\Core\Entities\PixEntity;

if ( !defined('ABSPATH') ) { exit; }

/** @var PixEntity $pix */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
</head>
<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tr>
                <td align="center" valign="top">
                    <div id="template_header_image">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_email_header_image', get_custom_header() ) ); ?>
                    </div>
                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
                        <tr>
                            <td align="center" valign="top">
                                <!-- Header -->
                                <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
                                    <tr>
                                        <td id="header_wrapper">
                                            <h1><?php echo esc_html( $email_heading ); ?></h1>
                                        </td>
                                    </tr>
                                </table>
                                <!-- End Header -->
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <!-- Body -->
                                <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                    <tr>
                                        <td valign="top" id="body_content">
                                            <!-- Content -->
                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="top">
                                                        <div id="body_content_inner">
                                                            <p><?php printf( esc_html__( 'Olá %s,', 'wc-piggly-pix' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
                                                            <p><?php printf( esc_html__( 'O pagamento do seu pedido #%s irá expirar em %s e o seu Pix ainda não foi confirmado.', 'wc-piggly-pix' ), esc_html( $order->get_order_number() ), $pix->getExpiresAt()->format('d/m/Y H:i:s') ); ?></p>
                                                            
                                                            <table class="button" role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                                                                <tr>
                                                                    <td align="center">
                                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td>
                                                                                    <a href="<?php echo esc_url( Endpoints::getReceiptUrl($order) ); ?>" class="button button-primary"><?php esc_html_e( 'Enviar Comprovante', 'wc-piggly-pix' ); ?></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <table class="button" role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td align="center">
                                                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td>
                                                                                    <a href="<?php echo esc_url( Endpoints::getPaymentUrl($order) ); ?>" class="button"><?php esc_html_e( 'Visualizar Pix', 'wc-piggly-pix' ); ?></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <?php if ( $additional_content ) : ?>
                                                                <div class="additional-content">
                                                                    <?php echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) ); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- End Content -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- End Body -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top">
                    <!-- Footer -->
                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                        <tr>
                            <td valign="top">
                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                    <tr>
                                        <td colspan="2" valign="middle" id="credit">
                                            <?php echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ); ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!-- End Footer -->
                </td>
            </tr>
        </table>
    </div>
</body>
</html>