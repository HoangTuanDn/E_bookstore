$(function () {
    'use strict'

    let ajaxCall = $.ajax({
        url     : window.location.href,
        type    : 'get',
        dataType: 'json',
        headers : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })

    ajaxCall.done(function (json) {
        let currentTime = new Date();
        let currentYear = currentTime.getFullYear();
        let lastYear = currentYear - 1;
        let dataChartCurrentYear = Object.values(json['data']['chart'][currentYear]);
        let dataChartLastYear = Object.values(json['data']['chart'][lastYear]);
        let labels = Object.keys(json['data']['chart'][currentYear]).map((item, index)=> `Tháng ${item}`)

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true

        var $salesChart = $('#sales-chart')
        // eslint-disable-next-line no-unused-vars
        var salesChart = new Chart($salesChart, {
            type   : 'bar',
            data   : {
                labels  : labels,
                datasets: [
                    {
                        backgroundColor: '#007bff',
                        borderColor    : '#007bff',
                        data           : dataChartCurrentYear
                    },
                    {
                        backgroundColor: '#ced4da',
                        borderColor    : '#ced4da',
                        data           : dataChartLastYear
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                tooltips           : {
                    mode     : mode,
                    intersect: intersect
                },
                hover              : {
                    mode     : mode,
                    intersect: intersect
                },
                legend             : {
                    display: false
                },
                scales             : {
                    yAxes: [{
                        // display: false,
                        gridLines: {
                            display      : true,
                            lineWidth    : '4px',
                            color        : 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks    : $.extend({
                            beginAtZero: true,

                            // Include a dollar sign in the ticks
                            callback: function (value) {
                                if (value >= 1000000) {
                                    value /= 1000000
                                    value += 'triệu'
                                }

                                return value
                            }
                        }, ticksStyle)
                    }],
                    xAxes: [{
                        display  : true,
                        gridLines: {
                            display: false
                        },
                        ticks    : ticksStyle
                    }]
                }
            }
        })

    });

    /*handle download export*/
    $(document).on('click', '*[data-action="excel-download"]', function () {
        event.preventDefault();
        $('.buttons-excel').click();
    });

    $(document).on('click', '*[data-action="pdf-download"]', function () {
        event.preventDefault();
        $('.buttons-pdf').click();
    });
})

