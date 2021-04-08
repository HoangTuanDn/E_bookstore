$(function () {
    /*message notification*/
    let message = $("#session-message").attr('data-message');
    let type = $("#session-message").attr('data-type');

    if (message){
        if (type){
            var toastConfig = {
                message: message,
                type: type,
                duration: 3000
            }
        }else {
            var toastConfig = {
                message : message,
                type    : 'error',
                duration: 3000
            }

        }
        app.getToastr(toastConfig);
        $("#session-message").attr('data-message', '')
    }

    /*delete product*/
    $('*[data-action="btnDelete"]').click(function (){
        event.preventDefault();

        var name = $(this).attr('data-name')
        var url = $(this).attr('data-url');
        var currentElement = $(this);

        app.deleteObject(`Thiết lập ${name} sẽ bị xóa ?`, url, currentElement)
    });
});