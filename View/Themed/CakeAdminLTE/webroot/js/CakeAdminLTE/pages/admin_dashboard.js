var ADMIN_DASHBOARD = {
    url_total_member: '',
    url_promotion: '',
    url_age_range_distribution: '',
    url_platform_distribution: '',
    url_register_number: '',
    url_register_percent: '',
    url_get_shop_data: '',
    url_get_coupon_data: '',
    url_get_coupon_usage: '',
    url_get_report_notification: '',
    doughnut_options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                        return parseInt(previousValue) + parseInt(currentValue);
                    });
                    var currentValue = parseInt(dataset.data[tooltipItem.index]);
                    var precentage = Math.floor(((currentValue/total) * 100)+0.5);  
                    return precentage + "%";
                }
            }
        }
    },
    init_page: function() {
        // init element form filter
        COMMON.init_yearmonthpicker();
        $('.dashboard-shop-selectpicker').selectpicker({
            'noneSelectedText': 'All Shops'
        });

        $('.dashboard-coupon-selectpicker').selectpicker({
            'noneSelectedText': 'All Coupons'
        });
        // END init element form filter

        ADMIN_DASHBOARD.init_total_member();
        ADMIN_DASHBOARD.init_get_promotions();
        ADMIN_DASHBOARD.init_age_range_distribution(false);
        ADMIN_DASHBOARD.init_platform_distribution(false);
        ADMIN_DASHBOARD.init_register_member(false);
        ADMIN_DASHBOARD.init_registration_percent(false);
        ADMIN_DASHBOARD.init_coupon_usage();
        ADMIN_DASHBOARD.init_report_notification();

        // action click load total number
        $('.btn-refresh-total-number').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_total_member();
        });

        // action click load total number
        $('.btn-refresh-promotion').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_get_promotions();
        });

        $('.btn-refresh-age-distribution').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_age_range_distribution(true);
        });

        $('.btn-refresh-platform-distribution').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_platform_distribution(true);
        });

        // action click load register number
        $('.btn-refresh-registration-number').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_register_member(true);
        });

        $('.btn-refresh-registration-line-chart').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_registration_percent(true);
        })

        $('#ddl-dashboard-brand').on('change', function(){
            COMMON.call_ajax({
                url: ADMIN_DASHBOARD.url_get_shop_data,
                type: 'POST',
                data: {
                    brand_id: $(this).val(),
                },
                dataType: 'json',
                success: function(result){
                    if(result.status) {
                        var html_options = "";
                        for(var key in result['params']){
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }

                        $('#ddl-dashboard-shop').html(html_options);
                        $('#ddl-dashboard-shop').selectpicker('refresh');
                    } else {
                        alert("Get data for Shop Data is Error!")
                    }
                },
                error: function(error){
                    alert("Get data for Shop Data is Error!")
                }
            });

            COMMON.call_ajax({
                url: ADMIN_DASHBOARD.url_get_coupon_data,
                type: 'POST',
                data: {
                    brand_id: $(this).val(),
                },
                dataType: 'json',
                success: function(result){
                    if(result.status) {
                        var html_options = "";
                        for(var key in result['params']){
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }

                        $('#ddl-dashboard-coupon').html(html_options);
                        $('#ddl-dashboard-coupon').selectpicker('refresh');
                    } else {
                        alert("Get data for Coupon Data is Error!")
                    }
                },
                error: function(error){
                    alert("Get data for Coupon Data is Error!")
                }
            });
        });

        $('#ddl-dashboard-shop').on('change', function(){
            var data = {};
            if($(this).val()){
                data['shop_id'] = $(this).val()
            }else{
                data['brand_id'] = $('#ddl-dashboard-brand').val()
            }

            COMMON.call_ajax({
                url: ADMIN_DASHBOARD.url_get_coupon_data,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(result){
                    if(result.status) {
                        var html_options = "";
                        for(var key in result['params']){
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }

                        $('#ddl-dashboard-coupon').html(html_options);
                        $('#ddl-dashboard-coupon').selectpicker('refresh');
                    } else {
                        alert("Get data for Coupon Data is Error!")
                    }
                },
                error: function(error){
                    alert("Get data for Coupon Data is Error!")
                }
            });
        });

        $('.btn-refresh-coupon-usage').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_coupon_usage();
        });

        $('.btn-refresh-report-notification').on('click', function(eve){
            eve.preventDefault();
            ADMIN_DASHBOARD.init_report_notification();
        });
    },
    init_total_member: function(){
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_total_member,
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(result){
                if(result.status){
                    $('.dashboard-total-member-area').html(result.params)
                }else{
                    alert("Get data for Total Number is Error!")
                }
            },
            error: function(error){
                alert("Get data for Total Number is Error!")
            }
        });
    },
    init_get_promotions: function(){
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_promotion,
            type: 'POST',
            data: {},
            dataType: 'json',
            success: function(result){
                if(result.status){
                    $('.dashboard-promotion-area').html(result.params)
                }else{
                    alert("Get data for Promotion is Error!")
                }
            },
            error: function(error){
                alert("Get data for Promotion is Error!")
            }
        });
    },
    init_age_range_distribution: function(is_get_data) {
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_age_range_distribution,
            type: 'POST',
            data: {
                is_get_new: (is_get_data ? 'Y' : 'N'),
            },
            dataType: 'json',
            success: function(result){
                if(result.status) {
                    $('.age-distribution-as-of').text(result.params.updated);
                    var myDoughnutChart = new Chart('age-distribution', {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: result.params.data,
                                backgroundColor: result.params.background_color,
                            }],
                            labels: result.params.labels
                        },
                        options: ADMIN_DASHBOARD.doughnut_options
                    });
                } else {
                    alert("Get data for Age Range Distribution is Error!")
                }
            },
            error: function(error){
                alert("Get data for Age Range Distribution is Error!")
            }
        });
    },
    init_platform_distribution: function(is_get_data) {
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_platform_distribution,
            type: 'POST',
            data: {
                is_get_new: (is_get_data  ? 'Y' : 'N'),
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    $('.platform-distribution-as-of').text(result.params.updated);
                    var myDoughnutChart = new Chart('platform-distribution', {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: result.params.data,
                                backgroundColor: result.params.background_color,
                            }],
                            labels: result.params.labels
                        },
                        options: ADMIN_DASHBOARD.doughnut_options
                    });
                }else{
                    alert("Get data for Platform Distribution is Error!")
                }
                
            },
            error: function(error){
                alert("Get data for Platform Distribution is Error!")
            }
        });
    },
    init_register_member: function(is_get_data){
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_register_number,
            type: 'POST',
            data: {
                is_get_new: (is_get_data  ? 'Y' : 'N'),
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    $('.dashboard-registration-number-area').html(result.params)
                }else{
                    alert("Get data for Registration Number is Error!")
                }
            },
            error: function(error){
                alert("Get data for Registration Number is Error!")
            }
        });
    },
    init_registration_percent: function(is_get_data) {
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_register_percent,
            type: 'POST',
            data: {
                is_get_new: (is_get_data  ? 'Y' : 'N'),
            },
            dataType: 'json',
            success: function(result){
                if(result.status){
                    $('.registration-line-chart-as-of').text(result.params.updated);
                    var myDoughnutChart = new Chart('registration-line-chart', {
                        type: 'line',
                        data: {
                            datasets: [{
                                data: result.params.render_datas.data,
                                lineTension: 0,
                            }],
                            labels: result.params.render_datas.labels
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.yLabel;
                                    }
                                }
                            }
                        }
                    });
                }else{
                    alert("Get data for Registration % is Error!")
                }
                
            },
            error: function(error){
                alert("Get data for Registration % is Error!")
            }
        });
    },
    init_coupon_usage: function(){
        var data = {
            'month': $('#dashboard-month').val(),
            'coupon_id': [],
        };

        if($('#ddl-dashboard-coupon').val()){
            data['coupon_id'] = $('#ddl-dashboard-coupon').val();
        }else{
            $.each($('#ddl-dashboard-coupon').find('option'), function(key, item){
                data['coupon_id'].push($(item).attr('value'));
            });
        }

        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_get_coupon_usage,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result){
                if(result.status) {
                    $('.dashboard-coupon-usage-area').html(result.params)
                } else {
                    alert("Get data for Coupon Usage is Error!")
                }
            },
            error: function(error){
                alert("Get data for Coupon Usage is Error!")
            }
        });
    },
    init_report_notification: function(){
        COMMON.call_ajax({
            url: ADMIN_DASHBOARD.url_get_report_notification,
            type: 'POST',
            dataType: 'json',
            success: function(result){
                if(result.status) {
                    $('.dashboard-report-notification-area').html(result.params)
                } else {
                    alert("Get data for Report Notification is Error!")
                }
            },
            error: function(error){
                alert("Get data for Report Notification is Error!")
            }
        });
    }
}