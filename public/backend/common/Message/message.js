$(function () {
    /*error notification*/
    let message = $("#error-message").attr('data-message');
    if (message) {
        var toastConfig = {
            message : message,
            type    : 'error',
            duration: 3000
        }

        app.getToastr(toastConfig);
        $("#error-message").attr('data-message', ' ')
    }
    /*toast message*/
    let toastMessage = $("#session-message").attr('data-message');
    let type = $("#session-message").attr('data-type');

    if (toastMessage){
        var toastConfig = {
            message: toastMessage,
            type: type,
            duration: 3000
        }

        app.getToastr(toastConfig);
        $("#session-message").attr('data-message', ' ')
    }
});