<?php
$storebiz_hs_nav_search  = get_theme_mod('hs_nav_search','1');
$storebiz_hs_nav_account = get_theme_mod('hs_nav_account','1');
?>

<header id="site-header" class="site-header bg-success text-white">
    <!-- Barra superior -->
    <div class="header-top py-1 d-flex justify-content-between align-items-center px-4" style="background: #5bc24e;">
        <div>
            <i class="fa fa-car"></i>
            <span>Frete grátis para pedidos acima de R$99</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="#" class="text-white"><i class="fa fa-user"></i> Minha Conta</a>
            <a href="#" class="text-white"><i class="fa fa-heart"></i> Wishlist</a>
            <a href="#" class="text-white"><i class="fa fa-truck"></i> Entrega</a>
            <a href="#" class="text-white"><i class="fa fa-question-circle"></i> Ajuda</a>
        </div>
    </div>
    <!-- Linha principal -->
    <div class="header-main d-flex justify-content-between align-items-center py-3 px-4" style="background: #5bc24e;">
        <!-- Logo -->
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php 
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="custom-logo" style="max-height: 50px; width: auto;">
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none fw-bold fs-4 text-white">
                    <?php bloginfo('name'); ?>
                </a>
            <?php endif; ?>
        </div>
        <!-- Busca -->
        <div class="header-search-form flex-grow-1 mx-4">
            <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="d-flex">
                <input class="form-control" name="s" type="text" placeholder="Buscar..." style="max-width: 500px;">
                <button class="btn btn-warning ms-2" type="submit"><i class="fa fa-search"></i></button>
                <input type="hidden" name="post_type" value="product" />
            </form>
        </div>
        <!-- Carrinho -->
        <div>
            <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-warning d-flex align-items-center">
                <i class="fa fa-shopping-cart me-2"></i> Carrinho
                <?php $count = WC()->cart->get_cart_contents_count(); ?>
                <?php if ($count > 0) : ?>
                    <span class="badge bg-danger ms-2"><?php echo esc_html($count); ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
    <!-- Menu principal -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoriasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriasDropdown">
                        <?php
                        $args = array(
                            'taxonomy'     => 'product_cat',
                            'orderby'      => 'name',
                            'show_count'   => 0,
                            'pad_counts'   => 0,
                            'hierarchical' => 1,
                            'title_li'     => '',
                            'hide_empty'   => 1,
                            'parent'       => 0
                        );
                        $all_categories = get_categories($args);
                        foreach ($all_categories as $cat) {
                            $category_link = get_term_link($cat->term_id, 'product_cat');
                            $sub_args = array(
                                'taxonomy'     => 'product_cat',
                                'child_of'     => $cat->term_id,
                                'parent'       => $cat->term_id,
                                'hide_empty'   => 1
                            );
                            $sub_cats = get_categories($sub_args);
                            if ($sub_cats) {
                                echo '<li class="dropdown-submenu position-relative">';
                                echo '<a class="dropdown-item dropdown-toggle" href="' . esc_url($category_link) . '" data-bs-toggle="dropdown">' . esc_html($cat->name) . '</a>';
                                echo '<ul class="dropdown-menu">';
                                foreach ($sub_cats as $sub_cat) {
                                    $sub_category_link = get_term_link($sub_cat->term_id, 'product_cat');
                                    echo '<li><a class="dropdown-item" href="' . esc_url($sub_category_link) . '">' . esc_html($sub_cat->name) . '</a></li>';
                                }
                                echo '</ul>';
                                echo '</li>';
                            } else {
                                echo '<li><a class="dropdown-item" href="' . esc_url($category_link) . '">' . esc_html($cat->name) . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.microware.com.br/quem-somos.html">Quem Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://www.microware.com.br/contato.html">Contatos</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
/* Estilos para o header */
.site-header {
    position: relative;
    z-index: 1000;
    padding-top: 2.5rem;
    padding-bottom: 2.5rem;
}

.custom-logo {
    max-height: 60px;
    width: auto;
}

.search-form {
    width: 40%;
    max-width: 500px;
}

.search-form .input-group {
    display: flex;
    flex-wrap: nowrap;
    align-items: stretch;
}

.search-form .form-control {
    height: 48px;
    line-height: 48px;
    font-size: 1.1rem;
    box-sizing: border-box;
    border-radius: 0.5rem 0 0 0.5rem;
}

.search-form .btn {
    width: 48px;
    height: 48px;
    min-width: 48px;
    min-height: 48px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0 0.5rem 0.5rem 0;
    font-size: 1.1rem;
    box-sizing: border-box;
    border-left: 0;
}

.search-form .btn i {
    font-size: 16px;
    line-height: 1;
}

/* Mini carrinho */
.cart-wrapper {
    position: relative;
}

.mini-cart-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    width: 320px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 0;
    z-index: 1000;
    margin-top: 10px;
}

.cart-wrapper:hover .mini-cart-dropdown {
    display: block;
}

.mini-cart-dropdown::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 20px;
    width: 16px;
    height: 16px;
    background: #fff;
    transform: rotate(45deg);
    border-left: 1px solid #e0e0e0;
    border-top: 1px solid #e0e0e0;
}

.widget_shopping_cart_content {
    padding: 15px;
}

.widget_shopping_cart_content .woocommerce-mini-cart {
    margin: 0;
    padding: 0;
    list-style: none;
}

.widget_shopping_cart_content .woocommerce-mini-cart li {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.widget_shopping_cart_content .woocommerce-mini-cart li:last-child {
    border-bottom: none;
}

.widget_shopping_cart_content .woocommerce-mini-cart img {
    width: 48px;
    height: 48px;
    object-fit: cover;
    border-radius: 8px;
    background: #f8f9fa;
    display: block;
    margin: 0 auto;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}

.widget_shopping_cart_content .woocommerce-mini-cart .remove_from_cart_button {
    color: #dc3545;
    font-size: 18px;
    padding: 0 5px;
    text-decoration: none;
}

.widget_shopping_cart_content .woocommerce-mini-cart .remove_from_cart_button:hover {
    color: #c82333;
}

.widget_shopping_cart_content .woocommerce-mini-cart .quantity {
    color: #666;
    font-size: 0.9em;
}

.widget_shopping_cart_content .woocommerce-mini-cart .total {
    margin: 15px 0;
    padding: 15px 0;
    border-top: 1px solid #f0f0f0;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
}

.widget_shopping_cart_content .woocommerce-mini-cart .buttons {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.widget_shopping_cart_content .woocommerce-mini-cart .buttons a {
    flex: 1;
    text-align: center;
    padding: 8px 15px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.widget_shopping_cart_content .woocommerce-mini-cart .buttons .checkout {
    background: #28a745;
    color: white;
}

.widget_shopping_cart_content .woocommerce-mini-cart .buttons .checkout:hover {
    background: #218838;
}

.widget_shopping_cart_content .woocommerce-mini-cart .buttons .view_cart {
    background: #f8f9fa;
    color: #212529;
    border: 1px solid #dee2e6;
}

.widget_shopping_cart_content .woocommerce-mini-cart .buttons .view_cart:hover {
    background: #e9ecef;
}

/* Estilos Mobile */
@media (max-width: 991px) {
    .site-header {
        padding: 0.5rem 0;
        margin-bottom: 0.5rem;
    }

    .site-header .container {
        padding-bottom: 0.5rem;
    }

    #main-menu {
        margin-top: 0.5rem !important;
    }

    .mobile-links {
        margin-bottom: 0.5rem !important;
    }

    .site-branding-mobile {
        text-align: center;
        padding: 0 40px;
    }

    .custom-logo-mobile {
        max-height: 55px;
        width: auto;
        margin: 0 auto;
    }

    .navbar-toggler {
        padding: 0.25rem 0.5rem;
        margin-right: 0.5rem;
    }

    .mobile-links .btn {
        white-space: nowrap;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        border: 1px solid #dee2e6;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .mobile-links .btn i {
        margin-right: 0.25rem;
    }

    .header-search-form-mobile {
        width: 100%;
    }

    .header-search-form-mobile form {
        margin: 0;
    }
}

/* Remover estilos antigos que podem estar interferindo */
@media (max-width: 991px) {
    .site-branding {
        display: none !important;
    }
    
    .header-icons-gap {
        display: none !important;
    }
    
    .header-search-form {
        display: none !important;
    }
}

.site-branding {
    margin-left: 6rem;
}

.header-icons-gap > * {
    margin-right: 1.2rem !important;
}
.header-icons-gap > *:last-child {
    margin-right: 0 !important;
}

/* Estilos para os links institucionais */
.header-icons-gap a {
    text-decoration: none !important;
    color: #212529;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
    gap: 0.5rem;
}

.header-icons-gap a:hover {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.05);
    text-decoration: none !important;
}

.header-icons-gap a i {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-right: 0.25rem;
}

.header-icons-gap a:hover i {
    opacity: 1;
}

/* Ajuste do link de conta */
.header-icons-gap .account-link {
    text-decoration: none !important;
    color: #212529;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    transition: all 0.2s ease-in-out;
    gap: 0.5rem;
}

.header-icons-gap .account-link:hover {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.05);
    text-decoration: none !important;
}

/* Estilos para o formulário de busca */
.header-search-form {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
}

.header-search-form form {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.header-search-select {
    padding: 0.5rem 1rem;
    border: none;
    border-right: 1px solid #e0e0e0;
    background: #f8f9fa;
    color: #495057;
    font-size: 0.9rem;
    min-width: 100px;
    max-width: 150px;
    cursor: pointer;
    outline: none;
}

.header-search-input {
    flex: 1;
    padding: 0.5rem 1rem;
    border: none;
    font-size: 0.95rem;
    color: #212529;
    outline: none;
    min-width: 0;
}

.header-search-input::placeholder {
    color: #adb5bd;
}

.header-search-button {
    padding: 0.5rem 1rem;
    border: none;
    background: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
}

.header-search-button:hover {
    background: #0056b3;
}

.header-search-button i {
    font-size: 0.9rem;
}

/* Ajustes responsivos */
@media (max-width: 991px) {
    .header-search-form {
        max-width: 100%;
        margin: 1rem 0;
    }
    
    .header-search-select {
        min-width: 100px;
    }
}

/* Ajustes para mobile */
@media (max-width: 991px) {
    .header-search-form {
        display: none !important;
    }
    
    .header-icons-gap {
        gap: 0.5rem !important;
    }
    
    .header-icons-gap a {
        padding: 0.35rem 0.5rem;
        font-size: 0.9rem;
    }
    
    .header-icons-gap a i {
        font-size: 1rem;
        margin-right: 0;
    }
    
    /* Ajuste específico para o ícone de usuário em mobile */
    .header-icons-gap a .fa-user {
        font-size: 1.1rem;
    }
    
    /* Ajuste do container dos ícones em mobile */
    .header-icons-gap {
        justify-content: flex-end !important;
        margin-right: 0.5rem;
    }
}

/* Ajuste do espaçamento da logo no desktop */
@media (min-width: 992px) {
    .site-branding {
        margin-right: 0.75rem;
    }

    .header-search-form {
        margin-left: 0.5rem;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Atualizar mini carrinho via AJAX
    $(document.body).on('added_to_cart removed_from_cart', function() {
        $('.widget_shopping_cart_content').load(window.wc_cart_fragments_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'));
    });

    // Impedir redirecionamento ao clicar no ícone do carrinho no mobile
    function isMobile() {
        return window.innerWidth <= 991;
    }
    $('.cart-wrapper > a').on('click', function(e) {
        if (isMobile()) {
            e.preventDefault();
            // Força a abertura do mini-cart
            $(this).siblings('.mini-cart-dropdown').toggle();
        }
    });
    // Fecha o mini-cart ao clicar fora no mobile
    $(document).on('click touchstart', function(e) {
        if (isMobile()) {
            if (!$(e.target).closest('.cart-wrapper').length) {
                $('.mini-cart-dropdown').hide();
            }
        }
    });
});
</script>