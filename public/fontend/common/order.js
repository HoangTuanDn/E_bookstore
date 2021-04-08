$(function () {

    $(document).on('click', '*[data-action="destroy-order"]', function () {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.attr('href');
        let code = currentElement.attr('data-code')
        let title = currentElement.attr('data-title')
        let ok = currentElement.attr('data-ok')
        let cancel = currentElement.attr('data-cancel')
        let textSuccess = currentElement.attr('data-success')
        let textWarning = currentElement.attr('data-warning')
        destroyOrder(`Bạn xác nhận muốn hủy đơn hàng ${code} ?`, title, ok, cancel, url, currentElement, textSuccess, textWarning)

    });

    function destroyOrder(text, title, ok, cancel, url, currentElement, textSuccess, textWarning) {
        Swal.fire({
            title             : title,
            text              : text,
            icon              : 'warning',
            showCancelButton  : true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor : '#dd3333',
            confirmButtonText : ok,
            cancelButtonText  : cancel,

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
                        if (json['success'] === true){
                            Swal.fire(
                                textSuccess,
                                json['data']['message'],
                                'success'
                            )
                            currentElement.closest('#order-detail').css('background', 'tomato');
                            currentElement.closest('#order-detail').fadeOut(800, function () {
                                $(this).remove();
                            });
                        }else {
                            Swal.fire(
                                textWarning,
                                json['data']['message'],
                                'warning'
                            )
                        }
                    },

                });

            }
        })

    }

});