<?php
/**
 * Campos de Registro Personalizados
 * 
 * Este arquivo contém todas as funções relacionadas aos campos
 * personalizados no formulário de registro de usuários.
 */

// Adiciona campos extras ao formulário de registro
function wooc_extra_register_fields() {
    ?>
    <p class="form-row form-row-wide">
        <label for="tipo_pessoa"><?php _e( 'Tipo de Pessoa', 'woocommerce' ); ?></label>
        <select name="tipo_pessoa" id="tipo_pessoa" class="input-select">
            <option value="fisica" <?php if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'fisica' ) echo 'selected'; ?>>Pessoa Física</option>
            <option value="juridica" <?php if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'juridica' ) echo 'selected'; ?>>Pessoa Jurídica</option>
        </select>
    </p>
 
    <div id="fisica_fields" style="display: none;">
        <p class="form-row form-row-first">
            <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
        </p>
        <p class="form-row form-row-last">
            <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
        </p>
    </div>
 
    <div id="juridica_fields" style="display: none;">
        <p class="form-row form-row-first">
            <label for="billing_company"><?php _e( 'Razão Social', 'woocommerce' ); ?><span class="required">*</span></label>
            <input type="text" class="input-text" name="billing_company" id="billing_company" value="<?php if ( ! empty( $_POST['billing_company'] ) ) esc_attr_e( $_POST['billing_company'] ); ?>" />
        </p>
    </div>
 
    <p class="form-row form-row-wide" id="cpf_field" style="display: none;">
        <label for="billing_cpf"><?php _e( 'CPF', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_cpf" id="billing_cpf" value="<?php if ( ! empty( $_POST['billing_cpf'] ) ) esc_attr_e( $_POST['billing_cpf'] ); ?>" />
    </p>
 
    <p class="form-row form-row-wide" id="cnpj_field" style="display: none;">
        <label for="billing_cnpj"><?php _e( 'CNPJ', 'woocommerce' ); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_cnpj" id="billing_cnpj" value="<?php if ( ! empty( $_POST['billing_cnpj'] ) ) esc_attr_e( $_POST['billing_cnpj'] ); ?>" />
    </p>
    <div class="clear"></div>
 
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoPessoa = document.getElementById('tipo_pessoa');
        const cpfField = document.getElementById('cpf_field');
        const cnpjField = document.getElementById('cnpj_field');
        const razaoField = document.getElementById('billing_company');
        const fisicaFields = document.getElementById('fisica_fields');
        const juridicaFields = document.getElementById('juridica_fields');
 
        function toggleFields() {
            if (tipoPessoa.value === 'fisica') {
                fisicaFields.style.display = 'block';
                cpfField.style.display = 'block';
                cnpjField.style.display = 'none';
                razaoField.style.display = 'none';
                juridicaFields.style.display = 'none';
            } else {
                fisicaFields.style.display = 'none';
                cpfField.style.display = 'none';
                cnpjField.style.display = 'block';
                razaoField.style.display = 'block';
                juridicaFields.style.display = 'block';
            }
        }
 
        tipoPessoa.addEventListener('change', toggleFields);
        toggleFields(); // chamada inicial
    });
    </script>
 
    <?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
 
// Validando os campos extras do registro
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) && $_POST['tipo_pessoa'] === 'fisica' ) {
        $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required for person type "fisica"!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) && $_POST['tipo_pessoa'] === 'fisica' ) {
        $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required for person type "fisica"!', 'woocommerce' ) );
    }
    if ( isset( $_POST['tipo_pessoa'] ) && empty( $_POST['tipo_pessoa'] ) ) {
        $validation_errors->add( 'tipo_pessoa_error', __( '<strong>Error</strong>: Tipo de pessoa é obrigatório!', 'woocommerce' ) );
    }
    if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'fisica' && empty( $_POST['billing_cpf'] ) ) {
        $validation_errors->add( 'billing_cpf_error', __( '<strong>Error</strong>: CPF é obrigatório para pessoa física!', 'woocommerce' ) );
    }
    if ( isset( $_POST['tipo_pessoa'] ) && $_POST['tipo_pessoa'] == 'juridica' && ( empty( $_POST['billing_cnpj'] ) || empty( $_POST['billing_company'] ) ) ) {
        $validation_errors->add( 'billing_cnpj_error', __( '<strong>Error</strong>: CNPJ e Razão Social são obrigatórios para pessoa jurídica!', 'woocommerce' ) );
    }
    return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
 
// Salvando os campos extras no registro
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['tipo_pessoa'] ) ) {
        update_user_meta( $customer_id, 'tipo_pessoa', sanitize_text_field( $_POST['tipo_pessoa'] ) );
    }
 
    if ( isset( $_POST['billing_first_name'] ) ) {
        // Atualiza o primeiro nome no WordPress
        $user_data = array(
            'ID'           => $customer_id,
            'first_name'   => sanitize_text_field( $_POST['billing_first_name'] )
        );
        wp_update_user( $user_data );
       
        // Atualiza o primeiro nome no WooCommerce
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
   
    if ( isset( $_POST['billing_last_name'] ) ) {
        // Atualiza o sobrenome no WordPress
        $user_data = array(
            'ID'           => $customer_id,
            'last_name'    => sanitize_text_field( $_POST['billing_last_name'] )
        );
        wp_update_user( $user_data );
       
        // Atualiza o sobrenome no WooCommerce
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
   
 
    if ( isset( $_POST['billing_cpf'] ) ) {
        update_user_meta( $customer_id, 'billing_cpf', sanitize_text_field( $_POST['billing_cpf'] ) );
    }
    if ( isset( $_POST['billing_cnpj'] ) ) {
        update_user_meta( $customer_id, 'billing_cnpj', sanitize_text_field( $_POST['billing_cnpj'] ) );
    }
    if ( isset( $_POST['billing_company'] ) ) {
        update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
 
// Personalizando a página de detalhes da conta para exibir Razão Social e CNPJ para Pessoa Jurídica
// Adiciona os campos personalizados no formulário de edição de conta
function custom_woocommerce_account_fields() {
    $user_id = get_current_user_id();
    $tipo_pessoa = get_user_meta($user_id, 'tipo_pessoa', true); // Tipo de pessoa (física ou jurídica)
   
    if ($tipo_pessoa == 'juridica') {
        $razao_social = get_user_meta($user_id, 'billing_company', true);
        $cnpj = get_user_meta($user_id, 'billing_cnpj', true);
       
        ?>
        <p class="form-row form-row-wide">
            <label for="billing_company"><?php esc_html_e( 'Razão Social', 'woocommerce' ); ?></label>
            <input type="text" class="input-text" name="billing_company" id="billing_company" value="<?php echo esc_attr( $razao_social ); ?>" />
        </p>
       
        <p class="form-row form-row-wide">
            <label for="billing_cnpj"><?php esc_html_e( 'CNPJ', 'woocommerce' ); ?></label>
            <input type="text" class="input-text" name="billing_cnpj" id="billing_cnpj" value="<?php echo esc_attr( $cnpj ); ?>" />
        </p>
        <?php
    }
}
add_action( 'woocommerce_edit_account_form_start', 'custom_woocommerce_account_fields', 10 );
 
// Salva os campos personalizados (Razão Social e CNPJ)
function custom_save_woocommerce_account_fields($user_id) {
    // Verifica se os campos existem e salva os valores
    if (isset($_POST['billing_company'])) {
        update_user_meta($user_id, 'billing_company', sanitize_text_field($_POST['billing_company']));
    }
 
    if (isset($_POST['billing_cnpj'])) {
        update_user_meta($user_id, 'billing_cnpj', sanitize_text_field($_POST['billing_cnpj']));
    }
}
add_action('woocommerce_save_account_details', 'custom_save_woocommerce_account_fields', 10, 1);

// Tradução de mensagem de login
function custom_login_message_translation($translated_text, $text, $domain) {
    if ($text === 'Your account with %s is using a temporary password. We emailed you a link to change your password.') {
        $translated_text = 'Sua conta com %s está usando uma senha temporária. Enviamos um link para você alterá-la.';
    }
    return $translated_text;
}
add_filter('gettext', 'custom_login_message_translation', 20, 3); 