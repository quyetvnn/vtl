var ADMIN_MEMBER = {
    url_get_tier_data: '',
    old_tier_id: '',
    init_page: function(){
        COMMON.init_element_number($('#txt_phone'));
        if($('#member_company_id').val() != ""){
            ADMIN_MEMBER.init_select_company($('#member_tier_id'));
        }

        $('#member_company_id').on('change', function(){
            ADMIN_MEMBER.init_select_company($('#member_tier_id'));
        });
    },
    init_select_company: function( tier_ele){
        COMMON.call_ajax({
            url: ADMIN_MEMBER.url_get_tier_data,
            type: 'POST',
            data: {
                company_id: $('#member_company_id').val()
            },
            dataType: 'json',
            success: function(result){
                var html_options = "<option value=''>" + $(tier_ele).find("option").first().text() + "</option>";
                if(result.status === true){
                    for(var key in result['params']){
                        html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                    }
                }

                $(tier_ele).html(html_options);
                if(ADMIN_MEMBER.old_tier_id != "" && $(tier_ele).find("option[value=" + ADMIN_MEMBER.old_tier_id + "]").length){
                    $(tier_ele).val(ADMIN_MEMBER.old_tier_id);
                }
                $(tier_ele).selectpicker('refresh');
            },
            error: function(error){
                alert("Get data for Tier is error!")
            }
        });
    }
}