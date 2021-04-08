$(function () {

    /*message notification*/
    let message = $("#session-message").attr('data-message');
    let type = $("#session-message").attr('data-type');

    if (message){

        var toastConfig = {
            message: message,
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

        app.deleteObject(`Vai trò ${name} sẽ bị xóa ?`, url, currentElement)
    });

})