$(function (){

    /*create toast element*/
    createTostElement();

    /*handle load wishlist*/
    let tableElement = $('table');
    let wishlist = JSON.parse(localStorage.getItem('data'));
    let idsExist = $('input[type="hidden"]').val();
    idsExist = idsExist.split(',');

    if (wishlist && wishlist !== []){
        let data = wishlist.map(function (item, index){
            if (idsExist.includes(item['id'])){
                item['status'] = true
            }else {
                item['status'] = false
            }
            return item;
        })


        let addText = $('input[class="add_text"]').val();
        let stock_true = $('input[class="stock_true"]').val();
        let stock_false = $('input[class="stock_false"]').val();
        let url_store = $('input[class="url_store"]').val();
        let dataHtml = renderHtml(data, addText ,stock_true, stock_false, url_store);

        tableElement.find('tbody').html(dataHtml);

        /*add first product to cart*/
        $(document).on('click','*[data-action="add_to_cart"]',function (){

            event.preventDefault()
            let currentElement = $(this);
            let url = url_store;

            let data = {
                'id'  : currentElement.attr('data-id')
            }

            $.ajax({
                url     : url,
                type    : 'post',
                dataType: 'json',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data   : data,
                success: function (json) {
                    if (json['success']){
                        var toastConfig = {
                            message: json['data']['message'],
                            type: json['data']['type'],
                            duration: 3000
                        }
                        toast(toastConfig)
                    }
                    else {
                        var toastConfig = {
                            message: json['message'],
                            type: 'error',
                            duration: 3000
                        }
                        toast(toastConfig)
                    }
                }
            })

        })
        /*handle remove wishlist*/
        $(document).on('click','*[data-action="btnRemove"]',function (){
            event.preventDefault();
            let currentElement = $(this);
            let wishlist = JSON.parse(localStorage.getItem('data'));
            let idDelete = $(this).attr('data-id');

            let message = $('input[class="delete_wishlist_text"]').val();
            let item = wishlist.filter((item,index) =>  item['id'] === idDelete)

            message = message.replace(':name', item[0]['name']);

            if (wishlist) {
                let dataUpdate = wishlist.reduce(function (accumulator, item, index) {
                    if (item['id'] !== idDelete){
                        accumulator.push(item)
                    }
                    return accumulator;
                },[])

                localStorage.setItem('data', JSON.stringify(dataUpdate));
                currentElement.closest('tr').fadeOut(800,function(){
                    $(this).remove();
                })

                let toastConfig = {
                    message: message,
                    type: 'info',
                    duration: 3000
                }
                toast(toastConfig)
            }
        })

    }

    function renderHtml(data, addText ,stock_true, stock_false, url_store ){
        let dataHtml = '';
        data.forEach((item, index) => {
            let status = item['status'] ? stock_true : stock_false;
            dataHtml += `<tr>
                              <td class="product-remove"><a data-id="${item['id']}" data-action="btnRemove" href="#">×</a></td>
                              <td class="product-thumbnail"><a href="${item['url']}"><img width="80px" height="100px" src="${item['image']}" alt=""></a></td>
                              <td class="product-name"><a href="${item['url']}">${item['name']}</a></td>
                              <td class="product-price"><span class="amount">${item['new_price']}</span></td>
                              <td class="product-stock-status"><span class="wishlist-in-stock">${status}</span></td>
                              <td class="product-add-to-cart"><a data-id="${item['id']}" data-action="add_to_cart" href="${url_store}">${addText}</a></td>
                         </tr>`
        })

        return dataHtml;
    }

})
