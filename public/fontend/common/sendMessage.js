$(function () {
    $('*[data-action="send-message"]').click(function () {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.closest('#contact-form').attr('action');


        let data = {
            'name': currentElement.closest('#contact-form').find('input[name="name"]').val(),
            'email'    : currentElement.closest('#contact-form').find('input[name="email"]').val(),
            'subject'  : currentElement.closest('#contact-form').find('input[name="subject"]').val() ?? '',
            'message'  : currentElement.closest('#contact-form').find('textarea').val(),
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
            var toastConfig = {
                message : json['data']['message'],
                type    : json['data']['type'],
                duration: 3000
            }
            toast(toastConfig)
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
                toast(toastConfig)

            }
        });
    })
});