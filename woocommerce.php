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
            <?php 
            // Tenta renderizar o shortcode e verifica se retorna conteúdo
            $filter_content = do_shortcode('[wpf-filters id=1]');
            $has_filters = !empty(trim($filter_content));
            
            if ($has_filters) : ?>
            <!-- Coluna do filtro (visível apenas em desktop) -->
            <div class="col-lg-3 desktop-filters d-none d-lg-block">
                <?php echo $filter_content; ?>
            </div>

            <!-- Coluna de conteúdo dos produtos -->
            <div class="col-lg-9 col-12">
            <?php else : ?>
            <!-- Coluna de conteúdo dos produtos (largura total quando não há filtros) -->
            <div class="col-12">
            <?php endif; ?>
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

<!-- Adiciona os estilos necessários -->
<style>
    @media (max-width: 991.98px) {
        /* Esconde os filtros originais em mobile */
        .desktop-filters {
            display: none !important;
        }
    }
</style>

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