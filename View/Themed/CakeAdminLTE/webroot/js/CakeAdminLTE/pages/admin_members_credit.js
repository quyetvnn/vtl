ADMIN_MEMBERS_CREDIT = {

    school_admin: 3,
    student     : 2,
    url_get_member: "",
    
    init_page: function() {
      
        $('#credit_type_id').on('change', function() {
            if ($('#credit_type_id').val() == 3 || $('#credit_type_id').val() == 4) {  //student
                ADMIN_MEMBERS_CREDIT.load_child_element($('#member_id'), ADMIN_MEMBERS_CREDIT.url_get_member, ADMIN_MEMBERS_CREDIT.student);
            
            } else if ($('#credit_type_id').val() == 1 || $('#credit_type_id').val() == 2) {  
                ADMIN_MEMBERS_CREDIT.load_child_element($('#member_id'), ADMIN_MEMBERS_CREDIT.url_get_member, ADMIN_MEMBERS_CREDIT.school_admin);
            }
        });

        $('#school_id').on('change', function() {
            if ($('#credit_type_id').val() == 3 || $('#credit_type_id').val() == 4) {  //student
                ADMIN_MEMBERS_CREDIT.load_child_element($('#member_id'), ADMIN_MEMBERS_CREDIT.url_get_member, ADMIN_MEMBERS_CREDIT.student);
            
            } else if ($('#credit_type_id').val() == 1 || $('#credit_type_id').val() == 2) {  
                ADMIN_MEMBERS_CREDIT.load_child_element($('#member_id'), ADMIN_MEMBERS_CREDIT.url_get_member, ADMIN_MEMBERS_CREDIT.school_admin);
            }

        });

    },
  
   
    
    load_child_element: function(child_ele, url, role) {
        COMMON.call_ajax({
            url: url,  
            type: 'POST',
            data: {
                school_id: $('#school_id').val(),
                role:   role,      // school admin, get all
            },
            dataType: 'json',
            success: function(result){
                html_options = "";
                $(child_ele).html(html_options);

                if(result.status === true){

                    var html_options = "<option value=''>" + $(child_ele).find("option").first().text() + "</option>";
                  
                    for(var key in result['params']){
                        html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                    }

                    // var n = Object.keys(result['params']).length;   // if params object -> use this
                    // // result['params'].length: if params array -> use this

                    // if (n == 0) {
                    //     $(child_ele).attr('disabled', 'disabled');

                    // } else {
                    //     $(child_ele).removeAttr('disabled');
                    // }
                }

                $(child_ele).html(html_options);
                $(child_ele).selectpicker('refresh');
            },
            error: function(error){
                alert("Get data error!")
            }
        });
    },

}
