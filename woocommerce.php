<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package StoreBiz
 */

get_header();
?>
<section id="product" class="product-section">
    <div class="container">
        <?php 
        // Verifica se não é a página principal da loja
        if (!is_shop() && function_exists('rank_math_the_breadcrumbs')) {
            echo '<div class="breadcrumbs-wrapper" style="padding-top: 20px; margin-bottom: 20px;">';
            rank_math_the_breadcrumbs();
            echo '</div>';
        }
        ?>
        <div class="row gy-lg-0 gy-5 wow fadeInUp">
            <!-- Coluna de conteúdo dos produtos (largura total) -->
            <div class="col-12">
                <?php
                // Exibe os produtos em destaque acima do loop normal
                if ( function_exists( 'woocommerce_featured_product' ) ) {
                    woocommerce_featured_product(); // Altere se necessário para o código que exibe os produtos em destaque
                }

                // Início do Loop de Produtos
                if ( woocommerce_product_loop() ) {
                    // Exibe o loop de produtos aqui, que não será afetado pelo filtro
                    woocommerce_content();
                }
                ?>
            </div>
        </div>  
    </div>
</section>

<!-- Adiciona o script do Bootstrap (caso ainda não esteja incluído) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o Bootstrap já está carregado
    if (typeof bootstrap === 'undefined') {
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
        document.head.appendChild(script);
    }
});
</script>
<?php get_footer(); ?>