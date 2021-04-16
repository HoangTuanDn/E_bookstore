$(function (){

    /*error notification*/
    let messageError = $("#error-message").attr('data-message');
    let sessionMessage = $("#session-message").attr('data-message');
    let type = $("#session-message").attr('data-type');

    if (messageError) {
        let toastConfig = {
            message : messageError,
            type    : 'error',
            duration: 3000
        }

        app.getToastr(toastConfig);
        $("#session-message").attr('data-message', '')
    }

    /*message notification*/

    if (sessionMessage){

        let toastConfig = {
            message: sessionMessage,
            type: type,
            duration: 3000
        }

        app.getToastr(toastConfig);
        $("#session-message").attr('data-message', '')
    }

    /*delete product*/
    $('*[data-action="btnDelete"]').click(function (){
        console.log('a')

        event.preventDefault();

        var name = $(this).attr('data-name')
        var url = $(this).attr('data-url');
        var currentElement = $(this);

        app.deleteObject(`Mã giảm giá ${name} sẽ bị xóa ?`, url, currentElement)
    });
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