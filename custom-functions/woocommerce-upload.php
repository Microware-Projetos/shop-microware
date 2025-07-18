<?php
/**
 * Funcionalidades de Upload de Arquivos no WooCommerce
 * 
 * Este arquivo contém todas as funções relacionadas ao upload de arquivos
 * durante o processo de checkout, especificamente para pagamentos com cheque.
 */

// Adiciona campo de upload de arquivo no checkout
add_action( 'woocommerce_review_order_before_payment', 'Custom_Checkout_file_upload_field' );

function Custom_Checkout_file_upload_field() {
    ?>
    <style>
        #custom-file-upload-wrapper {
            border: 2px dashed var(--bs-primary);
            padding: 1.5rem;
            background-color: #f9f2ff;
            border-radius: 10px;
            margin-top: 20px;
        }
 
        #custom-file-upload-wrapper label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--bs-primary);
            font-size: 1.1rem;
        }
 
        #custom-file-upload-wrapper input[type="file"] {
            border: 2px solid #ccc;
            padding: 10px;
            background: #fff;
            cursor: pointer;
            width: 100%;
        }
 
        #custom-file-warning {
            margin-top: 10px;
            color: #b10000;
            font-size: 0.95rem;
            font-weight: bold;
        }
    </style>
 
    <div id="custom-file-upload-wrapper" class="form-row form-row-wide" style="display:none;">
        <label for="Custom_Checkout_file">⚠️ Obrigatório: Anexe a Ordem de Compra</label>
        <input type="file" id="Custom_Checkout_file" name="Custom_Checkout_file" />
        <input type="hidden" name="Custom_Checkout_file_field" id="Custom_Checkout_file_field" />
        <div id="Custom_Checkout_filelist"></div>
        <div id="custom-file-warning">* Este campo é obrigatório nesse método de pagamento.</div>
    </div>
 
    <script type="text/javascript">
        jQuery(function($){
            function togglePaymentMethods() {
                var paymentMethodCheque = $('.payment_method_cheque');
                
                paymentMethodCheque.closest('li').show(); // Sempre mostra o método cheque
            }

            function toggleFileUpload() {
                var selectedPayment = $('input[name="payment_method"]:checked').val();
                
                if (selectedPayment === 'cheque') {
                    $('#custom-file-upload-wrapper').slideDown();
                } else {
                    $('#custom-file-upload-wrapper').slideUp();
                }
            }
 
            // Executa as funções quando a página carrega
            $(document).ready(function() {
                setTimeout(function() {
                    togglePaymentMethods();
                    toggleFileUpload();
                }, 1000);
            });
 
            // Monitora mudanças no tipo de pessoa
            $(document.body).on('change', '#billing_persontype', function() {
                setTimeout(function() {
                    togglePaymentMethods();
                    toggleFileUpload();
                    $('body').trigger('update_checkout');
                }, 500);
            });
 
            // Monitora mudanças no método de pagamento
            $(document.body).on('change', 'input[name="payment_method"]', function() {
                toggleFileUpload();
            });

            // Monitora atualizações do checkout
            $(document.body).on('updated_checkout', function() {
                togglePaymentMethods();
                toggleFileUpload();
            });
        });
    </script>
    <?php
}

// Validação do upload de arquivo
add_action( 'woocommerce_checkout_process', 'Custom_Checkout_validate_upload_if_cheque' );

function Custom_Checkout_validate_upload_if_cheque() {
    // Verifica se a forma de pagamento é cheque
    if ( isset( $_POST['payment_method'] ) && $_POST['payment_method'] === 'cheque' ) {
 
        // Verifica se o campo oculto (com o link do upload) foi preenchido
        if ( empty( $_POST['Custom_Checkout_file_field'] ) ) {
            wc_add_notice( 'O envio do arquivo é obrigatório para pagamentos com cheque.', 'error' );
        }
 
    }
}

// Script jQuery para upload via AJAX
add_action( 'wp_footer', 'Custom_Checkout_file_upload_script' );

function Custom_Checkout_file_upload_script() {
    if ( is_checkout() ) : ?>
        <script>
            jQuery( function( $ ) {
 
                $( '#Custom_Checkout_file' ).change( function() {
 
                    if ( ! this.files.length ) {
                        $( '#Custom_Checkout_filelist' ).empty();
                    } else {
 
                        const file = this.files[0];
                        const formData = new FormData();
                        formData.append( 'Custom_Checkout_file', file );
 
                        // Show a preview of the file
                        if (file.type.startsWith('image/')) {
                            $('#Custom_Checkout_filelist').html('<img src="' + URL.createObjectURL(file) + '" width="200"><span>' + file.name + '</span>');
                        } else if (file.type === 'application/pdf') {
                            $('#Custom_Checkout_filelist').html('<span>' + file.name + ' (PDF file)</span>');
                        } else {
                            $('#Custom_Checkout_filelist').html('<span>' + file.name + ' (Unsupported Preview - File Uploaded)</span>');
                        }
 
                        // Upload the file via AJAX
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>?action=Custom_Checkoutupload',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            processData: false,
                            success: function ( response ) {
                                $( '#Custom_Checkout_file_field' ).val( response );
                            }
                        });
 
                    }
 
                } );
 
                // Intercepta o envio do formulário
                $('form.checkout').on('checkout_place_order', function(e) {
                    if ($('#payment_method_cheque').is(':checked')) {
                        // Verifica se o upload foi completado ou se o campo do arquivo está vazio
                        if (!uploadCompleted || $('#Custom_Checkout_file_field').val() === '') {
                            e.preventDefault();  // Bloqueia o envio do pedido
                            alert('Por favor, envie o arquivo antes de finalizar o pedido.');
                            return false;
                        }
                    }
                });
 
            } );
        </script>
    <?php
    endif;
}

// Manipula o upload via AJAX
add_action( 'wp_ajax_Custom_Checkoutupload', 'Custom_Checkout_file_upload' );
add_action( 'wp_ajax_nopriv_Custom_Checkoutupload', 'Custom_Checkout_file_upload' );

function Custom_Checkout_file_upload(){
 
    $upload_dir = wp_upload_dir();
    $allowed_file_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf'); // Add allowed file types here.
 
    if ( isset( $_FILES[ 'Custom_Checkout_file' ] ) ) {
        $file_name = $_FILES[ 'Custom_Checkout_file' ][ 'name' ];
        $file_ext = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
 
        if ( in_array( $file_ext, $allowed_file_types ) ) {
            $path = $upload_dir[ 'path' ] . '/' . basename( $file_name );
 
            if( move_uploaded_file( $_FILES[ 'Custom_Checkout_file' ][ 'tmp_name' ], $path ) ) {
                echo $upload_dir[ 'url' ] . '/' . basename( $file_name );
            }
        } else {
            echo 'File type not allowed.';
        }
    }
    die;
}

// Salva a URL do arquivo enviado nos metadados do pedido
add_action( 'woocommerce_checkout_update_order_meta', 'Custom_Checkout_save_what_we_added' );

function Custom_Checkout_save_what_we_added( $order_id ){
 
    if( ! empty( $_POST[ 'Custom_Checkout_file_field' ] ) && ( $order = wc_get_order( $order_id ) ) ) {
        $order->update_meta_data( 'Custom_Checkout_file_field', sanitize_text_field( $_POST[ 'Custom_Checkout_file_field' ] ) );
        $order->save();
    }
 
}

// Exibe o arquivo enviado na página de administração do pedido
add_action( 'woocommerce_admin_order_data_after_order_details', 'Custom_Checkout_order_meta_general' );

function Custom_Checkout_order_meta_general( $order ){
 
    $file = $order->get_meta( 'Custom_Checkout_file_field' );
 
    if( $file ) {
        echo '<h3>&nbsp;</h3>';
       
        $file_extension = pathinfo( $file, PATHINFO_EXTENSION );
       
        if ( in_array( $file_extension, array('jpg', 'jpeg', 'png', 'gif') ) ) {
            echo '<a href="' . esc_url( $file ) . '" target="_blank" style="text-decoration: none;">
                    <div style="padding: 10px 15px; background-color: #007cba; color: white; border-radius: 4px; text-align: center; display: inline-block; cursor: pointer;">
                        Ver arquivo enviado
                    </div>
                  </a>';
        } elseif ( $file_extension === 'pdf' ) {
            echo '<a href="' . esc_url( $file ) . '" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                    <div style="padding: 10px 15px; background-color: #007cba; color: white; border-radius: 4px; text-align: center; display: inline-block; cursor: pointer;">
                        Ver arquivo enviado
                    </div>
                  </a>';
        } else {
            echo '<a href="' . esc_url( $file ) . '" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                    <div style="padding: 10px 15px; background-color: #007cba; color: white; border-radius: 4px; text-align: center; display: inline-block; cursor: pointer;">
                        Ver arquivo enviado
                    </div>
                  </a>';
        }
    }
} 