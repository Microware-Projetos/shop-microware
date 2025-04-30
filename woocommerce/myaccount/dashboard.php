<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
		'class' => array(),
	),
);
?>

<div class="woocommerce-dashboard-wrapper container py-4">
    <div class="row">
        <div class="col-12">
            <div class="welcome-message mb-4 p-3 bg-light rounded">
                <?php
                printf(
                    /* translators: 1: user display name 2: logout url */
                    wp_kses( __( 'Olá %1$s (não é %1$s? <a href="%2$s" class="btn btn-outline-danger btn-sm ms-2">Sair</a>)', 'woocommerce' ), $allowed_html ),
                    '<strong class="h4">' . esc_html( $current_user->display_name ) . '</strong>',
                    esc_url( wc_logout_url() )
                );
                ?>
            </div>

            <div class="dashboard-content p-4 bg-white rounded shadow-sm">
                <?php
                /* translators: 1: Orders URL 2: Address URL 3: Account URL. */
                $dashboard_desc = __( 'No seu painel de controle você pode visualizar seus <a href="%1$s" class="text-primary">pedidos recentes</a>, gerenciar seu <a href="%2$s" class="text-primary">endereço de cobrança</a>, e <a href="%3$s" class="text-primary">editar sua senha e detalhes da conta</a>.', 'woocommerce' );
                if ( wc_shipping_enabled() ) {
                    /* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
                    $dashboard_desc = __( 'No seu painel de controle você pode visualizar seus <a href="%1$s" class="text-primary">pedidos recentes</a>, gerenciar seus <a href="%2$s" class="text-primary">endereços de entrega e cobrança</a>, e <a href="%3$s" class="text-primary">editar sua senha e detalhes da conta</a>.', 'woocommerce' );
                }
                printf(
                    wp_kses( $dashboard_desc, $allowed_html ),
                    esc_url( wc_get_endpoint_url( 'orders' ) ),
                    esc_url( wc_get_endpoint_url( 'edit-address' ) ),
                    esc_url( wc_get_endpoint_url( 'edit-account' ) )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
