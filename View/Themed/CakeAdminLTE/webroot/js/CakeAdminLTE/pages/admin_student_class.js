ADMIN_STUDENT_CLASS = {

    school_class_id:    "",
    url_get_school_class: "",
    url_get_member: "",
    noneSelectedText: "",
    
    init_page: function() {

        ADMIN_STUDENT_CLASS.init_select_school(  $('#school_id'), $('#student_id'), ADMIN_STUDENT_CLASS.url_get_member );
        ADMIN_STUDENT_CLASS.init_select_school(  $('#school_id'), $('#school_class_id'), ADMIN_STUDENT_CLASS.url_get_school_class );
        $('.student-class-selectpicker').selectpicker({
            'noneSelectedText': ADMIN_STUDENT_CLASS.noneSelectedText
        });

    },

    add_page: function() {
        ADMIN_STUDENT_CLASS.load_child_element( $('#student_id'), ADMIN_STUDENT_CLASS.url_get_member );
        ADMIN_STUDENT_CLASS.load_child_element( $('#school_class_id'), ADMIN_STUDENT_CLASS.url_get_school_class );

    },
  
    load_child_element: function(child_ele, url) {
        COMMON.call_ajax({
            url: url,  
            type: 'POST',
            data: {
                school_id: $('#school_id').val(),
            },
            dataType: 'json',
            success: function(result){
                html_options = "";
                $(child_ele).html(html_options);

                if(result.status === true){

                    //html_options = "<option value=''> </option>";
                    var html_options = "<option value=''>" + $(child_ele).find("option").first().text() + "</option>";
                  
                    for(var key in result['params']){

                       // console.log($(child_ele).attr('id'));

                       
                        if ($(child_ele).attr('id') == "school_class_id") {
                            if (ADMIN_STUDENT_CLASS.school_class_id == key) {
                                html_options += "<option selected value=" + key + ">" + result['params'][key] + "</option>";
    
                            } else {
                                html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
    
                            }

                        } else {
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }
                      
                    }

                    // var n = Object.keys(result['params']).length;   // if params object -> use this
                    // result['params'].length: if params array -> use this

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

    init_select_school: function(main_ele, child_ele, url){
        $(main_ele).on('change', function(){
            ADMIN_STUDENT_CLASS.load_child_element(child_ele, url);
        });
    },
}
