$(function () {

    let currentLocation = window.location.href;
    currentLocation = currentLocation.replace(window.location.origin, '');
    currentLocation = currentLocation.split('/');
    let currentIndex = currentLocation[2];
    let convertIndexConvert = {
        'categories' : 'Danh mục',
        'products'   : 'Sản phẩm',
        'orders'     : 'Đơn hàng',
        'users'      : 'Quản trị viên',
        'roles'      : 'Vai trò',
        'permissions': 'Quền truy cập',
        'settings'   : 'Thiết lập',
        'menus'      : 'Menu',
        'blog'       : 'Thể loại bài viết',
        'blogs'      : 'Bài viết',
    }

    /*delete product*/
    $('*[data-action="btnDelete"]').click(function () {
        event.preventDefault();
        var name = $(this).attr('data-name')
        var url = $(this).attr('data-url');
        var currentElement = $(this);

        app.deleteObject(`${convertIndexConvert[currentIndex]} ${name} sẽ bị xóa ?`, url, currentElement)
    });


    if ($('#inputTag').length) {
        app.select2Tag($("#inputTag"));
    }
    if ($("#inputStatus").length) {
        app.select2Option($("#inputStatus"), 'Chọn danh mục')
    }
    if ($("#inputBlogCategory").length) {
        app.select2Option($("#inputBlogCategory"), 'Chọn danh mục bài viết')
    }
    if ($("#inputRoles").length) {
        app.select2Option($("#inputRoles"), 'Chọn vai trò')
    }
})