<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <!-- PWA Meta Tags -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?>">
    <meta name="application-name" content="<?php bloginfo('name'); ?>">
    <meta name="format-detection" content="telephone=no">

    <!-- Icons PWA -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo SANGMELIMA_URI; ?>/assets/images/icon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SANGMELIMA_URI; ?>/assets/images/icon-16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo SANGMELIMA_URI; ?>/assets/images/icon-180.png">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main-content">
        <?php _e('Aller au contenu', 'sangmelima'); ?>
    </a>

    <!-- Indicateur hors ligne -->
    <div class="offline-indicator">
        <?php _e('Vous êtes actuellement hors ligne', 'sangmelima'); ?>
    </div>

    <!-- Header -->
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Logo -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <?php bloginfo('name'); ?>
                </a>

                <!-- Navigation Desktop -->
                <nav id="site-navigation" class="main-navigation desktop-nav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false
                    ));
                    ?>
                </nav>

                <!-- Boutons d'action -->
                <div class="header-actions">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-small">
                            <?php _e('Déconnexion', 'sangmelima'); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo wp_login_url(); ?>" class="btn btn-small">
                            <?php _e('Connexion', 'sangmelima'); ?>
                        </a>
                    <?php endif; ?>

                    <!-- Toggle Menu Mobile -->
                    <button class="mobile-menu-toggle" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="menu-icon">☰</span>
                        <span class="close-icon" style="display:none;">✕</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <nav id="mobile-menu" class="mobile-navigation" style="display:none;">
            <div class="container">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'mobile',
                    'menu_id' => 'mobile-menu-list',
                    'container' => false,
                    'fallback_cb' => false
                ));
                ?>

                <!-- Actions Mobile -->
                <div class="mobile-actions">
                    <a href="<?php echo home_url('/faire-un-don'); ?>" class="btn btn-primary btn-block">
                        <?php _e('Faire un don', 'sangmelima'); ?>
                    </a>
                    <a href="<?php echo home_url('/accompagnement'); ?>" class="btn btn-secondary btn-block">
                        <?php _e('Prendre RDV', 'sangmelima'); ?>
                    </a>
                </div>
            </div>
        </nav>
    </header>

<style>
/* Styles temporaires pour le header */
.desktop-nav {
    display: none;
}

@media (min-width: 768px) {
    .desktop-nav {
        display: block;
    }

    .mobile-menu-toggle {
        display: none;
    }
}

.main-navigation ul {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

.main-navigation a {
    text-decoration: none;
    color: var(--text-dark);
    font-weight: 500;
    transition: color 0.3s ease;
}

.main-navigation a:hover {
    color: var(--primary-color);
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.mobile-navigation {
    background: var(--bg-white);
    border-top: 1px solid #E5E5E5;
    padding: 20px 0;
}

.mobile-navigation ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.mobile-navigation li {
    margin-bottom: 15px;
}

.mobile-navigation a {
    display: block;
    padding: 10px 0;
    color: var(--text-dark);
    text-decoration: none;
    font-size: 1.1rem;
}

.mobile-actions {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #E5E5E5;
}

.btn-block {
    display: block;
    width: 100%;
    text-align: center;
    margin-bottom: 10px;
}

.btn-small {
    padding: 8px 16px;
    font-size: 0.9rem;
}
</style>