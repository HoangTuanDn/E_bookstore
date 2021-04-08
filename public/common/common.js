//toast message js
/*web handle*/
var Web = {
    removeURLParameter  : function (url, parameter) {
        var path = url.split('?');

        if (path.length >= 2) {

            var prefix = encodeURIComponent(parameter) + '=';

            var queryStrings = path[1].split(/[&;]/g);

            for (var i = queryStrings.length; i-- > 0;) {
                if (queryStrings[i].lastIndexOf(prefix, 0) !== -1) {
                    queryStrings.splice(i, 1);
                }
            }

            url = path[0] + '?' + queryStrings.join('&');

            return url;
        } else {
            return url;
        }
    },
}

//*toastr*//
var app = {
    getToastr : function ({title = '', message = '', type = 'info', duration = 3000}){

        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",

        }

        toastr[type](message, title)
    },

    select2Tag : function (selector){
        selector.select2({
            tags: true,
            tokenSeparators: [',']
        })
    },

    select2Option : function (selector, text){
        selector.select2({
            placeholder: text,
        })
    },

    deleteObject : function (text, url, currentElement){

        Swal.fire({
            title: 'Bạn có chắc không?',
            text: text,
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
                            json['data']['message'],
                            'success'
                        )
                        currentElement.closest('tr').css('background','tomato');
                        currentElement.closest('tr').fadeOut(800,function(){
                            $(this).remove();
                        });
                    },

                });

            }
        })

    }

}




/*handle toast message*/



function createTostElement(){
    const toastElement = document.createElement('div');
    toastElement.setAttribute('id', 'toast');

    const body = document.getElementsByTagName('body')[0]
    body.appendChild(toastElement);
}

function toast({title = '', message = '', type = 'info', duration = 3000})
{

    const toastElement = document.getElementById('toast');
    const icons = {
        success: 'fa fa-check-circle',
        info   : 'fa fa-info-circle',
        warning: 'fa fa-exclamation-circle',
        error  : 'fa fa-exclamation-circle',
    };
    const icon = icons[type];
    const time = (duration / 1000).toFixed(2)
    const timeOut = duration + 1000;

    if (toastElement) {

        const toastContent = document.createElement('div');
        toastContent.style.animation = `slideInLeft ease 0.3s, fadeOut linear 1s ${time}s forwards`;

        const autoRemoveId = setTimeout(function () {
            toastElement.removeChild(toastContent)
            //body.removeChild(toast);
        }, timeOut)

        toastContent.onclick = function (e) {
            if (e.target.closest('.toast__close')) {
                toastElement.removeChild(toastContent);
                //body.removeChild(toast);
                clearTimeout(autoRemoveId);

            }
        }

        toastContent.classList.add('toast', `toast--${type}`);
        toastContent.innerHTML = `
                <div class="toast__icon">
                    <i class="${icon}"></i>
                </div>
                <div class="toast__body">
                    <h3 class="toast__title">${title}</h3>
                    <p class="toast__msg">${message}</p>
                 </div>
                <div class="toast__close">
                     <i class="fa fa-times"></i>
                </div>
        `;

        toastElement.appendChild(toastContent);
    }
}

//*hide cart box*/
function hideCartBox() {
    $('.minicart__active').removeClass('is-visible');
}
/*render html content*/
var renderHtml = function (url, elementWrapper, data = {}) {

    $.ajax({
        url    : url,
        method : 'get',
        data   : data,
        success: function (json) {
            if (json['success']) {
                elementWrapper.html(json['html']['content']);
                if (json['data']['url']) {
                    window.history.pushState('object or string', 'Title', json['data']['url'])
                }
            }

        }
    })
}

/*remove cart item*/
function removeItemCart(url, data, currentElement, type) {
    $.ajax({
        url     : url,
        type    : 'post',
        dataType: 'json',
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data    : {
            'id': data['id'],
        },
        success : function (json) {

            if (json['data']['type'] == 'info') {
                var toastConfig = {
                    message : json['data']['message'],
                    type    : json['data']['type'],
                    duration: 3000
                }
                toast(toastConfig)
                currentElement.closest('#wrapper').find('.product_qun').text(json['data']['content']['totalItem']);
                if (type === 'box') {
                    currentElement.closest('.item01').fadeOut(800, function () {
                        $(this).remove();
                    })
                    let totalItemText = json['data']['content']['totalItem'] > 1 ? json['data']['content']['totalItem'] + ' items' : json['data']['content']['totalItem'] + ' item'

                    currentElement.closest('#wrapper').find('.total-text').text(totalItemText);
                    currentElement.closest('#wrapper').find('.total_amount').html(`<span>${json['data']['content']['totalPrice']}</span>`);
                } else {
                    currentElement.closest('#wrapper').find('.product_qun').text(json['data']['content']['totalItem']);
                    $('.cart-form').html(json['data']['content']['html']);
                    $('.grand_total_cart').text(json['data']['content']['totalPrice']);
                }

            }
        }
    })
}