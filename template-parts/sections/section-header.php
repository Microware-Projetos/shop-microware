<?php
$storebiz_hs_nav_search  = get_theme_mod('hs_nav_search','1');
$storebiz_hs_nav_account = get_theme_mod('hs_nav_account','1');
?>

<header id="site-header" class="site-header bg-light border-bottom py-2">
    <div class="container">
        <!-- Estrutura Desktop -->
        <div class="d-none d-lg-flex justify-content-between align-items-center">
            <!-- Logo Desktop -->
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
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none fw-bold fs-4">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Search Desktop -->
            <div class="header-search-form">
                <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="product" />
                    <input class="header-search-input" name="s" type="text" placeholder="<?php esc_attr_e('Buscar produtos...', 'storebiz'); ?>"/>
                    <button class="header-search-button" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <!-- Icons Desktop -->
            <div class="d-flex align-items-center gap-7 header-icons-gap">
                <!-- Conta -->
                <?php if (class_exists('WooCommerce') && $storebiz_hs_nav_account == '1') : ?>
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="text-dark d-flex align-items-center header-link">
                        <i class="fa fa-user fa-lg"></i>
                        <span class="d-none d-lg-inline" style="white-space: nowrap;">
                            <?php echo (!is_user_logged_in()) ? 'olá, faça seu login
ou cadastre-se' : 'Minha Conta'; ?>
                        </span>
                    </a>
                <?php endif; ?>

                <?php if (class_exists('WooCommerce') && $storebiz_show_cart == '1') : ?>
                    <div class="cart-wrapper position-relative">
                        <a href="<?php echo wc_get_cart_url(); ?>" class="text-dark position-relative">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                            <?php $count = WC()->cart->get_cart_contents_count(); ?>
                            <?php if ($count > 0) : ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo esc_html($count); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="mini-cart-dropdown">
                            <div class="widget_shopping_cart_content">
                                <?php woocommerce_mini_cart(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Estrutura Mobile -->
        <div class="d-lg-none position-relative">
            <!-- Logo Mobile -->
            <div class="site-branding-mobile text-center w-100 py-2">
                <?php if (has_custom_logo()) : ?>
                    <?php 
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="d-inline-block">
                        <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="custom-logo-mobile" style="max-height: 55px; width: auto;">
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none fw-bold fs-4">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>
            <!-- Botão Hamburguer -->
            <button id="mobileMenuBtn" class="mobile-menu-btn position-absolute" style="top:18px; right:18px; z-index:1200; background:transparent; border:none;">
                <span class="mobile-menu-icon">
                    <span></span><span></span><span></span>
                </span>
            </button>
            <!-- Menu Offcanvas -->
            <div id="mobileMenu" class="mobile-offcanvas">
                <div class="mobile-offcanvas-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5">Menu</span>
                    <button class="mobile-menu-close" aria-label="Fechar menu">&times;</button>
                </div>
                <ul class="mobile-menu-list">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <li class="mobile-menu-dropdown">
                        <a href="#" class="dropdown-toggle">Categorias</a>
                        <ul class="mobile-submenu">
                        <?php
                        $orderby = get_theme_mod('shop_categories_order_by', 'name');
                        $order = get_theme_mod('shop_categories_order_direction', 'ASC');
                        $manual_order = get_theme_mod('custom_category_order', '');
                        if ($manual_order) {
                            $ids = array_map('intval', explode(',', $manual_order));
                            $product_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'include' => $ids,
                                'orderby' => 'include',
                                'hide_empty' => true,
                                'parent' => 0,
                            ]);
                        } else {
                            $product_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0,
                                'orderby' => $orderby,
                                'order' => $order
                            ]);
                        }
                        foreach ($product_categories as $cat) {
                            $category_link = get_term_link($cat->term_id, 'product_cat');
                            // Buscar subcategorias
                            $sub_cats = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => $cat->term_id,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ]);
                            
                            if ($sub_cats && !is_wp_error($sub_cats)) {
                                echo '<li class="mobile-submenu-item">';
                                echo '<a href="' . esc_url($category_link) . '" class="mobile-submenu-toggle">' . esc_html($cat->name) . ' <span class="arrow">▼</span></a>';
                                echo '<ul class="mobile-submenu-level-2">';
                                foreach ($sub_cats as $sub_cat) {
                                    $sub_category_link = get_term_link($sub_cat->term_id, 'product_cat');
                                    echo '<li><a href="' . esc_url($sub_category_link) . '">' . esc_html($sub_cat->name) . '</a></li>';
                                }
                                echo '</ul>';
                                echo '</li>';
                            } else {
                                echo '<li><a href="' . esc_url($category_link) . '">' . esc_html($cat->name) . '</a></li>';
                            }
                        }
                        ?>
                        </ul>
                    </li>
                    <li><a href="https://www.microware.com.br/quem-somos.html">Quem Somos</a></li>
                    <li><a href="https://www.microware.com.br/contato.html">Contatos</a></li>
                </ul>
            </div>
            <div id="mobileMenuOverlay" class="mobile-menu-overlay"></div>
        </div>
    </div>
</header>

<!-- Menu principal -->
<nav class="navbar navbar-expand-lg main-navbar-menu d-none d-lg-block" style="margin-bottom:0; margin-top:0; padding-top:0; padding-bottom:0; border-top:0; box-shadow:none; background:#f8f9fa;">
    <div class="container">
        <button class="navbar-toggler d-lg-none mobile-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mobile-menu" id="mainMenu">
            <div class="mobile-menu-header d-lg-none">
                <button class="btn-close" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-label="Close"></button>
            </div>
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mobile-dropdown-toggle" href="#" id="categoriasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </a>
                    <ul class="dropdown-menu mobile-dropdown" aria-labelledby="categoriasDropdown">
                        <?php
                        // Definindo os termos das categorias uma única vez, com suporte à ordem manual
                        $orderby = get_theme_mod('shop_categories_order_by', 'name');
                        $order = get_theme_mod('shop_categories_order_direction', 'ASC');
                        $manual_order = get_theme_mod('custom_category_order', '');
                        if ($manual_order) {
                            $ids = array_map('intval', explode(',', $manual_order));
                            $product_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'include' => $ids,
                                'orderby' => 'include',
                                'hide_empty' => true,
                                'parent' => 0,
                            ]);
                        } else {
                            $product_categories = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0,
                                'orderby' => $orderby,
                                'order' => $order
                            ]);
                        }
                        foreach ($product_categories as $cat) {
                            $category_link = get_term_link($cat->term_id, 'product_cat');
                            // Buscar subcategorias (ordem padrão por nome)
                            $sub_cats = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => $cat->term_id,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            ]);
                            if ($sub_cats && !is_wp_error($sub_cats)) {
                                echo '<li class="dropdown-submenu position-relative">';
                                echo '<a class="dropdown-item dropdown-toggle" href="' . esc_url($category_link) . '">' . esc_html($cat->name) . '</a>';
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
    </div>
</nav>

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
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        max-width: 600px;
        width: 100%;
        z-index: 2;
    }
    .site-header .container {
        position: relative;
    }
}
@media (max-width: 991px) {
    .header-search-form {
        position: static;
        transform: none;
        margin: 1rem auto;
        max-width: 100%;
        width: 100%;
    }
}

/* Estilos para o menu principal */
.navbar {
    padding: 0;
}

.navbar-nav {
    gap: 1.5rem;
}

.navbar-nav .nav-link {
    font-weight: 500;
    padding: 1rem 0.5rem;
    transition: color 0.2s ease;
}

.navbar-nav .nav-link:hover {
    color: #007bff !important;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-radius: 8px;
    padding: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 4px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -0.5rem;
    margin-left: 0.5rem;
}

.dropdown-submenu:hover > .dropdown-menu {
    display: block;
}

@media (max-width: 991px) {
    .navbar-nav {
        gap: 0;
    }
    
    .navbar-nav .nav-link {
        padding: 0.75rem 1rem;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: none;
        padding: 0;
    }
    
    .dropdown-submenu .dropdown-menu {
        position: static;
        margin-left: 1rem;
        margin-top: 0;
        border-left: 2px solid #e9ecef;
    }
}

/* Melhorias visuais para o menu principal */
.main-navbar-menu {
    background: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
    border-top: 0 !important;
    box-shadow: none !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-bottom: 0 !important;
    margin-top: 0 !important;
}
.main-navbar-menu .navbar-nav {
    gap: 1.2rem;
}
.main-navbar-menu .nav-link {
    font-weight: 500;
    color: #212529 !important;
    padding: 0.6rem 1rem;
    border-radius: 4px;
    transition: background 0.2s, color 0.2s;
    font-size: 1rem;
}
.main-navbar-menu .nav-link:hover, .main-navbar-menu .nav-link:focus {
    background: var(--bs-primary);
    color: #fff !important;
    text-decoration: none;
}
.main-navbar-menu .dropdown-menu {
    border: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    border-radius: 8px;
    padding: 0.5rem 0;
    margin-top: 0.3rem;
}
.main-navbar-menu .dropdown-item {
    padding: 0.5rem 1.2rem;
    border-radius: 4px;
    font-size: 0.97rem;
    color: #212529;
    transition: background 0.2s, color 0.2s;
}
.main-navbar-menu .dropdown-item:hover, .main-navbar-menu .dropdown-item:focus {
    background: var(--bs-primary);
    color: #fff;
}
.main-navbar-menu .dropdown-submenu {
    position: relative;
}
.main-navbar-menu .dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -0.5rem;
    margin-left: 0.2rem;
}
.main-navbar-menu .dropdown-submenu:hover > .dropdown-menu {
    display: block;
}
@media (max-width: 991px) {
    .main-navbar-menu .navbar-nav {
        gap: 0;
    }
    .main-navbar-menu .nav-link {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }
    .main-navbar-menu .dropdown-menu {
        box-shadow: none;
        padding: 0;
    }
    .main-navbar-menu .dropdown-submenu .dropdown-menu {
        position: static;
        margin-left: 1rem;
        margin-top: 0;
        border-left: 2px solid #e9ecef;
    }
}

@media (min-width: 992px) {
    .main-navbar-menu .dropdown:hover > .dropdown-menu {
        display: block;
    }
    .main-navbar-menu .dropdown-submenu:hover > .dropdown-menu {
        display: block;
        left: 100%;
        top: 0;
    }
}

.breadcrumb-alinhado {
    margin-bottom: 1.5rem;
    padding-left: 0.5rem; /* ajuste conforme o layout */
}

/* --- MENU MOBILE NOVO --- */
@media (max-width: 991px) {
    .mobile-menu-btn {
        display: block !important;
        width: 44px;
        height: 44px;
        padding: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        justify-content: center;
        align-items: center;
    }
    .mobile-menu-icon {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
        width: 100%;
    }
    .mobile-menu-icon span {
        display: block;
        width: 26px;
        height: 3px;
        margin: 4px 0;
        background: #222;
        border-radius: 2px;
        transition: all 0.3s;
    }
    .mobile-offcanvas {
        position: fixed;
        top: 0; left: 0; bottom: 0;
        width: 80vw;
        max-width: 320px;
        background: #fff;
        z-index: 2000;
        box-shadow: 2px 0 16px rgba(0,0,0,0.08);
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(.4,0,.2,1);
        padding: 0;
        overflow-y: auto;
        height: 100vh;
    }
    .mobile-offcanvas.open {
        transform: translateX(0);
    }
    .mobile-menu-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.25);
        z-index: 1999;
    }
    .mobile-menu-overlay.active {
        display: block;
    }
    .mobile-offcanvas-header {
        padding: 1.2rem 1.2rem 0.5rem 1.2rem;
        border-bottom: 1px solid #eee;
        background: #fff;
    }
    .mobile-menu-close {
        background: none;
        border: none;
        font-size: 2rem;
        line-height: 1;
        color: #222;
        cursor: pointer;
    }
    .mobile-menu-list {
        list-style: none;
        margin: 0;
        padding: 1rem 0 1rem 0;
    }
    .mobile-menu-list > li {
        border-bottom: 1px solid #f0f0f0;
    }
    .mobile-menu-list a {
        display: block;
        padding: 0.9rem 1.5rem;
        color: #222;
        text-decoration: none;
        font-size: 1.08rem;
        font-weight: 500;
        transition: background 0.2s;
    }
    .mobile-menu-list a:hover {
        background: #f8f9fa;
    }
    .mobile-menu-dropdown > .dropdown-toggle {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .mobile-menu-dropdown .arrow {
        font-size: 1rem;
        margin-left: 8px;
        transition: transform 0.3s;
    }
    .mobile-menu-dropdown.open .arrow {
        transform: rotate(180deg);
    }
    .mobile-submenu {
        display: none;
        list-style: none;
        padding-left: 1.5rem;
        background: #fafbfc;
    }
    .mobile-menu-dropdown.open .mobile-submenu {
        display: block;
    }
}

/* Ajuste para garantir que o menu desktop fique oculto em mobile */
@media (max-width: 991px) {
    .main-navbar-menu {
        display: none !important;
    }
    
    .navbar-collapse {
        display: none !important;
    }
}

/* Estilos para submenu mobile */
.mobile-submenu-item {
    position: relative;
}

.mobile-submenu-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.9rem 1.5rem;
    color: #222;
    text-decoration: none;
    font-size: 1.08rem;
    font-weight: 500;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.mobile-submenu-toggle .arrow {
    font-size: 0.8rem;
    transition: transform 0.3s;
}

.mobile-submenu-item.open .mobile-submenu-toggle .arrow {
    transform: rotate(180deg);
}

.mobile-submenu-level-2 {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
    background: #fff;
}

.mobile-submenu-item.open .mobile-submenu-level-2 {
    display: block;
}

.mobile-submenu-level-2 li a {
    padding: 0.8rem 2rem;
    display: block;
    color: #444;
    text-decoration: none;
    font-size: 1rem;
    border-bottom: 1px solid #f0f0f0;
}

.mobile-submenu-level-2 li:last-child a {
    border-bottom: none;
}

.mobile-submenu-level-2 li a:hover {
    background: #f8f9fa;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('mobileMenuBtn');
    var menu = document.getElementById('mobileMenu');
    var overlay = document.getElementById('mobileMenuOverlay');
    var closeBtn = document.querySelector('.mobile-menu-close');
    var dropdown = document.querySelector('.mobile-menu-dropdown');
    var dropdownToggle = dropdown.querySelector('.dropdown-toggle');
    var submenu = dropdown.querySelector('.mobile-submenu');

    btn.addEventListener('click', function() {
        menu.classList.add('open');
        overlay.classList.add('active');
    });
    closeBtn.addEventListener('click', function() {
        menu.classList.remove('open');
        overlay.classList.remove('active');
    });
    overlay.addEventListener('click', function() {
        menu.classList.remove('open');
        overlay.classList.remove('active');
    });
    dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        dropdown.classList.toggle('open');
    });

    // Adicionar funcionalidade para submenu mobile
    var submenuItems = document.querySelectorAll('.mobile-submenu-item');
    submenuItems.forEach(function(item) {
        var toggle = item.querySelector('.mobile-submenu-toggle');
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            item.classList.toggle('open');
        });
    });
});
</script>