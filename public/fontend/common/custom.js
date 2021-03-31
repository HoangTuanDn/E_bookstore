$(function (){

    /*create toast element*/
    createTostElement();

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

    /*add first product to cart*/
    $(document).on('click','a[data-action="add_to_cart"]',function (){
        event.preventDefault()
        let currentElement = $(this);
        let inCart = currentElement.attr('data-cart');
        let url = currentElement.attr('href');

        let data = {
            'id'  : currentElement.attr('data-id')
        }

        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : data,
            success: function (json) {
                if (json['success']){
                    var toastConfig = {
                        message: json['data']['message'],
                        type: json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                }
                else {
                    var toastConfig = {
                        message: json['message'],
                        type: 'error',
                        duration: 3000
                    }
                    toast(toastConfig)
                }
            }
        })


        if (inCart){
            var toastConfig = {
                message: inCart,
                type: 'info',
                duration: 3000
            }

            toast(toastConfig)
        }else {
        }
    })

    /*handle cart change*/
    $(document).on('keypress change','input[data-action="item-quantity"]',function (e){

        let currentElement = $(this);
        let quantity = currentElement.val();
        if (e.keyCode == 13 || e.keyCode == 38 || e.keyCode == 40){
            quantity = currentElement.val();
        }

        let url = currentElement.attr('data-url');

        $.ajax({
            url     : url,
            type    : 'post',
            data    : {
                'quantity' : quantity,
                'id' : currentElement.attr('data-id'),
            },
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (json) {
                if (json['data']['type'] == 'warning'){
                    var toastConfig = {
                        message: json['data']['message'],
                        type: json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                }

                if (json['data']['type'] == 'info'){
                    var toastConfig = {
                        message: json['data']['message'],
                        type: json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    $('.cart-form').html(json['data']['content']['html']);
                    $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                }
            }
        })

    })

    /*hdndle delete item in cart*/
    $(document).on('click','a[data-action="remove-item"]',function (){
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.attr('href');

        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                'id' : currentElement.attr('data-id'),
            },
            success: function (json) {

                if (json['data']['type'] == 'info'){
                    var toastConfig = {
                        message: json['data']['message'],
                        type: json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    $('.cart-form').html(json['data']['content']['html']);
                    $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                }
            }
        })
    })


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