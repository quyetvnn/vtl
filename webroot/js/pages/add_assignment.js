var ADD_ASSIGNMENT = {
    lst_material    : [],
    current_attend_teacher : [],
    teacher_create_lesson_id : '',
    lst_material_extension_allowed: ['docx', 'ppt', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'mp4'],
    init_page: function() {
        ADD_ASSIGNMENT.lst_material      = [];
        ADD_ASSIGNMENT.teacher_create_lesson_id = $("#lesson_define").val();
        if(ADD_ASSIGNMENT.teacher_create_lesson_id==''){
            COMMON.redirect_to_landing();
        }
        /*File drag n drop handler*/
        // $("html").on("dragover", function(e) {
        //     e.preventDefault();
        //     e.stopPropagation();
        // });

        // $("html").on("drop", function(e) { 
        //     e.preventDefault(); 
        //     e.stopPropagation(); 

        // });

        // Drag enter
        $('.import-file-area').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(".import-file-area").addClass('hover');
        });

        // Drag over
        $('.import-file-area').on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Drop
        $('.import-file-area').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(".import-file-area").removeClass('hover');
            var files = e.originalEvent.dataTransfer.files;
            for(var i=0; i<files.length; i++){
                if(COMMON.validation_file(files[i])){
                    ADD_ASSIGNMENT.lst_material.push(files[i]);
                    ADD_ASSIGNMENT.get_file_preview();
                }
            }
        });

        // Open file selector on div click
        $(".import-file-area").click(function(){
            $("#upload-material").click();
        });

        // file selected
        $("#upload-material").change(function(){
            var files = $('#upload-material')[0].files;
            for(var i=0; i<files.length; i++){
                if(COMMON.validation_file(files[i])){
                    ADD_ASSIGNMENT.lst_material.push(files[i]);
                    ADD_ASSIGNMENT.get_file_preview();
                }
            }
        });
        /*File drag n drop handler*/

    },
    submit_student_add_assignment: function(){
        var form_data   = new FormData();
        var teacher_create_lesson_id = $("#lesson_define").val();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);
        form_data.append('teacher_create_lesson_id',  ADD_ASSIGNMENT.teacher_create_lesson_id);

        if(ADD_ASSIGNMENT.lst_material.length>0){
            form_data.append('number_file',  ADD_ASSIGNMENT.lst_material.length);
            for(var i=0; i<ADD_ASSIGNMENT.lst_material.length; i++){
                form_data.append('file'+i,  ADD_ASSIGNMENT.lst_material[i]);
            }
            $.ajax({
                url: COMMON.base_api_url+"api/member/teacher_create_lessons/student_submit_assignment.json",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: function(){},
                success: function(resp){
                    bootbox.alert(resp.message);
                    if(resp.status == 200){
                        // window.history.back();
                        window.location=COMMON.base_url+'student_portals/browse';
                    }else{
                        
                    }
                },
                error: function(error){},
                complete: function(){}
            })
        }
    },
    submit_teacher_add_assignment: function(){
        var lesson_date = $("#lesson_date").val();
        var start_time  = $("#end_time").val();
        var form_data   = new FormData();
        var teacher_create_lesson_id = $("#lesson_define").val();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);
        form_data.append('teacher_create_lesson_id',  ADD_ASSIGNMENT.teacher_create_lesson_id);

        if(ADD_ASSIGNMENT.lst_material.length>0){
            form_data.append('number_file',  ADD_ASSIGNMENT.lst_material.length);
            for(var i=0; i<ADD_ASSIGNMENT.lst_material.length; i++){
                form_data.append('file'+i,  ADD_ASSIGNMENT.lst_material[i]);
            }
            $.ajax({
                url: COMMON.base_api_url+"api/member/teacher_create_lessons/teacher_create_assignment.json",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: function(){},
                success: function(resp){
                    bootbox.alert(resp.message);
                    if(resp.status == 200){
                        // window.history.back();
                        window.location=COMMON.base_url+'teacher_portals/browse';
                    }else{
                        
                    }
                },
                error: function(error){},
                complete: function(){}
            })
        }
        
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    remove_material: function(index){
        ADD_ASSIGNMENT.lst_material.splice(index, 1);
        ADD_ASSIGNMENT.get_file_preview();
    },
    get_file_preview: function(){
        var files = ADD_ASSIGNMENT.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="ADD_ASSIGNMENT.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $("#lst-imported-material").html(preview_img);
    }
}