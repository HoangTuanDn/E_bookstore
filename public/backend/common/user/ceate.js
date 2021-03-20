$(function (){

    /*error notification*/
    let message = $("#error-message").attr('data-message');
    if (message) {
        var toastConfig = {
            message : message,
            type    : 'error',
            duration: 3000
        }

        app.getToastr(toastConfig);
        $("#session-message").attr('data-message', '')
    }

    /*select 2 use */

    app.select2Option($("#inputRoles"), 'Chọn vai trò')

})