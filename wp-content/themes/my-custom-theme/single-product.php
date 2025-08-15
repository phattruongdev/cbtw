<?php
/** Single product view powered by DummyJSON and product_id query var */
if (!defined('ABSPATH')) exit;
get_header();

$product_id = absint(get_query_var('product_id'));
if (!$product_id) {
  echo '<p>'.esc_html__('Invalid product.', 'mycustomtheme').'</p>';
  get_footer();
  exit;
}

$product = mytheme_fetch_dummyjson('products/'.$product_id, 'dj_product_'.$product_id, 300);
if (!$product) {
  echo '<p>'.esc_html__('Product not found or API error.', 'mycustomtheme').'</p>';
  get_footer();
  exit;
}
?>

<article class="grid" itemscope itemtype="http://schema.org/Product">
  <div style="grid-column: span 6;">
    <?php if (!empty($product['images'])): ?>
      <div class="card">
        <?php foreach ($product['images'] as $img): ?>
          <img class="img-fluid" src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($product['title']); ?>" />
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
  <div style="grid-column: span 6;">
    <h1 itemprop="name"><?php echo esc_html($product['title'] ?? ''); ?></h1>
    <p class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
      <span itemprop="priceCurrency">$</span><span itemprop="price"><?php echo esc_html($product['price'] ?? ''); ?></span>
    </p>
    <p class="badge"><?php echo esc_html($product['category'] ?? ''); ?></p>
    <p itemprop="description"><?php echo esc_html($product['description'] ?? ''); ?></p>
  </div>
</article>

<?php
// Related products by category
$cat = sanitize_text_field($product['category'] ?? '');
if ($cat) {
  $related = mytheme_fetch_dummyjson('products/category/'.rawurlencode($cat), 'dj_rel_'.$cat, 300);
  if (!empty($related['products'])): ?>
    <section>
      <h2><?php esc_html_e('Related Products', 'mycustomtheme'); ?></h2>
      <div class="grid">
        <?php foreach ($related['products'] as $rel): ?>
          <div class="card" style="grid-column: span 3;">
            <img class="img-fluid" src="<?php echo esc_url($rel['thumbnail'] ?? ''); ?>" alt="<?php echo esc_attr($rel['title'] ?? ''); ?>">
            <h3 style="font-size:1rem; margin:.5rem 0;"><?php echo esc_html($rel['title'] ?? ''); ?></h3>
            <p class="price">$<?php echo esc_html($rel['price'] ?? ''); ?></p>
            <a class="btn" href="<?php echo esc_url(home_url('/product/'.absint($rel['id']))); ?>">View Details</a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; }

get_footer();
