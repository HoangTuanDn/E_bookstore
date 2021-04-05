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

        app.deleteObject(name, url, currentElement)
    });

})