$(document).ready(function() {
    
    $('.post').show();

    var actives = {};

    $('.category-toggle').each(function() {
        var category = $(this).data('category');
        actives[category] = true;
    });

    $('.category-toggle').click(function() {

        var category = $(this).data('category');
        actives[category] = !actives[category];
        $(this).toggleClass('hidden');

        $('.post').each(function() {
            var $post = $(this);
            var categories = $post.attr('class').split(/\s+/);
            var showPost = categories.some(cat => actives[cat]);
        
            showPost ? $post.show() : $post.hide();
        });
    });
});
