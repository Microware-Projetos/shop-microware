<?php
/**
 * Loader de Funcionalidades Personalizadas
 * 
 * Este arquivo carrega todas as funcionalidades personalizadas
 * separadas em arquivos específicos para melhor organização.
 */

// Verifica se o arquivo está sendo acessado diretamente
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define o caminho base para os arquivos de funcionalidades
$custom_functions_path = get_template_directory() . '/custom-functions/';

// Array com todos os arquivos de funcionalidades
$custom_files = array(
    'custom-styles.php',           // Estilos CSS personalizados globais
    'woocommerce-upload.php',      // Upload de arquivos no WooCommerce
    'woocommerce-checkout.php',    // Funcionalidades de checkout
    'registration-fields.php',     // Campos de registro personalizados
    'banner-slider.php',           // Sistema de banners/slider
    'modal-quantidade.php',        // Modal de quantidade
    'admin-customizations.php',    // Personalizações do admin
);

// Carrega cada arquivo
foreach ($custom_files as $file) {
    $file_path = $custom_functions_path . $file;
    if (file_exists($file_path)) {
        require_once $file_path;
    }
} 