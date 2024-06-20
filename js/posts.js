$(document).ready(function() {
    // Initially all posts are shown
    $('.post').show();

    // Handle click events for category toggle buttons
    $('.category-toggle').click(function() {
        var category = $(this).data('category');

        // Toggle visibility of posts in the selected category
        $('.post.' + category).toggle();
        
        $(this).toggleClass('hidden');
    });
});
