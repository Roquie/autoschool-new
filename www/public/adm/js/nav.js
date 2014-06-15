$(function() {

    $('.nav_lookjs').on('click', function(e)
    {
        e.preventDefault();
        window.location = $(this).data('url');
    });

});
