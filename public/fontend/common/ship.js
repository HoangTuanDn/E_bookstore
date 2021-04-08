$(function () {
    /*handle change province and district*/
    $(document).on('change', '*[data-action="select-address"]', function () {
        let currentElement = $(this);
        let data = {};
        let type = currentElement.attr('data-type');


        if (type === 'province') {
            data = {
                'province_id': currentElement.val(),
            }
        }
        if (type === 'district') {
            data = {
                'district_id': currentElement.val(),
            }
        }

        if (type === 'ward') {
            data = {
                'province_id': currentElement.closest('.customar__field').find('#province').val(),
                'district_id': currentElement.closest('.customar__field').find('#district').val(),
                'ward_id'    : currentElement.val(),
            }
        }

        // let url = currentElement.closest('*[data-action="store-data"]').attr('data-url');
        let url = window.location.href;

        $.ajax({
            url     : url,
            type    : 'GET',
            dataType: 'json',
            data    : data,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (json) {
                if (type === 'province') {
                    currentElement.closest('*[data-action="store-data"]').find('#district').html(json['data']['districtHtml'])
                }
                if (type === 'district') {
                    currentElement.closest('*[data-action="store-data"]').find('#ward').html(json['data']['wardHtml'])
                }

                if (type === 'ward') {
                    if (json['success'] === true) {
                        var toastConfig = {
                            message : json['data']['message'],
                            type    : 'success',
                            duration: 3000
                        }
                        toast(toastConfig)
                        currentElement.closest('#wrapper').find('.wn__order__box').html(json['data']['detailOrderHtml'])
                    }
                }

            },
        })

    });

    /*apply coupon*/
    $(document).on('click', '*[data-action="apply-coupon"]', function () {
        event.preventDefault();
        let currentElement = $(this);
        /*let url = currentElement.closest('form').attr('action');*/
        let url = window.location.href;

        $.ajax({
            url     : url,
            type    : 'GET',
            dataType: 'json',
            data    : {
                'coupon_code': currentElement.closest('form').find('input[name="coupon_code"]').val()
            },
            headers : {
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

                    if (json['data']['type'] === 'success'){

                        currentElement.closest('#wrapper').find('.wn__order__box').html(json['data']['detailOrderHtml'])
                    }

                } else {
                    var toastConfig = {
                        message : json['message'],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)
                }
            },
        })

    })

    /*handle if not login*/
    $(document).on('click', '*[data-action="login-checkout"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.closest('form').attr('action');
        let data = {
            'username_or_email': currentElement.closest('form').find('input[name="username_or_email"]').val(),
            'password'         : currentElement.closest('form').find('input[name="password"]').val(),
            'remember_me'      : currentElement.closest('form').find('input[name="remember_me"]').val(),
        }

        $.ajax({
            url     : url,
            type    : 'post',
            data    : data,
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                if (json['success'] === true){
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    setTimeout(function (){
                       location.reload();
                    }, 500)
                }

            },
            error   : function (json) {
                if (json['responseJSON'] !== undefined) {
                    let errors = Object.values(json['responseJSON']['errors']);

                    let errormessage = [];
                    console.log(errors);
                    errormessage = errors.map(function (element, index) {
                        return  element[0]
                    })

                    var toastConfig = {
                        message : errormessage[0],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)

                }
            }

        })

    })

    /*handle order*/
    $(document).on('click', '*[data-action="apply-order"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.attr('data-url');

        let data = {
            'coupon_code'         : currentElement.closest('#wrapper').find('input[name="coupon_code"]').val(),
            'full_name'      : currentElement.closest('#wrapper').find('input[name="full_name"]').val(),
            'province_id'      : currentElement.closest('#wrapper').find('#province').val(),
            'district_id'      : currentElement.closest('#wrapper').find('#district').val(),
            'ward_id'      : currentElement.closest('#wrapper').find('#ward').val(),
            'address'      : currentElement.closest('#wrapper').find('input[name="address"]').val(),
            'phone'      : currentElement.closest('#wrapper').find('input[name="phone"]').val(),
            'email'      : currentElement.closest('#wrapper').find('input[name="email"]').val(),
            'payment_id'      : currentElement.closest('#wrapper').find('input[name="payment"]:checked').val(),
        }


        $.ajax({
            url     : url,
            type    : 'post',
            data    : data,
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                console.log(json)

                var toastConfig = {
                    message : json['data']['message'],
                    type    : json['data']['type'],
                    duration: 3000
                }
                toast(toastConfig)

            },
            error   : function (json) {
                if (json['responseJSON'] !== undefined) {
                    let errors = Object.values(json['responseJSON']['errors']);

                    let errormessage = [];
                    console.log(errors);
                    errormessage = errors.map(function (element, index) {
                        return  element[0]
                    })

                    var toastConfig = {
                        message : errormessage[0],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)

                }
            }

        })

    })
})