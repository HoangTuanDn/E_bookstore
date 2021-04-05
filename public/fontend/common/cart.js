$(function () {
    /*****************************handle cart*****************************************/

    /*handle cart change*/
    $(document).on('keypress change', 'input[data-action="item-quantity"]', function (e) {
        console.log('a')
        let currentElement = $(this);
        console.log(currentElement)
        let quantity = currentElement.val();
        if (e.keyCode == 13 || e.keyCode == 38 || e.keyCode == 40) {
            quantity = currentElement.val();
        }

        let type = currentElement.attr('data-type')

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
                    if (type === 'update-detail') {
                        $('.cart-form').html(json['data']['content']['html']);
                        $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                    }
                }
            }
        })

    })

    /*handle delete item in cart*/
    $(document).on('click', '*[data-action="remove-item"]', function () {
        event.preventDefault()
        let currentElement = $(this);
        console.log(currentElement)
        hideCartBox()

        let url = currentElement.attr('href');
        let data = {
            'id': currentElement.attr('data-id')
        }
        let type = currentElement.attr('data-type');
        removeItemCart(url, data, currentElement, type)

    })


})