$(function () {
    /*delete product*/
    $('*[data-action="btnDelete"]').click(function (){
        event.preventDefault();

        var name = $(this).attr('data-name')
        var url = $(this).attr('data-url');
        var currentElement = $(this);


        app.deleteObject(`Đơn hàng ${name} sẽ bị xóa ?`, url, currentElement)
    });

    /*handle change status*/

    $(document).on('change', '*[data-action="change-status"]', function () {
        let currentElement = $(this);
        let url = currentElement.attr('data-url')
        let data = {
            'status' : currentElement.val()
        }

        var ajaxCall = $.ajax({
            method: 'post',
            data: data,
            dataType: 'json',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        ajaxCall.done(function(json) {
            var toastConfig = {
                message : json['data']['message'],
                type    : json['data']['type'],
                duration: 3000
            }
            app.getToastr(toastConfig);
            if (json['success'] === true) {
                    currentElement.closest('tr').find('.date-update').text(json['data']['updated_at'])

            }
        });
    });
});