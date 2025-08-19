<?php
/**
 * Plugin Name: My Elementor Addon
 * Description: Custom Elementor widget "Product Gallery (DummyJSON)" + Single Product route. Fixed loading + mobile-first CSS + adjustable desktop columns + redesigned single product page.
 * Version: 1.1.0
 * Author: Interview Task
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Text Domain: my-elementor-addon
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'MEA_PLUGIN_FILE', __FILE__ );
define( 'MEA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MEA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action( 'elementor/frontend/after_register_scripts', function() {
    wp_register_script(
        'mea-product-gallery',
        MEA_PLUGIN_URL . 'assets/js/product-gallery.js',
        [ 'jquery', 'elementor-frontend' ],
        '1.1.0',
        true
    );
});

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'mea-product-gallery', MEA_PLUGIN_URL . 'assets/css/product-gallery.css', [], '1.1.0' );
});

add_action( 'elementor/editor/before_enqueue_scripts', function() {
    wp_enqueue_style( 'mea-product-gallery', MEA_PLUGIN_URL . 'assets/css/product-gallery.css', [], '1.1.0' );
} );

add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once MEA_PLUGIN_DIR . 'widgets/class-mea-product-gallery.php';
    $widgets_manager->register( new \MEA_Product_Gallery_Widget() );
} );

add_action( 'init', function() {
    add_rewrite_rule( '^dummy-product/([0-9]+)/?$', 'index.php?mea_dummy_product_id=$matches[1]', 'top' );
    add_rewrite_tag( '%mea_dummy_product_id%', '([0-9]+)' );
} );

add_action( 'template_redirect', function() {
    $id = get_query_var( 'mea_dummy_product_id' );
    if ( $id ) {
        status_header(200);
        include MEA_PLUGIN_DIR . 'templates/single-product.php';
        exit;
    }
} );

register_activation_hook( __FILE__, function() {
    add_rewrite_rule( '^dummy-product/([0-9]+)/?$', 'index.php?mea_dummy_product_id=$matches[1]', 'top' );
    add_rewrite_tag( '%mea_dummy_product_id%', '([0-9]+)' );
    flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function() {
    flush_rewrite_rules();
} );
