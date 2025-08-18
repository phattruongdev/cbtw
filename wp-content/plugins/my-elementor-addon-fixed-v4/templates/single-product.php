<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html__( 'Product', 'my-elementor-addon' ); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('mea-single-body'); ?>>
<div class="mea-site-wrap">
  <header class="mea-header">
    <div class="mea-logo"><?php esc_html_e('[Your Logo Here]', 'my-elementor-addon'); ?></div>
    <nav class="mea-nav">
      <a href="#"><?php esc_html_e('Nav Link 1', 'my-elementor-addon'); ?></a>
      <a href="#"><?php esc_html_e('Nav Link 2', 'my-elementor-addon'); ?></a>
      <a href="#"><?php esc_html_e('Nav Link 3', 'my-elementor-addon'); ?></a>
      <a href="#"><?php esc_html_e('Nav Link 4', 'my-elementor-addon'); ?></a>
    </nav>
  </header>

  <main class="mea-single-shell">
    <div class="mea-card">
      <div class="mea-breadcrumb" id="mea-crumb"></div>
      <div class="mea-product-top">
        <div>
          <div class="mea-main-img" id="mea-main">
            <img src="" alt="">
          </div>
          <div class="mea-thumbs" id="mea-thumbs"></div>
        </div>
        <div class="mea-summary">
          <h1 id="mea-title">Product Name</h1>
          <div class="mea-price-line">
            <div class="mea-price-current" id="mea-price">$0</div>
            <div class="mea-discount" id="mea-off"></div>
          </div>
          <div class="mea-desc-title"><?php esc_html_e('[Full Product Description Title]', 'my-elementor-addon'); ?></div>
          <p id="mea-desc"></p>
        </div>
      </div>

      <section class="mea-related">
        <h3><?php esc_html_e('[Related Products Title: E.g., More from this Category]', 'my-elementor-addon'); ?></h3>
        <div class="mea-rel-grid" id="mea-related"></div>
      </section>
    </div>
  </main>

  <footer class="mea-footer">
    <div class="inner">
      <div>&copy; <?php echo esc_html( date('Y') ); ?> <?php esc_html_e('[Your Company Name]. All rights reserved.', 'my-elementor-addon'); ?></div>
      <div><a href="#"><?php esc_html_e('Footer Link 1', 'my-elementor-addon'); ?></a> <a href="#"><?php esc_html_e('Footer Link 2', 'my-elementor-addon'); ?></a></div>
    </div>
  </footer>
</div>

<?php
  $product_id = intval( get_query_var( 'mea_dummy_product_id' ) );
?>
<script>
(function(){
  const id = <?php echo json_encode( $product_id ); ?>;
  const main = document.getElementById('mea-main').querySelector('img');
  const thumbsWrap = document.getElementById('mea-thumbs');
  const titleEl = document.getElementById('mea-title');
  const priceEl = document.getElementById('mea-price');
  const offEl = document.getElementById('mea-off');
  const descEl = document.getElementById('mea-desc');
  const crumbEl = document.getElementById('mea-crumb');
  const relWrap = document.getElementById('mea-related');

  function percentOff(price, discountPercentage){
    if(!discountPercentage) return '';
    return '[' + discountPercentage + '% Off]';
  }

  function cardHtml(p){
    return '' +
      '<div class="mea-rel-card">' +
        '<div class="thumb"><img src="'+ (p.thumbnail || (p.images && p.images[0]) || '') +'" alt="'+ (p.title||'') +'"></div>' +
        '<div class="mea-rel-title">'+ (p.title||'') +'</div>' +
        '<div class="mea-rel-meta"><span class="mea-rel-price">$'+ (p.price||'') +'</span><span class="mea-rel-off">['+ (p.discountPercentage||0) +'% Off]</span></div>' +
        '<a class="mea-rel-btn" href="/dummy-product/'+ p.id +'"><?php echo esc_html__('View Product','my-elementor-addon'); ?></a>' +
      '</div>';
  }

  fetch('https://dummyjson.com/products/' + id)
    .then(r => r.json())
    .then(p => {
      const imgs = p.images && p.images.length ? p.images : [p.thumbnail];
      main.src = imgs[0] || '';
      main.alt = p.title || '';
      titleEl.textContent = p.title || '';
      priceEl.textContent = '$' + (p.price || '');
      offEl.textContent = percentOff(p.price, p.discountPercentage);
      descEl.textContent = p.description || '';
      crumbEl.innerHTML = 'Category: <strong>' + (p.category || '') + '</strong>';

      thumbsWrap.innerHTML = '';
      imgs.slice(0,4).forEach((src, idx) => {
        const div = document.createElement('div');
        div.className = 'mea-thumb-item' + (idx === 0 ? ' active' : '');
        div.innerHTML = '<img src="'+ src +'" alt="">';
        div.addEventListener('click', () => {
          document.querySelectorAll('.mea-thumb-item').forEach(t => t.classList.remove('active'));
          div.classList.add('active');
          main.src = src;
        });
        thumbsWrap.appendChild(div);
      });

      // Related products
      if(p.category){
        fetch('https://dummyjson.com/products/category/' + encodeURIComponent(p.category))
          .then(r => r.json())
          .then(list => {
            let rel = list.products || [];
            rel = rel.filter(x => x.id !== p.id).slice(0,3);
            relWrap.innerHTML = rel.map(cardHtml).join('');
          })
          .catch(()=>{
            relWrap.innerHTML = '<p class="mea-error">Failed to load related products.</p>';
          });
      }
    })
    .catch(()=>{
      document.querySelector('.mea-card').innerHTML = '<p class="mea-error">Failed to load product.</p>';
    });
})();
</script>

<?php wp_footer(); ?>
</body>
</html>
