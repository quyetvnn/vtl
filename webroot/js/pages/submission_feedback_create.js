var SUBMISSION_FEEDBACK_CREATE = {
	lst_material    : [],
    student_assignment_submission_id: '',
    lst_material_extension_allowed: ['docx', 'ppt', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'mp4'],
	init_page: function(student_assignment_submission_id) {
        SUBMISSION_FEEDBACK_CREATE.lst_material      = [];
        if(student_assignment_submission_id!=undefined && student_assignment_submission_id!=null && student_assignment_submission_id!=''){
            SUBMISSION_FEEDBACK_CREATE.student_assignment_submission_id = student_assignment_submission_id;
        }else{
            COMMON.redirect_to_landing();
        }
        

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
                    SUBMISSION_FEEDBACK_CREATE.lst_material.push(files[i]);
                    SUBMISSION_FEEDBACK_CREATE.get_file_preview();
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
                    SUBMISSION_FEEDBACK_CREATE.lst_material.push(files[i]);
                    SUBMISSION_FEEDBACK_CREATE.get_file_preview();
                }
            }
        });
        /*File drag n drop handler*/
    },
    submit_teacher_create_submission_feeback: function(){
        var score = $("#score").val();
        var remark = $("#remark").val();
        var feedback = $("#feedback").val();
    	var form_data   = new FormData();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);

        form_data.append('student_assignment_submission_id',  SUBMISSION_FEEDBACK_CREATE.student_assignment_submission_id);
        form_data.append('score',  score);
        form_data.append('feedback',  feedback);
        form_data.append('remark',  remark);
        if(SUBMISSION_FEEDBACK_CREATE.lst_material.length>0){
            form_data.append('number_file',  SUBMISSION_FEEDBACK_CREATE.lst_material.length);
            for(var i=0; i<SUBMISSION_FEEDBACK_CREATE.lst_material.length; i++){
                form_data.append('file'+i,  SUBMISSION_FEEDBACK_CREATE.lst_material[i]);
            }
        }
        if(SUBMISSION_FEEDBACK_CREATE.lst_material.length>0 ||
            (score!=undefined && score!=null && score!='')||
            (remark!=undefined && remark!=null && remark!='')||
            (feedback!=undefined && feedback!=null && feedback!='')){
            $.ajax({
                url: COMMON.base_api_url+"api/member/teacher_create_lessons/teacher_feedback_assignment.json",
                type: "POST",
                data: form_data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                beforeSend: function(){},
                success: function(resp){
                    bootbox.alert(resp.message);
                    if(resp.status == 200){
                        window.location=document.referrer;
                    }
                },
                error: function(error){},
                complete: function(){}
            })
        }else{
            bootbox.alert(lang.form_invalid);
        }
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>5242880) return false;
        return true;
    },
    remove_material: function(index){
        SUBMISSION_FEEDBACK_CREATE.lst_material.splice(index, 1);
        SUBMISSION_FEEDBACK_CREATE.get_file_preview();
    },
    get_file_preview: function(){
        var files = SUBMISSION_FEEDBACK_CREATE.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="SUBMISSION_FEEDBACK_CREATE.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $("#lst-imported-material").html(preview_img);
    },
}