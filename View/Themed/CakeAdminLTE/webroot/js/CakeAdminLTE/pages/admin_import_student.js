ADMIN_IMPORT_STUDENT = {

    url_get_school_class: "",
    noneSelectedText: "",
    
    init_page: function() {

        ADMIN_IMPORT_STUDENT.init_select_school(  $('#school_id'), $('#school_class_id'), ADMIN_IMPORT_STUDENT.url_get_school_class );
        $('.student-class-selectpicker').selectpicker({
            'noneSelectedText': ADMIN_IMPORT_STUDENT.noneSelectedText
        });

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
                console.log (result);
                if(result.status === true){

                    if ($('#school_id').val()) {
                        var html_options = "<option value=''>" + $(child_ele).find("option").first().text() + "</option>";
                  
                        for(var key in result['params']){
                           
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }
                    }
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
        ADMIN_IMPORT_STUDENT.load_child_element(child_ele, url);
     
        $(main_ele).on('change', function(){

            console.log($('#school_id').val());
            ADMIN_IMPORT_STUDENT.load_child_element(child_ele, url);
        });
    },
}
