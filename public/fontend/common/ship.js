$(function () {
    /*handle change province and district*/
    $(document).on('change', '*[data-action="select-address"]', function () {
        let currentElement = $(this);
        let data = {};
        let type = currentElement.attr('data-type');
        //console.log(currentElement.closest('[data-action="data-store"]').find('[data-action="select-district"]'))


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

        let url = currentElement.closest('*[data-action="store-data"]').attr('data-url');
        console.log(url)

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
        let url = currentElement.closest('form').attr('action');
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
})