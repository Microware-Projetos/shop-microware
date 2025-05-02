<?php 
	$storebiz_hs_breadcrumb			= get_theme_mod('hs_breadcrumb','1');
	$storebiz_breadcrumb_bg_img		= get_theme_mod('breadcrumb_bg_img',esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumbg.jpg')); 
	$storebiz_breadcrumb_back_attach= get_theme_mod('breadcrumb_back_attach','scroll');
		
if ( $storebiz_hs_breadcrumb == '1' && is_shop() && !is_product() && !is_cart() && !is_checkout() ) {	
        ?>
<section id="breadcrumb-section" class="custom-shop-header" style="padding: 20px 0 0 0; margin-bottom: 0;">

    <div class="container">
        <div class="row d-flex align-items-start">

            <!-- Coluna do Banner -->
            <div class="col-12 col-md-9 order-1 order-md-2">
                <!-- Select para Mobile -->
                <div class="mobile-categories-select d-md-none">
                    <select onchange="window.location.href=this.value">
                        <option value="">Selecione uma categoria</option>
                        <?php
                        $terms = get_terms([
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'parent' => 0,
                        ]);

                        if (!empty($terms) && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $term_link = get_term_link($term);
                                echo '<option value="' . esc_url($term_link) . '">' . esc_html($term->name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

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
                    <h3 class="category-title d-none d-md-block">Categorias</h3>
                    
                    <!-- Lista para Desktop -->
                    <ul class="shop-categories-list desktop-only">
                        <?php
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
        display: none;
    }
    
    .mobile-categories-select {
        width: 100%;
        margin-bottom: 20px;
    }

    .mobile-categories-select select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #f8f9fa;
        font-size: 16px;
        color: #555;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mobile-categories-select select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.1);
    }

    .mobile-categories-select select:hover {
        border-color: #007bff;
    }
    
    .shop-banner-box {
        margin-top: 0;
    }
    
    .shop-banner-box img {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .shop-banner-slider {
        position: relative;
    }

    .swiper-slide img {
        border-radius: 12px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: #007bff;
        background: rgba(255,255,255,0.9);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 18px;
    }
}

@media (min-width: 768px) {
    .mobile-categories-select {
        display: none;
    }
    .shop-categories-list {
        display: inline-block;
        width: auto;
        min-width: 0;
        padding: 0;
    }
    .shop-categories-list li {
        white-space: nowrap;
    }
    .shop-categories-box {
        display: inline-block;
        width: auto;
        min-width: 0;
    }
    .shop-categories-box,
    .shop-categories-list {
        height: auto !important;
        min-height: 0 !important;
        max-height: none !important;
    }
    .col-md-3 {
        align-items: flex-start !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryTitle = document.querySelector('.category-title');
    const categoryList = document.querySelector('.shop-categories-list');
    
    if (categoryTitle && categoryList) {
        categoryTitle.addEventListener('click', function() {
            this.classList.toggle('active');
            categoryList.classList.toggle('active');
        });
    }
});
</script>
<?php } ?>	