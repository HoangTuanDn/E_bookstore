$(function () {


    /*filter by category*/
    $('*[data-action="btnFilterCategory"]').click(function () {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper');

        renderHtml(url, contentWrapper);

    });

    /*pagination*/

    $(document).on('click', '.wn__pagination li a', function () {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.blog-wrapper')

        renderHtml(url, contentWrapper);
    });



});