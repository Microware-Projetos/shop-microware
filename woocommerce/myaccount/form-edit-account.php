<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook - woocommerce_before_edit_account_form.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_before_edit_account_form' );
?>

<div class="account-edit-form-wrapper">
	<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

		<div class="form-row-group">
			<div class="form-row form-row-first">
				<label for="account_first_name" class="form-label"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" aria-required="true" />
			</div>
			<div class="form-row form-row-last">
				<label for="account_last_name" class="form-label"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" aria-required="true" />
			</div>
		</div>

		<div class="form-row form-row-wide">
			<label for="account_display_name" class="form-label"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr( $user->display_name ); ?>" aria-required="true" />
			<span id="account_display_name_description" class="form-description"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
		</div>

		<div class="form-row form-row-wide">
			<label for="account_email" class="form-label"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" aria-required="true" />
		</div>

		<?php
			/**
			 * Hook where additional fields should be rendered.
			 *
			 * @since 8.7.0
			 */
			do_action( 'woocommerce_edit_account_form_fields' );
		?>

		<fieldset class="password-change-section">
			<legend class="section-title"><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

			<div class="form-row form-row-wide">
				<label for="password_current" class="form-label"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
			</div>
			<div class="form-row form-row-wide">
				<label for="password_1" class="form-label"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
			</div>
			<div class="form-row form-row-wide">
				<label for="password_2" class="form-label"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
			</div>
		</fieldset>

		<?php
			/**
			 * My Account edit account form.
			 *
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_edit_account_form' );
		?>

		<div class="form-actions">
			<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
			<button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
			<input type="hidden" name="action" value="save_account_details" />
		</div>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

<style>
/* Responsividade para o formulário de edição de conta WooCommerce */
@media (max-width: 600px) {
  .account-edit-form-wrapper {
    padding: 10px;
  }

  .woocommerce-EditAccountForm .form-row-group {
    display: block;
  }

  .woocommerce-EditAccountForm .form-row {
    width: 100% !important;
    margin-bottom: 16px;
    display: block;
  }

  .woocommerce-EditAccountForm .form-label {
    font-size: 1rem;
    margin-bottom: 6px;
    display: block;
  }

  .woocommerce-EditAccountForm .input-text,
  .woocommerce-EditAccountForm input[type="email"],
  .woocommerce-EditAccountForm input[type="password"] {
    width: 100%;
    font-size: 1rem;
    padding: 10px;
    box-sizing: border-box;
  }

  .woocommerce-EditAccountForm .form-actions {
    text-align: center;
  }

  .woocommerce-EditAccountForm .woocommerce-Button {
    width: 100%;
    padding: 14px 0;
    font-size: 1.1rem;
  }

  .woocommerce-EditAccountForm .form-description {
    font-size: 0.95rem;
    display: block;
    margin-top: 4px;
  }

  .password-change-section {
    margin-top: 24px;
  }
}
</style>
