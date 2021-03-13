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

//*toastr*/\
var app = {
    getToastr : function ({title = '', message = '', type = 'info', duration = 3000}){

        // toastr.options.progressBar = true
        // toastr.options.closeButton = true
        // toastr.options.newestOnTop = false
        // toastr.options.positionClass = "toast-top-right"
        // toastr.options.showDuration = duration


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
        success: 'fas fa-check-circle',
        info   : 'fas fa-info-circle',
        warning: 'fas fa-exclamation-circle',
        error  : 'fas fa-exclamation-circle',
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
                     <i class="fas fa-times"></i>
                </div>
        `;

        toastElement.appendChild(toastContent);
    }
}
