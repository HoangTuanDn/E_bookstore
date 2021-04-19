$(function () {
    /*create toast element*/
    createTostElement();


    /*custom header*/
    let classRemove = $('.contentbox input[type="hidden"]').val();
    if (classRemove){
        $('#wn__header').removeClass(classRemove);
    }

    /*handle show cart box*/
    $(document).on('click', '*[data-action="show-cart-box"]', function () {
        let currentElement = $(this)

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

                }
            }
        })
    })

    $(document).on('click', '.micart__close', function () {
        $('.minicart__active').removeClass('is-visible');
    });


    /*add first product to cart*/
    $(document).on('click', '*[data-action="add_to_cart"]', function () {

        event.preventDefault()
        hideCartBox()
        let currentElement = $(this);
        let url = currentElement.attr('href');
        let quantity = currentElement.closest('.box-tocart').find('input[id="qty"]').val();
        console.log(quantity)
        if (!url) {
            url = currentElement.attr('data-url');
        }

        let data = {
            'id'      : currentElement.attr('data-id'),
            'quantity': quantity
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

    /*handle remove product in box cart*/
    $(document).on('click', '*[data-action="remove-item-in-box"]', function () {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.attr('href');
        let data = {
            'id': currentElement.attr('data-id')
        }
        let type = currentElement.attr('data-type');
        removeItemCart(url, data, currentElement, type)

    })
    /*handle update in box cart*/
    $(document).on('click', '*[data-action="btnCartBoxUpdate"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.attr('href');
        let old_quantity = currentElement.closest('.product_prize').find('span').attr('data-quantity');
        let quantity = parseInt(old_quantity) + 1;


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

                    currentElement.closest('.product_prize').find('.qun').text(json['data']['content']['quantity_text'])
                    currentElement.closest('.product_prize').find('.qun').attr('data-quantity', json['data']['content']['quantity'])
                    currentElement.closest('#wrapper').find('.total_amount').html(`<span>${json['data']['content']['totalPrice']}</span>`);

                    /*html for checkout*/
                    let currentLocation = window.location.href;
                    if (currentLocation.includes('home/checkout')) {
                        currentElement.closest('#wrapper').find('.wn__order__box').html(json['data']['detailOrderHtml'])
                    }
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
            'url'      : currentElement.attr('data-url'),
            'review'   : dataElement.attr('data-review')
        }
        console.log(data)
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
        quickViewElement.find('div[class="review"] a').text(data['review'])
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

        console.log(data)

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

    /*handle logout*/
    $(document).on('click', '*[data-action="logout"]', function () {
        event.preventDefault();
        let currentElement = $(this);
        let url = currentElement.attr('href');

        $.ajax({
            url    : url,
            type   : 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (json) {
                if (json['success'] === true) {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    setTimeout(function () {
                        window.location.href = json['data']['url_redirect'];
                    }, 1000)

                }
            }
        })
    })

    /*handle contact email*/
    $(document).on('click', '*[data-action="subscribe"]', function () {
        event.preventDefault();
        let currentElement = $(this);
        let url = currentElement.closest('form').attr('action');
        let data = {
            'email': currentElement.closest('form').find('input[name="email"]').val()
        }
        console.log({
            'url' : url,
            'data' : data
        })
        let ajaxCall = $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            data    : data,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })

        ajaxCall.done(function (json) {
            var toastConfig = {
                message : json['data']['message'],
                type    : json['data']['type'],
                duration: 3000
            }
            toast(toastConfig)
            currentElement.closest('form').find('input[name="email"]').val(" ")
        });

        ajaxCall.fail(function (json) {
            if (json['responseJSON'] !== undefined) {
                let errors = Object.values(json['responseJSON']['errors']);
                let errormessage = [];
                errormessage = errors.map(function (element, index) {
                    return element[0]
                })

                let toastConfig = {
                    message : errormessage[0],
                    type    : 'error',
                    duration: 3000
                }
                toast(toastConfig)

            }
        });
    })

})