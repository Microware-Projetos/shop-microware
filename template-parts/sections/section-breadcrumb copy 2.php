<?php 
	$storebiz_hs_breadcrumb			= get_theme_mod('hs_breadcrumb','1');
	$storebiz_breadcrumb_bg_img		= get_theme_mod('breadcrumb_bg_img',esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumbg.jpg')); 
	$storebiz_breadcrumb_back_attach= get_theme_mod('breadcrumb_back_attach','scroll');
	
	// Definindo os termos das categorias uma única vez
	$orderby = get_theme_mod('shop_categories_order_by', 'name');
	$order = get_theme_mod('shop_categories_order_direction', 'ASC');
	
    $manual_order = get_theme_mod('custom_category_order', '');
    if ($manual_order) {
        $ids = array_map('intval', explode(',', $manual_order));
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'include' => $ids,
            'orderby' => 'include',
            'hide_empty' => true,
            'parent' => 0,
        ]);
    } else {
        // Ordem automática
        $orderby = get_theme_mod('shop_categories_order_by', 'name');
        $order = get_theme_mod('shop_categories_order_direction', 'ASC');
    
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'parent' => 0,
            'orderby' => $orderby,
            'order' => $order
        ]);
    }

    echo '<div class="container">';
    if ( is_singular('product') || is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag') ) {
        echo '<div style="margin: 10px;">';
        breadcrumb_personalizado();
        echo '</div>';
    }
    echo '</div>';

if ( $storebiz_hs_breadcrumb == '1' && is_shop() && !is_product() && !is_cart() && !is_checkout() && !is_search() ) {	
        ?>
<section id="breadcrumb-section" class="custom-shop-header" style="padding: 5px 0 0 0; margin-bottom: 0;">

    <div class="container">
        <div class="row">
            <!-- Coluna do Banner (agora ocupa toda a largura) -->
            <div class="col-12">
                <?php 
                $shop_banner = get_theme_mod('custom_shop_banner', get_template_directory_uri() . '/assets/images/banner-lenovo.jpg');
                ?>
                <div class="shop-banner-box">
                    <div class="swiper shop-banner-slider">
                        <div class="swiper-wrapper">
                            <?php 
                              $has_banner = false;
                              
                              // Primeiro, checa se algum banner existe
                              for ($i = 1; $i <= 10; $i++) {
                                  if (!empty(get_theme_mod('custom_shop_banner_' . $i))) {
                                      $has_banner = true;
                                      break;
                                  }
                              }
                              
                              // Agora monta o slider
                              if ($has_banner) {
                                  for ($i = 1; $i <= 10; $i++) {
                                      $banner = get_theme_mod('custom_shop_banner_' . $i);
                                      $banner_link = get_theme_mod('custom_shop_banner_link_' . $i);
                              
                                      if (!empty($banner)) {
                                          echo '<div class="swiper-slide">';
                                          if (!empty($banner_link)) {
                                              echo '<a href="' . esc_url($banner_link) . '" target="_blank">';
                                          }
                                          echo '<img src="' . esc_url($banner) . '" class="img-fluid w-100" alt="Banner">';
                                          if (!empty($banner_link)) {
                                              echo '</a>';
                                          }
                                          echo '</div>';
                                      }
                                  }
                              } else {
                                  // Nenhum banner, mostra placeholder único
                                  $placeholder_url = esc_url(content_url('uploads/banner-placeholder.png'));
                                  echo '<div class="swiper-slide">';
                                  echo '<img src="' . $placeholder_url . '" class="img-fluid w-100" alt="Placeholder Banner">';
                                  echo '</div>';
                              }
                            ?>
                              
                        </div>

                        <!-- Controles -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
@media (max-width: 767px) {
    .custom-shop-header {
        padding-top: 15px !important;
        padding-bottom: 15px !important;
    }
    
    .shop-banner-box {
        margin: 15px 0;
    }
    
    .featured-products-section {
        margin-top: 15px;
        padding: 15px 0;
    }

    .featured-products-title {
        margin-bottom: 15px;
    }
}

/* Estilos para o Carrossel de Produtos em Destaque */
.featured-products-slider {
    position: relative;
    padding: 0 40px;
    margin: 0 -10px;
}

.featured-products-slider .swiper-slide {
    padding: 10px;
}

.featured-products-slider .swiper-button-next,
.featured-products-slider .swiper-button-prev {
    color: var(--bs-primary);
    background: rgba(255,255,255,0.9);
    width: 35px;
    height: 35px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.featured-products-slider .swiper-button-next:after,
.featured-products-slider .swiper-button-prev:after {
    font-size: 18px;
}

.featured-products-slider .swiper-pagination {
    position: relative;
    margin-top: 20px;
}

.featured-products-slider .swiper-pagination-bullet {
    background: var(--bs-primary);
    opacity: 0.5;
}

.featured-products-slider .swiper-pagination-bullet-active {
    opacity: 1;
}

@media (max-width: 767px) {
    .featured-products-slider {
        padding: 0 30px;
    }
    
    .featured-products-slider .swiper-button-next,
    .featured-products-slider .swiper-button-prev {
        width: 30px;
        height: 30px;
    }
    
    .featured-products-slider .swiper-button-next:after,
    .featured-products-slider .swiper-button-prev:after {
        font-size: 16px;
    }
}

/* Estilos para Produtos em Destaque */
.featured-products-section {
    margin-top: 15px;
    padding: 15px 0;
}

.featured-products-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.featured-products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin: 0 -10px;
}

@media (max-width: 991px) {
    .featured-products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .featured-products-title {
        font-size: 20px;
        margin-bottom: 15px;
    }
    
    .product-title {
        font-size: 14px;
    }
    
    .product-price {
        font-size: 14px;
    }
}

@media (max-width: 575px) {
    .featured-products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin: 0 -5px;
    }
    
    .featured-product-item {
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    
    .product-link {
        padding: 8px;
    }
    
    .product-image-wrapper {
        margin-bottom: 8px;
    }
}

.featured-product-item {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.featured-product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.product-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 10px;
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    padding-top: 100%; /* Proporção 1:1 */
    margin-bottom: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image.no-image img {
    width: 50%;
    height: 50%;
    object-fit: contain;
}

.featured-product-item:hover .product-image img {
    transform: scale(1.05);
}

.product-title {
    font-size: 15px;
    font-weight: 500;
    margin: 0 0 8px;
    color: #333;
    line-height: 1.2;
    /* Limita o título a 2 linhas */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 36px; /* 2 linhas * 18px de altura da linha */
}

.product-price {
    font-size: 16px;
    font-weight: 600;
    color: var(--bs-primary);
    margin-top: auto; /* Empurra o preço para baixo */
    padding-top: 5px;
}

.product-price ins {
    color: var(--bs-primary);
    text-decoration: none;
}

.product-price del {
    color: #999;
    font-size: 14px;
    margin-right: 5px;
}

.no-products {
    text-align: center;
    color: #666;
    grid-column: 1 / -1;
    padding: 20px;
}

@media (max-width: 767px) {
    .featured-products-section {
        display: block;
    }
    
    .product-title {
        font-size: 14px;
        height: 32px; /* 2 linhas * 16px de altura da linha */
    }
    
    .product-price {
        font-size: 14px;
    }
    
    .product-link {
        padding: 8px;
    }
}

/* Estilos do Banner */
.shop-banner-box {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.shop-banner-slider {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    height: 300px; /* Altura fixa para leaderboard - ainda mais aumentada */
}

.shop-banner-slider .swiper-wrapper {
    height: 100%;
}

.shop-banner-slider .swiper-slide {
    height: 100%;
}

.shop-banner-slider .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: fill; /* Preenche toda a área, pode cortar topo/baixo mas mantém laterais */
    display: block;
    border-radius: 12px;
}

.shop-banner-slider .swiper-button-next,
.shop-banner-slider .swiper-button-prev {
    color: var(--bs-primary);
    background: rgba(255,255,255,0.9);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.shop-banner-slider .swiper-button-next:after,
.shop-banner-slider .swiper-button-prev:after {
    font-size: 20px;
}

.shop-banner-slider .swiper-pagination {
    bottom: 10px;
}

.shop-banner-slider .swiper-pagination-bullet {
    background: #fff;
    opacity: 0.7;
}

.shop-banner-slider .swiper-pagination-bullet-active {
    opacity: 1;
    background: var(--bs-primary);
}

@media (max-width: 767px) {
    .shop-banner-slider {
        height: 180px; /* Altura menor para mobile - ainda mais aumentada */
    }
    
    .shop-banner-slider .swiper-button-next,
    .shop-banner-slider .swiper-button-prev {
        width: 35px;
        height: 35px;
    }
    
    .shop-banner-slider .swiper-button-next:after,
    .shop-banner-slider .swiper-button-prev:after {
        font-size: 18px;
    }
}

@media (min-width: 768px) and (max-width: 991px) {
    .shop-banner-slider {
        height: 220px; /* Altura média para tablets - ainda mais aumentada */
    }
}

@media (min-width: 992px) {
    .shop-banner-slider {
        height: 300px; /* Altura para desktop - ainda mais aumentada */
    }
}

/* Estilos para Desktop */
@media (min-width: 768px) {
    .custom-shop-header {
        padding-top: 20px !important;
    }

    .shop-banner-box {
        margin-top: 10px;
    }
}

/* Estilos Mobile (mantendo como está) */
@media (max-width: 767px) {
    .custom-shop-header {
        padding-top: 5px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o Swiper para produtos em destaque
    const featuredProductsSlider = new Swiper('.featured-products-slider', {
        slidesPerView: 2,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.featured-products-slider .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.featured-products-slider .swiper-button-next',
            prevEl: '.featured-products-slider .swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 20,
            }
        }
    });

    // Inicializa o Swiper para o banner
    const bannerSlider = new Swiper('.shop-banner-slider', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.shop-banner-slider .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.shop-banner-slider .swiper-button-next',
            prevEl: '.shop-banner-slider .swiper-button-prev',
        }
    });
});
</script>
<?php } ?>