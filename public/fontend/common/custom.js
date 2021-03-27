$(function (){


    /*filter by category*/
    $('*[data-action="btnFilterCategory"]').click(function (){
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper');

        renderHtml(url, contentWrapper);

    });

    /*filter tag */
    $('*[data-action="btnFilterTag"]').click(function (){
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper')

        renderHtml(url, contentWrapper)
    });

    /*filter price*/
    $('*[data-action="btnFilterPrice"]').click(function (){
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper')

        let data = $(this).closest('.filter_price').find('#amount').val();
        let number = data.match(/(\d+)/g);
        let filterPrice = `?price_min=${number[0]}&price_max=${number[1]}`
        url = url + filterPrice;

        $.ajax({
            url : url,
            method: 'get',

            success: function (json) {
                console.log(json['data']['url'])
                if (json['success']){
                    contentWrapper.html(json['html']['content']);
                    if (json['data']['url']) {
                        window.history.pushState('object or string', 'Title', json['data']['url'])
                    }
                }

            }
        })
    });

    /*sort product*/
    $(document).on('change', '*[data-action="sort_product"]', function() {
        var url = $(this).val();
        var contentWrapper = $('.product_wrapper')

        renderHtml(url, contentWrapper);
    });

    /*pagination*/

    $(document).on('click', '.wn__pagination li a', function() {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper')

        renderHtml(url, contentWrapper);
    });

    var renderHtml = function (url , elementWrapper, data = {}){

        $.ajax({
            url : url,
            method: 'get',
            data : data,
            success: function (json) {
                if (json['success']){
                    elementWrapper.html(json['html']['content']);
                    if (json['data']['url']) {
                        window.history.pushState('object or string', 'Title', json['data']['url'])
                    }
                }

            }
        })
    }

});