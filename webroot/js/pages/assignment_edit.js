var ASSIGNMENT_EDIT = {
    lst_material    : [],
    current_class   : [],
    current_subject : '',
    teacher_create_assignment_id : '',
    school_id: '',
    class_id: '',
    subject_id: '',
    lst_material_extension_allowed: ['docx', 'ppt', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'mp4'],
    lst_remove_material: [],
    init_page: function(teacher_create_assignment_id) {
        ASSIGNMENT_EDIT.current_subject   = '';
        ASSIGNMENT_EDIT.lst_material      = [];
        ASSIGNMENT_EDIT.lst_remove_material      = [];
        ASSIGNMENT_EDIT.current_class     = [];
        ASSIGNMENT_EDIT.teacher_create_assignment_id   = teacher_create_assignment_id;

        $(document).on('focus', 'input[type="text"]', function(e){
            e.preventDefault();
            $(this).attr("autocomplete", "off");  
        })
        $(document).on('focus', 'input[type="search"]', function(e){
            e.preventDefault();
            $(this).attr("autocomplete", "off");  
        })

        $(document).on('click', 'input[name="subject"]', function(){
            if($(this).is(':checked')){
                $("#btn-confirm-subject").prop("disabled", false);
            }
        })
        $(document).on('change', 'select[name=school_id]', function(){
            ASSIGNMENT_EDIT.school_id   = $('select[name=school_id] option').filter(':selected').val();
            
            if(ASSIGNMENT_EDIT.current_subject!=''){
                ASSIGNMENT_EDIT.current_subject   = '';
                $("#lesson-title-preview").html('');
                $("#subject-option-name").html('');
                $(".subject-option-name").toggleClass('hidden');
                $("input[name='school_subject']").val('');
                // $("#subject-option-name").html('').removeClass('text-dark-green').addClass('default-text');     
            }
            
            if(ASSIGNMENT_EDIT.current_class.length>0){
                $("#class-option-name").html('');
                $(".class-option-name").toggleClass('hidden');
                ASSIGNMENT_EDIT.current_class = [];
            }
        })

        $(document).on('click', 'input[name="class"]', function(){
            var current_class= [];
            $('input[name="class"]:checked').each(function() {
                current_class.push($(this).attr('value'));
            });
            if(current_class.length>0){
                $("#btn-confirm-class").prop("disabled", false);
            }else{
                $("#btn-confirm-class").prop("disabled", true);
            }
        })

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
                    ASSIGNMENT_EDIT.lst_material.push(files[i]);
                    ASSIGNMENT_EDIT.get_file_preview();
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
                    ASSIGNMENT_EDIT.lst_material.push(files[i]);
                    ASSIGNMENT_EDIT.get_file_preview();
                }
            }
        });
        /*File drag n drop handler*/

        $(document).on('change', '.required', function(e){
            let Disabled = true;
            $(".required").each(function() {
              let value = this.value;

              if ((value)&&(value.trim() !=''))
                  {
                    Disabled = false
                  }else{
                    Disabled = true
                    return false
                  }
            });
            if(Disabled){
                $('#btn-submit-create-assignment').prop("disabled", true);
            }else{
                $('#btn-submit-create-assignment').prop("disabled", false);
            }
        })

        var tdate = new Date(); 
        var min_time = new Date();
        // min_time.setHours(tdate.getHours() +1);

        var $assignment_time = $("#assignment_time").datetimepicker({
            'showClose' : true,
            'format' : "HH:mm",
            'useCurrent': false,
            'minDate': min_time
        })

        $(document).on("dp.change", "#assignment_time", function(e){
            let Disabled = true;
            $(".required").each(function() {
              let value = this.value;

              if ((value)&&(value.trim() !=''))
                  {
                    Disabled = false
                  }else{
                    Disabled = true
                    return false
                  }
            });
            if(Disabled){
                $('#btn-submit-create-assignment').prop("disabled", true);
            }else{
                $('#btn-submit-create-assignment').prop("disabled", false);
            }
            var hours = e.date._d.getHours();
            var minutes = e.date._d.getMinutes();
            var assignment_date = $("#assignment_date").data('DateTimePicker').date()._d;
            var tday = new Date();

            var is_todate = (tday.toDateString() === assignment_date.toDateString());
            if(is_todate){
                var current_hours = tday.getHours();
                var current_minutes = tday.getMinutes();
                var min_time = new Date();
                if(hours!=current_hours){
                    min_time.setHours(current_hours, 0, 0, 0);
                }else{
                    if(minutes < current_minutes){
                        $(this).data('DateTimePicker').date(min_time);
                    }
                }
                $(this).data('DateTimePicker').minDate(min_time);
            }
               
        })

        $(document).on("dp.change", "#assignment_date", function(e){
            let Disabled = true;
            $(".required").each(function() {
              let value = this.value;

              if ((value)&&(value.trim() !=''))
                  {
                    Disabled = false
                  }else{
                    Disabled = true
                    return false
                  }
            });

            var d = new Date();
            var is_todate = (d.toDateString() === e.date._d.toDateString());
            if(!is_todate){
                $('#assignment_time').data('DateTimePicker').destroy();
                var $assignment_time = $("#assignment_time").datetimepicker({
                    'showClose' : true,
                    'format' : "HH:mm",
                    'useCurrent': false
                })
            }
            $('#assignment_time').prop("disabled", false);

            if(Disabled){
                $('#btn-submit-create-assignment').prop("disabled", true);
            }else{
                $('#btn-submit-create-assignment').prop("disabled", false);
            }
               
        })
    },
    submit_teacher_edit_assignment: function(){
        var assignment_date = $("#assignment_date").val();
        var assignment_time  = $("#assignment_time").val();
        var form_data   = new FormData();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);
        form_data.append('teacher_create_assignment_id',  ASSIGNMENT_EDIT.teacher_create_assignment_id);
        form_data.append('name',  $("#assignment_title").val());
        form_data.append('description',  $("#assignment_description").val());
        form_data.append('deadline', assignment_date+' '+assignment_time);
        form_data.append('school_id',  ASSIGNMENT_EDIT.school_id);
        form_data.append('class_id',  ASSIGNMENT_EDIT.class_id);
        form_data.append('subject_id',  ASSIGNMENT_EDIT.subject_id);

        if(ASSIGNMENT_EDIT.lst_remove_material.length>0){
            form_data.append('remove_file_id',  JSON.stringify(ASSIGNMENT_EDIT.lst_remove_material));
        }

        if(ASSIGNMENT_EDIT.lst_material.length>0){
            form_data.append('number_file',  ASSIGNMENT_EDIT.lst_material.length);
            for(var i=0; i<ASSIGNMENT_EDIT.lst_material.length; i++){
                form_data.append('file'+i,  ASSIGNMENT_EDIT.lst_material[i]);
            }
        }
        SERVICE.get_submission_count_by_assignment_id(ASSIGNMENT_EDIT.teacher_create_assignment_id, function(resp){
            if(resp.status === 200){
                if(resp.params!=undefined && resp.params != null && resp.params!=''){
                    var submission_count = resp.params.submission_count;
                    if(submission_count>0){
                        bootbox.confirm( sprintf(lang.confirm_edit_assignment, submission_count) , function(result){
                            if(result){
                                SERVICE.teacher_update_assignment(form_data, function(resp){
                                    bootbox.alert(resp.message);
                                    if(resp.status == 200){
                                        var school_code = $("#school-code-"+ASSIGNMENT_EDIT.school_id).val();
                                        window.location=COMMON.base_url+'teacher_portals/assignments/'+school_code;
                                    }        
                                })
                            }
                        })
                    }else if(submission_count==0){
                        SERVICE.teacher_update_assignment(form_data, function(resp){
                            bootbox.alert(resp.message);
                            if(resp.status == 200){
                                var school_code = $("#school-code-"+ASSIGNMENT_EDIT.school_id).val();
                                window.location=COMMON.base_url+'teacher_portals/assignments/'+school_code;
                            }        
                        })
                        
                    }
                }

                
            }else{
                bootbox.alert(resp.message);
            }
        })
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    remove_material: function(index){
        ASSIGNMENT_EDIT.lst_material.splice(index, 1);
        ASSIGNMENT_EDIT.get_file_preview();
    },
    toggle_current_material: function(material_id){
        var index = ASSIGNMENT_EDIT.lst_remove_material.indexOf(material_id);
        if(index!=-1){
            ASSIGNMENT_EDIT.lst_remove_material.splice(index, 1);
        }else{
            ASSIGNMENT_EDIT.lst_remove_material.push(material_id);
        }
        $("#material-"+material_id+" .remove-file").toggleClass('hidden');
        $("#material-"+material_id+"").toggleClass('removed');
    },
    get_file_preview: function(){
        var files = ASSIGNMENT_EDIT.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="ASSIGNMENT_EDIT.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $("#lst-imported-material").html(preview_img);
    }
}