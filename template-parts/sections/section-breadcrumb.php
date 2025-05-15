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
    
		
if ( $storebiz_hs_breadcrumb == '1' && is_shop() && !is_product() && !is_cart() && !is_checkout() && !is_search() ) {	
        ?>
<section id="breadcrumb-section" class="custom-shop-header" style="padding: 20px 0 0 0; margin-bottom: 0;">

    <div class="container">
        <div class="row">

            <!-- Coluna da Sidebar (Categorias Dinâmicas) -->
            <div class="col-12 col-md-3 mb-4 mb-md-0">
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

            <!-- Coluna do Banner -->
            <div class="col-12 col-md-9">
                <!-- Select para Mobile -->
                <div class="mobile-categories-select d-md-none">
                    <select onchange="window.location.href=this.value">
                        <option value="">Selecione uma categoria</option>
                        <?php
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
                            ?>
                        </div>

                        <!-- Controles -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>

            <!-- Seção de Produtos em Destaque (Desktop) -->
            <div class="col-12 d-none d-md-block">
                <div class="featured-products-section">
                    <h2 class="featured-products-title">Produtos em Destaque</h2>
                    <div class="featured-products-grid">
                        <?php
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'name',
                                    'terms'    => 'featured',
                                ),
                            ),
                        );
                        
                        $featured_products = new WP_Query($args);
                        
                        if ($featured_products->have_posts()) {
                            while ($featured_products->have_posts()) {
                                $featured_products->the_post();
                                global $product;
                                ?>
                                <div class="featured-product-item">
                                    <a href="<?php the_permalink(); ?>" class="product-link">
                                        <div class="product-image-wrapper">
                                            <?php 
                                            // Verifica se existe imagem externa
                                            $external_image = get_post_meta(get_the_ID(), '_external_image_url', true);
                                            
                                            if (!empty($external_image)) : ?>
                                                <div class="product-image">
                                                    <img src="<?php echo esc_url($external_image); ?>" 
                                                         alt="<?php echo esc_attr(get_the_title()); ?>"
                                                         class="wp-post-image">
                                                </div>
                                            <?php elseif (has_post_thumbnail()) : ?>
                                                <div class="product-image">
                                                    <?php 
                                                    $image_id = get_post_thumbnail_id();
                                                    $image_url = wp_get_attachment_image_src($image_id, 'woocommerce_thumbnail');
                                                    if ($image_url) {
                                                        echo '<img src="' . esc_url($image_url[0]) . '" 
                                                                  alt="' . esc_attr(get_the_title()) . '" 
                                                                  width="' . esc_attr($image_url[1]) . '" 
                                                                  height="' . esc_attr($image_url[2]) . '">';
                                                    }
                                                    ?>
                                                </div>
                                            <?php else : ?>
                                                <div class="product-image no-image">
                                                    <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="Imagem não disponível">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <h3 class="product-title"><?php the_title(); ?></h3>
                                        <div class="product-price">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        } else {
                            echo '<p class="no-products">Nenhum produto em destaque encontrado.</p>';
                        }
                        ?>
                    </div>
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
    
    .shop-categories-box {
        display: block;
        width: 100%;
        margin-bottom: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .shop-categories-list {
        display: block;
        width: 100%;
        padding: 0;
        margin: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .shop-categories-list li {
        white-space: normal;
        word-break: break-word;
        line-height: 1.3;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s;
        margin-bottom: 4px;
        list-style: none;
    }
    
    .shop-categories-list li:last-child {
        margin-bottom: 0;
    }
    
    .shop-categories-list li a {
        color: #222;
        text-decoration: none;
        display: block;
        width: 100%;
        font-size: 14px;
        line-height: 1.3;
    }
    
    .shop-categories-list li:hover {
        background: #f2f2f2;
    }
    
    .category-title {
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.2;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
        align-items: stretch;
    }
    
    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
        padding-right: 15px;
        padding-left: 15px;
        display: flex;
        flex-direction: column;
    }
    
    .col-md-9 {
        flex: 0 0 75%;
        max-width: 75%;
        padding-right: 15px; 
        padding-left: 15px;
    }

    .shop-banner-box {
        height: 100%;
    }

    .shop-banner-slider {
        height: 100%;
    }

    .swiper-wrapper {
        height: 100%;
    }

    .swiper-slide {
        height: 100%;
    }

    .swiper-slide img {
        height: 100%;
        object-fit: cover;
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
    display: block;
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
}

.product-price {
    font-size: 16px;
    font-weight: 600;
    color: var(--bs-primary);
    margin-top: 5px;
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
        display: none;
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