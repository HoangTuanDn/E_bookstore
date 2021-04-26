$(function (){

    /*handle change province and district*/
    $(document).on('change', '*[data-action="select-address"]', function () {
        let currentElement = $(this);
        let data = {};
        let type = currentElement.attr('data-type');
        //console.log(currentElement.closest('[data-action="data-store"]').find('[data-action="select-district"]'))

        if (type === 'province'){
            data = {
                'province_id' : currentElement.val()
            }
        }
        if (type === 'district'){
            data = {
                'district_id' : currentElement.val()
            }
        }

        let url = currentElement.closest('*[data-action="store-data"]').attr('data-url');
        console.log(url)

        $.ajax({
            url     : url,
            type    : 'GET',
            dataType: 'json',
            data   : data,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (json) {
                if (type === 'province'){
                    currentElement.closest('*[data-action="store-data"]').find('#district').append(json['data']['districtHtml'])
                }
                if (type === 'district'){
                    currentElement.closest('*[data-action="store-data"]').find('#ward').append(json['data']['wardHtml'])
                }
            },
        })

    });

    /*handle change price*/
    $(document).on('blur', '*[data-action="change-price"]', function () {
        event.preventDefault();
        let currentElement = $(this);
        let newPrice = currentElement.text();
        let url = currentElement.attr('data-url')

        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            data   : {
                'new_price' : newPrice
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (json) {
                if (json['success'] == true){
                    currentElement.text(json['data']['price'])
                    let toastConfig = {
                        message: json['data']['message'],
                        type: json['data']['type'],
                        duration: 3000
                    }

                    app.getToastr(toastConfig);
                }
            },
        })
    });

})