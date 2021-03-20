$(function (){
    /*handle checked input*/

    $('.check-warapper').click(function (){
        $(this).closest('.card').find('.check-children').prop('checked', $(this).prop('checked'))
    });

    $('.check-children').click(function (){
        let totalCheckbox = $(this).closest('.custom-body').find('.check-children').prop('type', 'checkbox').length;
        let numberOfCheck = $(this).closest('.custom-body').find('.check-children:checked').length;

        if (numberOfCheck === totalCheckbox){
            $(this).closest('.card').find('.check-warapper').prop('checked', 'checked');
        }else {
            $(this).closest('.card').find('.check-warapper').prop('checked', false)
        }

    });

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

})