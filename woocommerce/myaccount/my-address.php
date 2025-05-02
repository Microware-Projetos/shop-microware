<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}
?>

<div class="woocommerce-addresses-wrapper">
    <div class="alert alert-info mb-4">
        <?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
    </div>

    <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
        <div class="row g-4">
    <?php else: ?>
        <div class="row g-4">
    <?php endif; ?>

    <?php foreach ( $get_addresses as $name => $address_title ) : ?>
        <?php $address = wc_get_account_formatted_address( $name ); ?>
        
        <div class="col-12 col-md-6">
            <div class="card h-100 mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0"><?php echo esc_html( $address_title ); ?></h2>
                    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="btn btn-sm btn-outline-primary">
                        <?php
                            printf(
                                $address ? esc_html__( 'Edit %s', 'woocommerce' ) : esc_html__( 'Add %s', 'woocommerce' ),
                                esc_html( $address_title )
                            );
                        ?>
                    </a>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        <?php
                            echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
                            do_action( 'woocommerce_my_account_after_my_address', $name );
                        ?>
                    </address>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    </div>
</div>

<style>
/* Melhorias para o cabeçalho do card de endereço no mobile */
@media (max-width: 767.98px) {
  .woocommerce-addresses-wrapper .card-header {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 0.5rem;
  }
  .woocommerce-addresses-wrapper .card-header .btn {
    width: 100%;
    margin-left: 0 !important;
    margin-top: 0.5rem;
    text-align: center;
  }
  .woocommerce-addresses-wrapper .card-header h2 {
    width: 100%;
    margin-bottom: 0;
  }
}
</style>
