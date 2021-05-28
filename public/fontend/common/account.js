$(function () {
    $(document).on('click', '*[data-action="login"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);
        let rememberMe = currentElement.closest('form').find('input[name="remember_me"]').prop('checked');
        let url = currentElement.closest('form').attr('action');
        let data = {
            'username_or_email': currentElement.closest('form').find('input[name="username_or_email"]').val(),
            'password'         : currentElement.closest('form').find('input[name="password"]').val(),
        };

        if (rememberMe) {
            data["remember_me"] = rememberMe;
        }

        $.ajax({
            url     : url,
            type    : 'post',
            data    : data,
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                if (json['success'] === true) {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    setTimeout(function () {
                        window.location.href = json['data']['url_redirect'];
                    }, 1000)
                }

            },
            error   : function (json) {
                if (json['responseJSON'] !== undefined) {
                    let errors = Object.values(json['responseJSON']['errors']);

                    let errormessage = [];
                    console.log(errors);
                    errormessage = errors.map(function (element, index) {
                        return element[0]
                    })

                    var toastConfig = {
                        message : errormessage[0],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)

                }
            }

        })

    })

    /*handle send reset password link*/
    $(document).on('click', '*[data-action="send-link-password"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);
        let url = currentElement.closest('form').attr('action');
        let data = {
            'email': currentElement.closest('form').find('input[name="email"]').val(),
        };

        $.ajax({
            url     : url,
            type    : 'post',
            data    : data,
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                if (json['success'] === true) {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                    /*setTimeout(function () {
                        window.location.href = json['data']['url_redirect'];
                    }, 1000)*/
                }

            },
            error   : function (json) {
                if (json['responseJSON'] !== undefined) {
                    let errors = Object.values(json['responseJSON']['errors']);

                    let errormessage = [];
                    console.log(errors);
                    errormessage = errors.map(function (element, index) {
                        return element[0]
                    })

                    var toastConfig = {
                        message : errormessage[0],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)

                }
            }

        })

    })

    /*register */
    $(document).on('click', '*[data-action="register"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.closest('form').attr('action');
        let data = {
            'name'       : currentElement.closest('form').find('input[name="name"]').val(),
            'email'      : currentElement.closest('form').find('input[name="email"]').val(),
            'password'   : currentElement.closest('form').find('input[name="password"]').val(),
            're_password': currentElement.closest('form').find('input[name="re_password"]').val(),
        }


        $.ajax({
            url     : url,
            type    : 'post',
            data    : data,
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                if (json['success'] === true) {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)
                }
            },
            error   : function (json) {
                if (json['responseJSON'] !== undefined) {
                    let errors = Object.values(json['responseJSON']['errors']);

                    let errormessage = [];
                    console.log(errors);
                    errormessage = errors.map(function (element, index) {
                        return element[0]
                    })

                    var toastConfig = {
                        message : errormessage[0],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)

                }
            }

        })

    })

    /*handle reset password*/
    $(document).on('click', '*[data-action="reset-password"]', function (e) {
        event.preventDefault()
        let currentElement = $(this);

        let url = currentElement.closest('form').attr('action');
        let data = {
            'token'       : currentElement.attr('data-token'),
            'email'      : currentElement.closest('form').find('input[name="email"]').val(),
            'password'   : currentElement.closest('form').find('input[name="password"]').val(),
            'password_confirmation': currentElement.closest('form').find('input[name="password_confirmation"]').val(),
        }
        console.log(data)

        $.ajax({
            url     : url,
            type    : 'post',
            data    : data,
            dataType: 'json',
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function (json) {
                if (json['success'] === true) {
                    var toastConfig = {
                        message : json['data']['message'],
                        type    : json['data']['type'],
                        duration: 3000
                    }
                    toast(toastConfig)

                    setTimeout(function () {
                        window.location.href = json['data']['url_redirect'];
                    }, 1000)
                }
            },
            error   : function (json) {
                if (json['responseJSON'] !== undefined) {
                    let errors = Object.values(json['responseJSON']['errors']);

                    let errormessage = [];
                    console.log(errors);
                    errormessage = errors.map(function (element, index) {
                        return element[0]
                    })

                    var toastConfig = {
                        message : errormessage[0],
                        type    : 'error',
                        duration: 3000
                    }
                    toast(toastConfig)

                }
            }

        })

    })
})