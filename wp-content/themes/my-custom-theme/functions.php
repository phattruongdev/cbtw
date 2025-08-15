<?php
/**
 * Theme bootstrap
 */
if (!defined('ABSPATH')) { exit; }

// === Enqueue ===
add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style('mycustomtheme-style', get_stylesheet_uri(), [], '1.0.0');
  // optional theme JS (empty by default)
  if (file_exists(get_template_directory().'/js/front.js')) {
    wp_enqueue_script('mycustomtheme-front', get_template_directory_uri().'/js/front.js', ['jquery'], '1.0.0', true);
    wp_localize_script('mycustomtheme-front', 'MYTHEME', [
      'ajaxurl' => admin_url('admin-ajax.php'),
      'nonce'   => wp_create_nonce('mytheme_nonce')
    ]);
  }
});

// === Theme supports ===
add_action('after_setup_theme', function(){
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo');
});

// === Simple header/footer menus (optional) ===
register_nav_menus([
  'primary' => __('Primary Menu', 'mycustomtheme'),
]);

// === Rewrite rule for /product/{id} ===
add_action('init', function(){
  add_rewrite_rule('^product/([0-9]+)/?$', 'index.php?product_id=$matches[1]', 'top');
});

add_filter('query_vars', function($vars){
  $vars[] = 'product_id';
  return $vars;
});

// Auto choose our single-product template when product_id present
add_filter('template_include', function($template){
  if (get_query_var('product_id')) {
    $custom = locate_template('single-product.php');
    if ($custom) return $custom;
  }
  return $template;
});

// Helper: fetch DummyJSON with transient cache
function mytheme_fetch_dummyjson($path, $cache_key, $ttl = 300){
  $cached = get_transient($cache_key);
  if ($cached) return $cached;
  $url = 'https://dummyjson.com/'.ltrim($path, '/');
  $res = wp_remote_get($url, ['timeout' => 8]);
  if (is_wp_error($res)) return null;
  $code = wp_remote_retrieve_response_code($res);
  if ($code !== 200) return null;
  $body = json_decode(wp_remote_retrieve_body($res), true);
  set_transient($cache_key, $body, $ttl);
  return $body;
}

// Flush rewrite on theme switch (visit Permalinks still recommended)
add_action('after_switch_theme', function(){ flush_rewrite_rules(); });
