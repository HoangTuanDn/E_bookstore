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


        Swal.fire({
            title: 'Bạn có chắc không?',
            text: `Danh mục sản phẩm ${name} sẽ bị xóa ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#dd3333',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ',

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url     : url,
                    type    : 'post',
                    dataType: 'json',
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function (json) {
                        Swal.fire(
                            'Deleted!',
                            'Danh mục đã được xóa',
                            'success'
                        )
                        if (Array.isArray(json['id'])){
                            json['id'].forEach((item, index) => {
                                $('*[data-id = "'+ item +'"]').css('background','tomato')
                                $('*[data-id = "'+ item +'"]').fadeOut(800,function(){
                                    $(this).remove();
                                });
                            })

                        }
                        else {
                            currentElement.closest('tr').css('background','tomato');
                            currentElement.closest('tr').fadeOut(800,function(){
                                $(this).remove();
                            });
                        }

                    },

                });

            }
        })
    });

})