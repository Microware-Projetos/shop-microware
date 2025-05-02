<?php
$storebiz_hs_nav_search  = get_theme_mod('hs_nav_search','1');
$storebiz_hs_nav_account = get_theme_mod('hs_nav_account','1');
$storebiz_show_cart      = get_theme_mod('hide_show_cart','1');
?>

<header id="site-header" class="site-header bg-light border-bottom py-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">

            <!-- Logo -->
            <div class="site-branding ms-4">
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

            <!-- Mobile menu toggle -->
            <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Search -->
            <?php if (class_exists('WooCommerce') && $storebiz_hs_nav_search == '1') : ?>
                <form class="d-none d-lg-block search-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="product" />
                    <div class="input-group">
                        <input type="text" class="form-control rounded-start" name="s" placeholder="<?php esc_attr_e('Buscar produtos...', 'storebiz'); ?>">
                        <button class="btn btn-primary rounded-end" type="submit" tabindex="-1">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            <?php endif; ?>

            <!-- Icons -->
            <div class="d-flex align-items-center gap-7 header-icons-gap">
                <!-- Conta -->
                <?php if (class_exists('WooCommerce') && $storebiz_hs_nav_account == '1') : ?>
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="text-dark">
                        <i class="fa fa-user fa-lg"></i>
                    </a>
                <?php endif; ?>

                <!-- Carrinho -->
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

        <!-- Mobile menu -->
        <div class="collapse navbar-collapse mt-3" id="main-menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'navbar-nav',
                'fallback_cb'    => '__return_false',
                'depth'          => 2,
                'walker'         => new WP_Bootstrap_Navwalker(),
            ));
            ?>

            <!-- Search mobile -->
            <?php if ($storebiz_hs_nav_search == '1') : ?>
                <form class="mt-3" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="product" />
                    <div class="input-group">
                        <input type="text" class="form-control rounded-start" name="s" placeholder="<?php esc_attr_e('Buscar produtos...', 'storebiz'); ?>">
                        <button class="btn btn-primary rounded-end" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
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

/* Mobile adjustments */
@media (max-width: 991px) {
    .search-form {
        width: 100%;
    }
    
    .navbar-toggler {
        padding: 0.25rem 0.5rem;
    }
    
    #main-menu {
        background: #fff;
        padding: 1rem;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .navbar-nav {
        margin-bottom: 1rem;
    }

    .mini-cart-dropdown {
        position: fixed;
        top: auto;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        margin: 0;
        border-radius: 0;
        max-height: 80vh;
        overflow-y: auto;
        padding-top: 0 !important;
    }

    .mini-cart-dropdown::before {
        display: none;
    }

    .site-branding {
        margin-left: 0 !important;
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .header-icons-gap {
        justify-content: center !important;
        width: 100%;
        gap: 1rem !important;
    }

    .widget_shopping_cart_content .woocommerce-mini-cart li {
        display: block;
        padding: 10px 0;
    }
    .widget_shopping_cart_content .woocommerce-mini-cart img {
        display: none !important;
    }
    .widget_shopping_cart_content .woocommerce-mini-cart .mini_cart_item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.2rem;
    }
    .widget_shopping_cart_content .woocommerce-mini-cart .mini_cart_item .product-name {
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    .widget_shopping_cart_content .woocommerce-mini-cart .mini_cart_item .quantity,
    .widget_shopping_cart_content .woocommerce-mini-cart .mini_cart_item .woocommerce-Price-amount {
        font-size: 0.95em;
        color: #666;
        margin-right: 0.5em;
    }
    .widget_shopping_cart_content .woocommerce-mini-cart .mini_cart_item .quantity {
        margin-bottom: 0.1em;
    }
}

.site-branding {
    /* Espaço extra à esquerda do logo */
    margin-left: 6rem;
}

.header-icons-gap > * {
    margin-right: 1.2rem !important;
}
.header-icons-gap > *:last-child {
    margin-right: 0 !important;
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
