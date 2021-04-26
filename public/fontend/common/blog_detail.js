$(function () {

    $('*[data-action="post-comment"]').click(function () {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.closest('.comment__form').attr('action');


        let data = {
            'comment': currentElement.closest('.comment__form').find('textarea[name="comment"]').val(),
            'parent_id' : currentElement.attr('data-parent'),
            'blog_id' : currentElement.attr('data-id'),
        }
        console.log(data)

        let ajaxCall = $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            data    : data,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })

        ajaxCall.done(function (json) {
            $('.blog-details').find('.comments_area').html(json['data']['html_comment']);
        });

        ajaxCall.fail(function (json) {
            if (json['responseJSON'] !== undefined) {
                let errors = Object.values(json['responseJSON']['errors']);

                let errormessage = [];
                console.log(errors);
                errormessage = errors.map(function (element, index) {
                    return element[0]
                })

                let toastConfig = {
                    message : errormessage[0],
                    type    : 'error',
                    duration: 3000
                }
                toast(toastConfig)

            }
        });
    })

    $(document).on('click', '*[data-action="repy-comment"]', function () {
        event.preventDefault();
        let id = $(this).attr('data-id');
        $(this).closest('.comment__list').find('a[data-action="post-comment"]').attr('data-parent', id);
/*        $('.content_reply').hide()*/
        $(this).closest('.comment__list').find('.content_reply').toggle();
    });


});