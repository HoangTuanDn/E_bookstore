$(function () {
    /*handle filter price in product detail page*/
    $('*[data-action="btnFilterPrice"]').click(function () {
        event.preventDefault();
        var url = $(this).attr('href');

        let data = $(this).closest('.filter_price').find('#amount').val();
        let number = data.match(/(\d+)/g);
        console.log(data)
        let filterPrice = `?price_min=${number[0]}&price_max=${number[1]}`
        url = url + filterPrice;

        $(location).attr('href', url);
    });

    /*handle customer review */

    $('*[data-action="customer-review"]').click (function () {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.attr('data-url');
        let qualityRate = currentElement.closest('.review-fieldset').find('input[name="review-quantity"]:checked').attr('id')
        let priceRate = currentElement.closest('.review-fieldset').find('input[name="review-price"]:checked').attr('id')
        qualityRate = qualityRate !== undefined ? qualityRate.slice(-1) : '';
        priceRate = priceRate !== undefined ? priceRate.slice(-1) : '';

        let data = {
            'id'            : currentElement.attr('data-id'),
            'quality_rate'  : parseInt(qualityRate),
            'price_rate'    : parseInt(priceRate),
            'nickname'      : currentElement.closest('.review-fieldset').find('input[name="nickname"]').val(),
            'review_content': currentElement.closest('.review-fieldset').find('textarea[name="review_content"]').val(),
        }

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
            currentElement.closest('#nav-review').find('.review__attribute').html(json['data']['htmlView'])
            currentElement.closest('.review-fieldset').find('input[name="review-quantity"]:checked').prop('checked', false)
            currentElement.closest('.review-fieldset').find('input[name="review-price"]:checked').prop('checked', false)
            currentElement.closest('.review-fieldset').find('input[name="nickname"]').val("")
            currentElement.closest('.review-fieldset').find('textarea[name="review_content"]').val("")

        });

        ajaxCall.fail(function (json) {
            if (json['responseJSON'] !== undefined) {
                let errors = Object.values(json['responseJSON']['errors']);

                let errormessage = [];
                console.log(errors);
                errormessage = errors.map(function (element, index) {
                    return  element[0]
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
});