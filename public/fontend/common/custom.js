$(function () {

    /*create toast element*/
    createTostElement();

   /******************** handle filter *************************/

    /*filter by category*/
    $('*[data-action="btnFilterCategory"]').click(function () {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper');

        renderHtml(url, contentWrapper);

    });

    /*filter tag */
    $('*[data-action="btnFilterTag"]').click(function () {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper')

        renderHtml(url, contentWrapper)
    });

    /*filter price*/
    $('*[data-action="btnFilterPrice"]').click(function () {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper')

        let data = $(this).closest('.filter_price').find('#amount').val();
        let number = data.match(/(\d+)/g);
        let filterPrice = `?price_min=${number[0]}&price_max=${number[1]}`
        url = url + filterPrice;

        $.ajax({
            url   : url,
            method: 'get',

            success: function (json) {
                console.log(json['data']['url'])
                if (json['success']) {
                    contentWrapper.html(json['html']['content']);
                    if (json['data']['url']) {
                        window.history.pushState('object or string', 'Title', json['data']['url'])
                    }
                }

            }
        })
    });

    /*sort product*/
    $(document).on('change', '*[data-action="sort_product"]', function () {
        var url = $(this).val();
        var contentWrapper = $('.product_wrapper')

        renderHtml(url, contentWrapper);
    });

    /*pagination*/

    $(document).on('click', '.wn__pagination li a', function () {
        event.preventDefault();
        var url = $(this).attr('href');
        var contentWrapper = $('.product_wrapper')

        renderHtml(url, contentWrapper);
    });


    /*****************************handle cart*****************************************/

    /*handle show cart box*/
    $(document).on('click', '*[data-action="show-cart-box"]', function () {
        let currentElement = $(this)
        console.log(currentElement)
        $.ajax({
            url     : currentElement.attr('href'),
            type    : 'get',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (json) {
                if (json['success'] === true) {
                    currentElement.closest('li[class="shopcart"]').find('.minicart__active').html(json['data']['html']);
                    let totalItemText = json['data']['totalItem'] > 1 ? json['data']['totalItem'] + ' items' : json['data']['totalItem'] + ' item';
                    currentElement.closest('li[class="shopcart"]').find('.total-text').text(totalItemText);
                    //$("p").css({"background-color": "yellow", "font-size": "200%"});
                }
            }
        })
    })

    $(document).on('click', '.micart__close', function () {
        $('.minicart__active').removeClass('is-visible');
    })

    /*handle delete in cart box*/
    $(document).on('click', '*[data-action="remove-item-cart-box"]', function () {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.attr('href');
        let data = {
            'id' : currentElement.attr('data-id'),
        }

        removeCartElement(url, data, currentElement)
    })

    /*add first product to cart*/
    $(document).on('click', '*[data-action="add_to_cart"]', function () {

        event.preventDefault()
        hideCartBox()
        let currentElement = $(this);
        let url = currentElement.attr('href');
        if (!url) {
            url = currentElement.attr('data-url');
        }

        let data = {
            'id': currentElement.attr('data-id')
        }

        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : data,
            success : function (json) {
                if (json['success']) {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    currentElement.closest('#wrapper').find('.product_qun').text(json['data']['totalItem']);
                } else {
                    var toastConfig = {
                        message : json['message'],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)
                }
            }
        })

    })

    /*handle cart change*/
    $(document).on('keypress change', 'input[data-action="item-quantity"]', function (e) {

        let currentElement = $(this);
        let quantity = currentElement.val();
        if (e.keyCode == 13 || e.keyCode == 38 || e.keyCode == 40) {
            quantity = currentElement.val();
        }

        let url = currentElement.attr('data-url');

        $.ajax({
            url     : url,
            type    : 'post',
            data    : {
                'quantity': quantity,
                'id'      : currentElement.attr('data-id'),
            },
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                if (json['data']['type'] == 'warning') {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                }

                if (json['data']['type'] == 'info') {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    $('.cart-form').html(json['data']['content']['html']);
                    $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                }
            }
        })

    })

    /*handle delete item in cart*/
    $(document).on('click', 'a[data-action="remove-item-in-list"]', function () {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.attr('href');
        let data = {
            'id' : currentElement.attr('data-id')
        }


        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                'id': data['id'],
            },
            success : function (json) {

                if (json['data']['type'] == 'info') {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    currentElement.closest('#wrapper').find('.product_qun').text(json['data']['content']['totalItem']);
                    $('.cart-form').html(json['data']['content']['html']);
                    $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                }
            }
        })
    })

    /*handle quick view*/
    $(document).on('click', '*[data-action="quick_view"]', function () {
        event.preventDefault();
        let currentElement = $(this);
        let dataElement = currentElement.closest('.action').find('.actions_inner');
        let data = {
            'id'       : dataElement.attr('data-id'),
            'name'     : dataElement.attr('data-name'),
            'image'    : dataElement.attr('data-image'),
            'old_price': dataElement.attr('data-price'),
            'new_price': dataElement.attr('data-discount'),
            'author'   : dataElement.attr('data-author'),
            'title'    : dataElement.attr('data-title'),
            'url'      : currentElement.attr('data-url')
        }
        let quickViewElement = $('#quickview-wrapper');
        /*change html data*/
        quickViewElement.find('img').attr('src', data['image'])
        quickViewElement.find('img').attr('width', '420px')
        quickViewElement.find('img').attr('height', '614px')
        quickViewElement.find('h1').text(data['name'])
        quickViewElement.find('span[class="new-price"]').text(data['new_price'])
        quickViewElement.find('span[class="old-price"]').text(data['old_price'])
        quickViewElement.find('div[class="quick-desc"]').html(data['title'])
        quickViewElement.find('span[title="author"]').text(data['author'])
        quickViewElement.find('div[class="addtocart-btn"] a').attr('data-action', 'add_to_cart')
        quickViewElement.find('div[class="addtocart-btn"] a').attr('data-id', data['id'])
        quickViewElement.find('div[class="addtocart-btn"] a').attr('href', data['url'])
    });

    /*handle add to wishlist*/
    $(document).on('click', '*[data-action="add_to_wishlist"]', function () {
        event.preventDefault();
        let currentElement = $(this);
        let dataElement = currentElement.closest('.action').find('.actions_inner');
        let data = {
            'id'       : dataElement.attr('data-id'),
            'name'     : dataElement.attr('data-name'),
            'image'    : dataElement.attr('data-image'),
            'new_price': dataElement.attr('data-discount'),
            'url'      : dataElement.attr('data-url')
        }


        if (localStorage.getItem('data') == null) {
            localStorage.setItem('data', '[]')
        }

        let old_data = JSON.parse(localStorage.getItem('data'));

        let isExist = old_data.some(function (item, index) {
            return item['id'] === data['id'];
        })

        if (isExist) {
            var toastConfig = {
                message : currentElement.attr('data-exist'),
                type    : 'info',
                duration: 3000
            }
            toast(toastConfig)
        } else {
            old_data.push(data);
            localStorage.setItem('data', JSON.stringify(old_data));
            var toastConfig = {
                message : currentElement.attr('data-add'),
                type    : 'success',
                duration: 3000
            }
            toast(toastConfig)
        }
    });

    function removeCartElement(url, data, currentElement){
        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                'id': data['id'],
            },
            success : function (json) {

                if (json['data']['type'] == 'info') {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)

                    currentElement.closest('.item01').fadeOut(800,function(){
                        $(this).remove();
                    })
                    let totalItemText = json['data']['content']['totalItem'] > 1 ? json['data']['content']['totalItem'] + ' items' : json['data']['content']['totalItem'] + ' item'
                    currentElement.closest('#wrapper').find('.product_qun').text(json['data']['content']['totalItem']);
                    currentElement.closest('#wrapper').find('.total-text').text(totalItemText);
                    currentElement.closest('#wrapper').find('.total_amount').text(json['data']['content']['totalPrice']);

                    $('.cart-form').html(json['data']['content']['html']);
                    $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                }
            }
        })
    }

    function hideCartBox(){
        $('.minicart__active').removeClass('is-visible');
    }


    var renderHtml = function (url, elementWrapper, data = {}) {

        $.ajax({
            url    : url,
            method : 'get',
            data   : data,
            success: function (json) {
                if (json['success']) {
                    elementWrapper.html(json['html']['content']);
                    if (json['data']['url']) {
                        window.history.pushState('object or string', 'Title', json['data']['url'])
                    }
                }

            }
        })
    }

});