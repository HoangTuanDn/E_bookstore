$(function (){
    /*share coupon handle*/

    $('*[data-action="btnShareCoupon"]').click(function () {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.attr('href');
        console.log(url)


        let ajaxCall = $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
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

            app.getToastr(toastConfig);
        });

        ajaxCall.fail(function (json) {
            if (json['responseJSON'] !== undefined) {
                let errors = Object.values(json['responseJSON']['errors']);

                let errormessage = [];
                console.log(errors);
                errormessage = errors.map(function (element, index) {
                    return element[0]
                })

                let toastConfig = {
                    message : errormessage[0],
                    type    : 'error',
                    duration: 3000
                }
                app.getToastr(toastConfig);

            }
        });
    })
})