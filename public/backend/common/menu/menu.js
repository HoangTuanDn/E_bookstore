$(function (){

    let message = $("#session-message").attr('data-message');
    let type = $("#session-message").attr('data-type');

    type = type == 1 ? 'success' : 'error';
    if (message){

        var toastConfig = {
            message: message,
            type: type,
            duration: 3000
        }

        app.getToastr(toastConfig);
        $("#session-message").attr('data-message', '')
    }


    $('*[data-action="btnDelete"]').click(function (){

        event.preventDefault();

        var name = $(this).attr('data-name')
        var url = $(this).attr('data-url');
        var currentElement = $(this);

        app.deleteObject(name, url, currentElement)
    });
})