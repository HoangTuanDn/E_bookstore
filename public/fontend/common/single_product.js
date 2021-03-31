$(function (){
    $('*[data-action="btnFilterPrice"]').click(function (){
        event.preventDefault();
        var url = $(this).attr('href');

        let data = $(this).closest('.filter_price').find('#amount').val();
        let number = data.match(/(\d+)/g);
        console.log(data)
        let filterPrice = `?price_min=${number[0]}&price_max=${number[1]}`
        url = url + filterPrice;

        $(location).attr('href', url);
    });
});