var ADMIN_ADMINISTRATOR = {
    url_get_brand_data: '',
    init_select_brand: function(company_ele, brand_ele){
        $(company_ele).on('change', function(){
            COMMON.call_ajax({
                url: ADMIN_ADMINISTRATOR.url_get_brand_data,
                type: 'POST',
                data: {
                    company_id: $(this).val()
                },
                dataType: 'json',
                success: function(result){
                    var html_options = "<option value=''>" + $(brand_ele).find("option").first().text() + "</option>";
                    if(result.status === true){
                        for(var key in result['params']){
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }
                    }

                    $(brand_ele).html(html_options);
                    if(ADMIN_ADMINISTRATOR.old_promotion_id != "" && $(brand_ele).find("option[value=" + ADMIN_ADMINISTRATOR.old_promotion_id + "]").length){
                        $(brand_ele).val(ADMIN_ADMINISTRATOR.old_promotion_id);
                    }
                    $(brand_ele).selectpicker('refresh');
                },
                error: function(error){
                    alert("Get data for brand is error!")
                }
            });
        });
    }
}