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
        
        // Aplica a ordem padrão se não houver configuração manual
        $terms = aplicar_ordem_padrao_categorias($terms);
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

            <!-- Coluna da Sidebar (Categorias Dinâmicas) -->
            <div class="col-12 col-md-3 mb-1 mb-md-0">
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
                                // Cria 4 banners usando arquivos SVG diferentes da pasta uploads/banners
                                for ($i = 1; $i <= 4; $i++) {
                                    echo '<div class="swiper-slide">';

                                    $svg_path = WP_CONTENT_DIR . '/uploads/banners/Banner' . sprintf('%02d', $i) . '.svg';
                                    
                                    if (file_exists($svg_path)) {
                                        // Carrega o SVG original
                                        $svg_content = file_get_contents($svg_path);
                                    
                                                                                 // Logo escolhido pelo usuário
                                         if (has_custom_logo()) {
                                             $custom_logo_id = get_theme_mod('custom_logo');
                                             $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                                             $logo_cliente = esc_url($logo[0]);
                                             
                                             // Substitui o rect pelo logo do cliente
                                             $logo_element = '<image x="57" y="17" width="98" height="66" href="' . $logo_cliente . '" preserveAspectRatio="xMidYMid meet"/>';
                                             $svg_content = str_replace('<rect id="logo" x="76" y="24" width="108" height="68" fill="url(#pattern1_82_17)"/>', $logo_element, $svg_content);
                                         }
                                         
                                        // Para o Banner04, substitui o campo de texto
                                        if ($i == 4) {
                                            // Texto personalizado para o Banner04
                                            $texto_personalizado = get_theme_mod('banner04_texto', 'Texto Personalizado');
                                            
                                            // Substitui o rect id="texto" por um elemento text com quebra de linha
                                            // Usa as mesmas coordenadas e dimensões do rect original
                                            $texto_element = '<style>@import url(\'https://fonts.googleapis.com/css2?family=Gantari:ital,wght@0,100..900;1,100..900&amp;display=swap\');</style><text x="76" y="205" font-family="Gantari, sans-serif" font-size="42" font-weight="700" fill="white">';
                                             
                                            // Quebra o texto em linhas baseado no tamanho do campo (386px de largura)
                                            $palavras = explode(' ', $texto_personalizado);
                                            $linhas = [];
                                            $linha_atual = '';
                                            $y_offset = 0;
                                            
                                            foreach ($palavras as $palavra) {
                                                $linha_teste = $linha_atual . ' ' . $palavra;
                                                if (strlen($linha_teste) * 18 > 386) { // Aproximação de largura por caractere (42px de fonte)
                                                    if (!empty($linha_atual)) {
                                                        $linhas[] = '<tspan x="76" dy="' . $y_offset . '">' . trim($linha_atual) . '</tspan>';
                                                        $y_offset = 50; // Espaçamento entre linhas (proporcional ao tamanho da fonte)
                                                        $linha_atual = $palavra;
                                                    } else {
                                                        $linhas[] = '<tspan x="76" dy="' . $y_offset . '">' . $palavra . '</tspan>';
                                                        $y_offset = 50;
                                                    }
                                                } else {
                                                    $linha_atual = $linha_teste;
                                                }
                                            }
                                             
                                             // Adiciona a última linha
                                             if (!empty($linha_atual)) {
                                                 $linhas[] = '<tspan x="76" dy="' . $y_offset . '">' . trim($linha_atual) . '</tspan>';
                                             }
                                             
                                            $texto_element .= implode('', $linhas) . '</text>';
                                            
                                            // Remove o rect id="texto" e adiciona o texto personalizado
                                            $svg_content = str_replace('<rect id="texto" x="76" y="163" width="386" height="150" fill="black"/>', $texto_element, $svg_content);
                                         }
                                    
                                        // Imprime o SVG inline (mantém vetorial e responsivo)
                                        echo '<div style="width: 100%; height: auto;">' . $svg_content . '</div>';
                                    
                                    } else {
                                        // Fallback caso o SVG não exista
                                        echo '<img src="' . esc_url(content_url('uploads/banner-fallback.png')) . '" class="img-fluid w-100" alt="Fallback Banner ' . $i . '">';
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

        </div>
    </div>
</section>

<style>
/* Estilos para o SVG ocupar toda a largura */
.swiper-slide svg {
    width: 100% !important;
    height: auto !important;
    max-width: 100% !important;
}

.swiper-slide div svg {
    width: 100% !important;
    height: auto !important;
    max-width: 100% !important;
}
@media (max-width: 767px) {
    .custom-shop-header {
        padding-top: 15px !important;
        padding-bottom: 15px !important;
    }
    
    .shop-categories-box {
        display: none;
    }
    
    .mobile-categories-select {
        width: 100%;
        margin-bottom: 15px;
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
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 15px;
    }
    
    .shop-categories-list {
        display: block;
        width: 100%;
        padding: 0;
        margin: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* Agrupa as categorias no topo */
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
        display: flex;
        align-items: center;
    }
    
    .shop-categories-list li:last-child {
        margin-bottom: 0;
    }
    
    .shop-categories-list li a {
        color: #222;
        text-decoration: none;
        display: block;
        width: 100%;
        font-size: 15px;
        font-weight: 500;
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
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
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

    /* Ajuste dinâmico do espaçamento baseado na quantidade de categorias */
    .shop-categories-list[data-items="1"] li { padding: 20px 12px; }
    .shop-categories-list[data-items="2"] li { padding: 15px 12px; }
    .shop-categories-list[data-items="3"] li { padding: 12px 12px; }
    .shop-categories-list[data-items="4"] li { padding: 10px 12px; }
    .shop-categories-list[data-items="5"] li { padding: 8px 12px; }
    .shop-categories-list[data-items="6"] li { padding: 7px 12px; }
    .shop-categories-list[data-items="7"] li { padding: 6px 12px; }
    .shop-categories-list[data-items="8"] li { padding: 5px 12px; }
    .shop-categories-list[data-items="9"] li { padding: 4px 12px; }
    .shop-categories-list[data-items="10"] li { padding: 3px 12px; }
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
}

.shop-banner-slider .swiper-wrapper {
    height: auto;
}

.shop-banner-slider .swiper-slide {
    height: auto;
}

.shop-banner-slider .swiper-slide img {
    width: 100%;
    height: auto;
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

/* Estilos para Desktop */
@media (min-width: 768px) {
    .custom-shop-header {
        padding-top: 20px !important;
    }

    .shop-categories-box {
        margin-top: 10px;
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
    
    .shop-categories-box {
        display: none;
    }
    
    .mobile-categories-select {
        width: 100%;
        margin-bottom: 5px;
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

    // Inicializa o Swiper para produtos em destaque - COM PROTEÇÃO ANTI-TRAVAMENTO
    const featuredSlider = document.querySelector('.featured-products-slider');
    if (featuredSlider) {
        const featuredSlidesCount = featuredSlider.querySelectorAll('.swiper-slide').length;
        const shouldLoopFeatured = featuredSlidesCount > 2;
        
        const featuredProductsSlider = new Swiper('.featured-products-slider', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: shouldLoopFeatured,
            loopedSlides: shouldLoopFeatured ? featuredSlidesCount : null,
            autoplay: shouldLoopFeatured ? {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            pagination: {
                el: '.featured-products-slider .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.featured-products-slider .swiper-button-next',
                prevEl: '.featured-products-slider .swiper-button-prev',
            },
            observer: true,
            observeParents: true,
            watchOverflow: true,
            preventInteractionOnTransition: true,
            resistanceRatio: 0,
            speed: 600,
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
    }

    // Inicializa o Swiper para o banner - COM PROTEÇÃO ANTI-TRAVAMENTO
    const bannerSliderEl = document.querySelector('.shop-banner-slider');
    if (bannerSliderEl) {
        const bannerSlidesCount = bannerSliderEl.querySelectorAll('.swiper-slide').length;
        const shouldLoop = bannerSlidesCount > 1;
        
        const bannerSlider = new Swiper('.shop-banner-slider', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: shouldLoop,
            loopedSlides: shouldLoop ? bannerSlidesCount : null,
            autoplay: shouldLoop ? {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            } : false,
            pagination: {
                el: '.shop-banner-slider .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.shop-banner-slider .swiper-button-next',
                prevEl: '.shop-banner-slider .swiper-button-prev',
            },
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            watchOverflow: true,
            preventInteractionOnTransition: true,
            resistanceRatio: 0,
            speed: 600,
            touchRatio: 1,
            threshold: 5,
            on: {
                init: function() {
                    setTimeout(() => {
                        this.update();
                    }, 100);
                },
                slideChange: function() {
                    // Previne múltiplas transições simultâneas
                    if (this.animating) return;
                }
            }
        });
    }

    // Adiciona o atributo data-items baseado na quantidade de categorias
    if (categoryList) {
        const items = categoryList.querySelectorAll('li').length;
        categoryList.setAttribute('data-items', items);
    }
});
</script>
<?php } ?>