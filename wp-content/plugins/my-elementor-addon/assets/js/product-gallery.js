(function($){
    function sortProducts(list, key, dir){
        const sorted = list.slice().sort(function(a,b){
            const A = (key === 'title') ? (a.title || '').toString().toLowerCase() : (a.price || 0);
            const B = (key === 'title') ? (b.title || '').toString().toLowerCase() : (b.price || 0);
            if (A < B) return -1;
            if (A > B) return 1;
            return 0;
        });
        if(dir === 'desc') sorted.reverse();
        return sorted;
    }

    function renderGrid($wrap, products){
        const columns = parseInt($wrap.data('columns')) || 4;
        let html = '<div class="mea-grid" style="--gallery-columns:'+columns+'">';
        products.forEach(function(p){
            const price = (typeof p.price !== 'undefined') ? p.price : '';
            const category = (p.category || '');
            const detailsUrl = '/dummy-product/'+ p.id;
            html += ''+
            '<div class="mea-product">' +
                '<div class="mea-thumb">'+
                    '<img src="'+ (p.thumbnail || (p.images && p.images[0]) || '') +'" alt="'+ (p.title||'') +'">'+
                    '<div class="mea-hover">'+
                        '<a class="mea-btn" href="'+ detailsUrl +'">View Details</a>'+
                    '</div>'+
                '</div>'+
                '<div class="mea-info">'+
                    '<h3 class="mea-title">'+ (p.title||'') +'</h3>'+
                    '<div class="mea-meta">'+
                        '<span class="mea-category">'+ category +'</span>'+
                        '<span class="mea-price">$'+ price +'</span>'+
                    '</div>'+
                '</div>'+
            '</div>';
        });
        html += '</div>';
        $wrap.html(html);
    }

    function fetchAndRender($scope){
        const $gallery = $scope.find('.mea-product-gallery');
        if(!$gallery.length) return;

        const limit = parseInt($gallery.data('limit')) || 12;
        const category = ($gallery.data('category')||'').trim();
        const apiUrl = 'https://dummyjson.com/products' + (category ? '/category/' + encodeURIComponent(category.split(',')[0].trim()) : '');

        $gallery.html('<div class="mea-loading">Loading...</div>');

        fetch(apiUrl).then(r => r.json()).then(function(data){
            let products = data.products || data || [];
            products = products.slice(0, limit);

            const $toolbar = $scope.find('.mea-toolbar');
            const key = $toolbar.find('.mea-sort-key').val();
            const dir = $toolbar.find('.mea-sort-dir').val();
            products = sortProducts(products, key, dir);
            renderGrid($gallery, products);

            $toolbar.off('change.mea').on('change.mea', '.mea-sort-key, .mea-sort-dir', function(){
                const key2 = $toolbar.find('.mea-sort-key').val();
                const dir2 = $toolbar.find('.mea-sort-dir').val();
                renderGrid($gallery, sortProducts(products, key2, dir2));
            });
        }).catch(function(){
            $gallery.html('<p class="mea-error">Failed to load products.</p>');
        });
    }

    const initHandler = function($scope){ fetchAndRender($scope); };

    $(window).on('elementor/frontend/init', function(){
        if (window.elementorFrontend && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/mea-product-gallery.default', initHandler);
        }
    });

    $(function(){
        $('.mea-widget').each(function(){
            initHandler($(this));
        });
    });
})(jQuery);
