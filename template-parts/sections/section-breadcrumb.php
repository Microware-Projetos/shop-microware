<?php 
	$storebiz_hs_breadcrumb			= get_theme_mod('hs_breadcrumb','1');
	$storebiz_breadcrumb_bg_img		= get_theme_mod('breadcrumb_bg_img',esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumbg.jpg')); 
	$storebiz_breadcrumb_back_attach= get_theme_mod('breadcrumb_back_attach','scroll');
		
if ( $storebiz_hs_breadcrumb == '1' && is_shop() && !is_product() && !is_cart() && !is_checkout() ) {	
        ?>
<section id="breadcrumb-section" class="custom-shop-header" style="padding: 20px 0; margin-bottom: 0;">

    <div class="container">
        <div class="row d-flex align-items-stretch">

            <!-- Coluna do Banner -->
            <div class="col-12 col-md-9 order-1 order-md-2">
                <?php 
                $shop_banner = get_theme_mod('custom_shop_banner', get_template_directory_uri() . '/assets/images/banner-lenovo.jpg');
                ?>
                <div class="shop-banner-box">
                <div class="swiper shop-banner-slider">
                        <div class="swiper-wrapper">
                            <?php 
                            for ($i = 1; $i <= 10; $i++) {
                                $banner = get_theme_mod('custom_shop_banner_' . $i);
                                if (!empty($banner)) {
                                    echo '<div class="swiper-slide"><img src="' . esc_url($banner) . '" class="img-fluid w-100" alt="Banner"></div>';
                                }
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

            <!-- Coluna da Sidebar (Categorias Dinâmicas) -->
            <div class="col-12 col-md-3 mb-4 mb-md-0 order-2 order-md-1">
                <div class="shop-categories-box">
                    <h3 class="category-title">Categorias</h3>
                    <ul class="shop-categories-list">
                        <?php
                        $terms = get_terms([
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'parent' => 0,
                        ]);

                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $term_link = get_term_link($term);
                                echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                            }
                        } else {
                            echo '<li>Nenhuma categoria encontrada.</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
@media (max-width: 767px) {
    
    .shop-categories-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .category-title {
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .shop-categories-list {
        padding-left: 0;
        list-style: none;
    }
    
    .shop-categories-list li {
        margin-bottom: 8px;
    }
    
    .shop-categories-list li a {
        color: #333;
        text-decoration: none;
        display: block;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .shop-banner-box {
        margin-top: 15px;
    }
    
    .shop-banner-box img {
        border-radius: 8px;
    }

    .shop-banner-slider {
        position: relative;
    }

    .swiper-slide img {
        border-radius: 8px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #000;
    }
    
}
</style>
<?php } ?>	