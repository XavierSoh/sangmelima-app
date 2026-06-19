<?php
/**
 * SangMeLima Theme Functions
 * @package SangMeLima
 */

// ========================================
// CONFIGURATION DE BASE
// ========================================
if (!defined('ABSPATH')) exit;

define('SANGMELIMA_VERSION', '1.0.0');
define('SANGMELIMA_DIR', get_template_directory());
define('SANGMELIMA_URI', get_template_directory_uri());

// ========================================
// SUPPORT DU THÈME
// ========================================
function sangmelima_setup() {
    // Support des traductions
    load_theme_textdomain('sangmelima', SANGMELIMA_DIR . '/languages');

    // Support des fonctionnalités WordPress
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style'
    ));

    // Support PWA
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    // Menus
    register_nav_menus(array(
        'primary' => __('Menu principal', 'sangmelima'),
        'footer' => __('Menu pied de page', 'sangmelima'),
        'mobile' => __('Menu mobile', 'sangmelima')
    ));

    // Tailles d'images personnalisées
    add_image_size('prayer-thumb', 400, 300, true);
    add_image_size('saint-portrait', 300, 400, true);
    add_image_size('hero-mobile', 768, 400, true);
}
add_action('after_setup_theme', 'sangmelima_setup');

// ========================================
// SCRIPTS ET STYLES
// ========================================
function sangmelima_scripts() {
    // CSS Principal
    wp_enqueue_style('sangmelima-style', get_stylesheet_uri(), array(), SANGMELIMA_VERSION);

    // JavaScript principal
    wp_enqueue_script('sangmelima-main', SANGMELIMA_URI . '/assets/js/main.js', array(), SANGMELIMA_VERSION, true);

    // PWA Service Worker registration
    wp_enqueue_script('sangmelima-pwa', SANGMELIMA_URI . '/assets/js/pwa.js', array(), SANGMELIMA_VERSION, true);

    // Localisation pour AJAX
    wp_localize_script('sangmelima-main', 'sangmelima_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sangmelima_nonce'),
        'is_mobile' => wp_is_mobile(),
        'home_url' => home_url(),
        'api_endpoints' => array(
            'aelf' => 'https://api.aelf.org/v1',
            'prayers' => rest_url('sangmelima/v1/prayers'),
            'groups' => rest_url('sangmelima/v1/groups')
        )
    ));
}
add_action('wp_enqueue_scripts', 'sangmelima_scripts');

// ========================================
// TYPES DE CONTENUS PERSONNALISÉS
// ========================================
function sangmelima_register_post_types() {
    // Neuvaines
    register_post_type('neuvaine', array(
        'labels' => array(
            'name' => __('Neuvaines', 'sangmelima'),
            'singular_name' => __('Neuvaine', 'sangmelima'),
            'add_new_item' => __('Ajouter une neuvaine', 'sangmelima'),
            'edit_item' => __('Modifier la neuvaine', 'sangmelima')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-book-alt',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'neuvaines')
    ));

    // Prières
    register_post_type('priere', array(
        'labels' => array(
            'name' => __('Prières', 'sangmelima'),
            'singular_name' => __('Prière', 'sangmelima'),
            'add_new_item' => __('Ajouter une prière', 'sangmelima'),
            'edit_item' => __('Modifier la prière', 'sangmelima')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-heart',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'prieres')
    ));

    // Saints
    register_post_type('saint', array(
        'labels' => array(
            'name' => __('Saints', 'sangmelima'),
            'singular_name' => __('Saint', 'sangmelima'),
            'add_new_item' => __('Ajouter un saint', 'sangmelima'),
            'edit_item' => __('Modifier le saint', 'sangmelima')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-star-filled',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'saints')
    ));

    // Magistère
    register_post_type('magistere', array(
        'labels' => array(
            'name' => __('Magistère', 'sangmelima'),
            'singular_name' => __('Document du Magistère', 'sangmelima'),
            'add_new_item' => __('Ajouter un document', 'sangmelima'),
            'edit_item' => __('Modifier le document', 'sangmelima')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-media-document',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'magistere')
    ));

    // Rendez-vous spirituels
    register_post_type('rdv_spirituel', array(
        'labels' => array(
            'name' => __('Rendez-vous spirituels', 'sangmelima'),
            'singular_name' => __('Rendez-vous', 'sangmelima'),
            'add_new_item' => __('Ajouter un créneau', 'sangmelima'),
            'edit_item' => __('Modifier le créneau', 'sangmelima')
        ),
        'public' => false,
        'show_ui' => true,
        'supports' => array('title'),
        'menu_icon' => 'dashicons-calendar-alt',
        'show_in_rest' => true
    ));
}
add_action('init', 'sangmelima_register_post_types');

// ========================================
// TAXONOMIES PERSONNALISÉES
// ========================================
function sangmelima_register_taxonomies() {
    // Catégories pour le Magistère
    register_taxonomy('magistere_category', 'magistere', array(
        'labels' => array(
            'name' => __('Catégories du Magistère', 'sangmelima'),
            'singular_name' => __('Catégorie', 'sangmelima')
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'magistere-cat')
    ));

    // Types de prières
    register_taxonomy('type_priere', 'priere', array(
        'labels' => array(
            'name' => __('Types de prières', 'sangmelima'),
            'singular_name' => __('Type', 'sangmelima')
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'type-priere')
    ));
}
add_action('init', 'sangmelima_register_taxonomies');

// ========================================
// API REST PERSONNALISÉE
// ========================================
function sangmelima_register_rest_routes() {
    // Route pour l'API AELF
    register_rest_route('sangmelima/v1', '/aelf/(?P<type>[a-zA-Z]+)', array(
        'methods' => 'GET',
        'callback' => 'sangmelima_get_aelf_content',
        'permission_callback' => '__return_true'
    ));

    // Route pour les groupes de prière
    register_rest_route('sangmelima/v1', '/prayer-groups', array(
        'methods' => 'GET',
        'callback' => 'sangmelima_get_prayer_groups',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('sangmelima/v1', '/prayer-groups', array(
        'methods' => 'POST',
        'callback' => 'sangmelima_create_prayer_group',
        'permission_callback' => 'is_user_logged_in'
    ));
}
add_action('rest_api_init', 'sangmelima_register_rest_routes');

// ========================================
// FONCTIONS API
// ========================================
function sangmelima_get_aelf_content($request) {
    $type = $request['type'];
    $cache_key = 'aelf_' . $type . '_' . date('Y-m-d');
    $cached = get_transient($cache_key);

    if ($cached) {
        return $cached;
    }

    $response = wp_remote_get('https://api.aelf.org/v1/' . $type . '/' . date('Y-m-d'));

    if (!is_wp_error($response)) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        set_transient($cache_key, $data, 12 * HOUR_IN_SECONDS);
        return $data;
    }

    return new WP_Error('aelf_error', 'Impossible de récupérer les données AELF');
}

// ========================================
// INTÉGRATION WOOCOMMERCE
// ========================================
function sangmelima_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'sangmelima_woocommerce_support');

// ========================================
// PWA MANIFEST
// ========================================
function sangmelima_add_manifest() {
    echo '<link rel="manifest" href="' . SANGMELIMA_URI . '/manifest.json">';
    echo '<meta name="theme-color" content="#8B4513">';
    echo '<meta name="apple-mobile-web-app-capable" content="yes">';
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
}
add_action('wp_head', 'sangmelima_add_manifest');

// ========================================
// SÉCURITÉ
// ========================================
function sangmelima_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
add_action('send_headers', 'sangmelima_security_headers');

// Désactiver XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Masquer la version de WordPress
remove_action('wp_head', 'wp_generator');

// ========================================
// HELPERS
// ========================================
function sangmelima_get_prayer_of_day() {
    $cache_key = 'prayer_of_day_' . date('Y-m-d');
    $prayer = get_transient($cache_key);

    if (!$prayer) {
        $args = array(
            'post_type' => 'priere',
            'posts_per_page' => 1,
            'orderby' => 'rand'
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $query->the_post();
            $prayer = array(
                'title' => get_the_title(),
                'content' => get_the_content(),
                'excerpt' => get_the_excerpt()
            );
            wp_reset_postdata();
            set_transient($cache_key, $prayer, DAY_IN_SECONDS);
        }
    }

    return $prayer;
}