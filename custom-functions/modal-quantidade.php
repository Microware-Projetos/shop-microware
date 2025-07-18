<?php
/**
 * Modal de Quantidade
 * 
 * Este arquivo contém todas as funções relacionadas ao modal
 * que aparece quando o usuário tenta adicionar mais produtos
 * que o limite permitido.
 */

// Adiciona o modal de quantidade
add_action('wp_footer', 'customizar_mensagem_input_quantidade');

function customizar_mensagem_input_quantidade() {
    if (is_product() || is_cart()) {
        $titulo = get_theme_mod('modal_quantidade_titulo', '🚨 ATENÇÃO: OPORTUNIDADE ESPECIAL PARA GRANDES PEDIDOS! 🚨');
        $destaque = get_theme_mod('modal_quantidade_destaque', 'Você acabou de superar o limite padrão (10 unidades) e isso é ótimo!');
        $vip = get_theme_mod('modal_quantidade_vip', '👉 Queremos oferecer condições VIP exclusivas para você:');
        $beneficio1 = get_theme_mod('modal_quantidade_beneficio1', 'Descontos progressivos (quanto mais comprar, maior o desconto!)');
        $beneficio2 = get_theme_mod('modal_quantidade_beneficio2', 'Valores personalizados abaixo da tabela');
        $beneficio3 = get_theme_mod('modal_quantidade_beneficio3', 'Pagamentos com vantagens (personalize conforme sua necessidade!)');
        $acao = get_theme_mod('modal_quantidade_acao', 'CLIQUE AQUI para falar com nosso time comercial AGORA:');
        $email = get_theme_mod('modal_quantidade_email', 'vendas.online@microware.com.br');
        $final = get_theme_mod('modal_quantidade_final', 'GARANTA SEU DESCONTO ANTES QUE O ESTOQUE ACABE! 🚀💵');
        $limite = get_theme_mod('modal_quantidade_limite', '10');
        ?>
        <style>
        #microware-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
        }
        #microware-modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        #microware-modal-close {
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        #microware-modal-content p {
            margin: 1em 0;
        }
        #copy-email {
            margin-top: 20px;
            padding: 12px 24px;
            background: #000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        #copy-email:hover {
            background: #333;
        }
        .email-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .email-link:hover {
            text-decoration: underline;
        }
        .beneficio-icone {
            color: #7c3aed;
            font-size: 1.1em;
            margin-right: 4px;
        }
        </style>
        <div id="microware-modal">
            <div id="microware-modal-content">
                <span id="microware-modal-close">&times;</span>
                <p><span style="font-size:1.2em;"><strong><?php echo esc_html($titulo); ?></strong></span></p>
                <p><?php echo esc_html($destaque); ?></p>
                <p><strong><?php echo esc_html($vip); ?></strong></p>
                <ul style="padding-left: 1.2em; margin: 0 0 1em 0;">
                    <li><span class="beneficio-icone">✔</span> <strong><?php echo esc_html($beneficio1); ?></strong></li>
                    <li><span class="beneficio-icone">✔</span> <strong><?php echo esc_html($beneficio2); ?></strong></li>
                    <li><span class="beneficio-icone">✔</span> <strong><?php echo esc_html($beneficio3); ?></strong></li>
                </ul>
                <p><strong><?php echo esc_html($acao); ?></strong></p>
                <p>📧 <a href="mailto:<?php echo esc_attr($email); ?>" class="email-link"><?php echo esc_html($email); ?></a></p>
                <p><strong style="font-size:1.1em;"><?php echo esc_html($final); ?></strong></p>
                <div style="text-align: center;">
                    <button id="copy-email">Copiar e-mail</button>
                </div>
            </div>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('microware-modal');
            const closeBtn = document.getElementById('microware-modal-close');
            const copyBtn = document.getElementById('copy-email');
            const emailText = '<?php echo esc_js($email); ?>';
            const limiteQuantidade = <?php echo esc_js($limite); ?>;
            document.querySelectorAll('input.qty').forEach(function (input) {
                input.setAttribute('max', limiteQuantidade);
                input.addEventListener('invalid', function (event) {
                    if (input.validity.rangeOverflow) {
                        input.setCustomValidity("Máximo de " + limiteQuantidade + " unidades por pedido.");
                        modal.style.display = 'block';
                    } else {
                        input.setCustomValidity("");
                    }
                });
                input.addEventListener('input', function () {
                    input.setCustomValidity("");
                });
            });
            closeBtn.onclick = function () {
                modal.style.display = 'none';
            }
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
            copyBtn.onclick = function () {
                navigator.clipboard.writeText(emailText).then(function () {
                    copyBtn.textContent = "E-mail copiado!";
                    setTimeout(() => copyBtn.textContent = "Copiar e-mail", 2000);
                });
            }
        });
        </script>
        <?php
    }
}

// Adiciona seção de configurações do modal de quantidade no personalizador
function storebiz_customize_register_modal_quantidade($wp_customize) {
    $wp_customize->add_section('modal_quantidade_section', array(
        'title'    => __('Configurações do Modal de Quantidade', 'storebiz'),
        'priority' => 30,
    ));

    // Título
    $wp_customize->add_setting('modal_quantidade_titulo', array(
        'default'           => '🚨 ATENÇÃO: OPORTUNIDADE ESPECIAL PARA GRANDES PEDIDOS! 🚨',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_titulo', array(
        'label'    => __('Título', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Mensagem de destaque
    $wp_customize->add_setting('modal_quantidade_destaque', array(
        'default'           => 'Você acabou de superar o limite padrão (10 unidades) e isso é ótimo!',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_destaque', array(
        'label'    => __('Mensagem de Destaque', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Chamada VIP
    $wp_customize->add_setting('modal_quantidade_vip', array(
        'default'           => '👉 Queremos oferecer condições VIP exclusivas para você:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_vip', array(
        'label'    => __('Chamada VIP', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Benefícios
    $wp_customize->add_setting('modal_quantidade_beneficio1', array(
        'default'           => 'Descontos progressivos (quanto mais comprar, maior o desconto!)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_beneficio1', array(
        'label'    => __('Benefício 1', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('modal_quantidade_beneficio2', array(
        'default'           => 'Valores personalizados abaixo da tabela',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_beneficio2', array(
        'label'    => __('Benefício 2', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));
    $wp_customize->add_setting('modal_quantidade_beneficio3', array(
        'default'           => 'Pagamentos com vantagens (personalize conforme sua necessidade!)',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_beneficio3', array(
        'label'    => __('Benefício 3', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Chamada para ação
    $wp_customize->add_setting('modal_quantidade_acao', array(
        'default'           => 'CLIQUE AQUI para falar com nosso time comercial AGORA:',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_acao', array(
        'label'    => __('Chamada para Ação', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // E-mail
    $wp_customize->add_setting('modal_quantidade_email', array(
        'default'           => 'vendas.online@microware.com.br',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('modal_quantidade_email', array(
        'label'    => __('E-mail de Contato', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'email',
    ));

    // Mensagem final
    $wp_customize->add_setting('modal_quantidade_final', array(
        'default'           => 'GARANTA SEU DESCONTO ANTES QUE O ESTOQUE ACABE! 🚀💵',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('modal_quantidade_final', array(
        'label'    => __('Mensagem Final', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'text',
    ));

    // Limite de quantidade
    $wp_customize->add_setting('modal_quantidade_limite', array(
        'default'           => '10',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('modal_quantidade_limite', array(
        'label'    => __('Limite de Quantidade', 'storebiz'),
        'section'  => 'modal_quantidade_section',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 100,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'storebiz_customize_register_modal_quantidade'); 