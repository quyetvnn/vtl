var ASSIGNMENT_CREATE = {
    lst_material    : [],
    current_class   : [],
    current_subject : '',
    teacher_create_lesson_id : '',
    school_id: '',
    lst_material_extension_allowed: ['docx', 'ppt', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'mp4'],
    init_page: function() {
        ASSIGNMENT_CREATE.current_subject   = '';
        ASSIGNMENT_CREATE.lst_material      = [];
        ASSIGNMENT_CREATE.current_class     = [];
        ASSIGNMENT_CREATE.school_id         = $('select[name=school_id] option').filter(':selected').val();
        

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
            ASSIGNMENT_CREATE.school_id   = $('select[name=school_id] option').filter(':selected').val();
            
            if(ASSIGNMENT_CREATE.current_subject!=''){
                ASSIGNMENT_CREATE.current_subject   = '';
                $("#lesson-title-preview").html('');
                $("#subject-option-name").html('');
                $(".subject-option-name").toggleClass('hidden');
                $("input[name='school_subject']").val('');
                // $("#subject-option-name").html('').removeClass('text-dark-green').addClass('default-text');     
            }
            
            if(ASSIGNMENT_CREATE.current_class.length>0){
                $("#class-option-name").html('');
                $(".class-option-name").toggleClass('hidden');
                ASSIGNMENT_CREATE.current_class = [];
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
                    ASSIGNMENT_CREATE.lst_material.push(files[i]);
                    ASSIGNMENT_CREATE.get_file_preview();
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
                    ASSIGNMENT_CREATE.lst_material.push(files[i]);
                    ASSIGNMENT_CREATE.get_file_preview();
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
            var tday = new Date();
            var current_hours = tday.getHours();
            var current_minutes = tday.getMinutes();
            var min_time = new Date();
            if(hours!=current_hours){
                var min_time = new Date();
                min_time.setHours(current_hours, 0, 0, 0);
            }else{
                if(minutes < current_minutes){
                    $(this).data('DateTimePicker').date(min_time);
                }
            }
            $(this).data('DateTimePicker').minDate(min_time);
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
    // submit_student_ASSIGNMENT_CREATE: function(){
    //     var form_data   = new FormData();
    //     var teacher_create_lesson_id = $("#lesson_define").val();
    //     form_data.append('token',  COMMON.token);
    //     form_data.append('language',  COMMON.cfg_lang);
    //     // form_data.append('teacher_create_lesson_id',  ASSIGNMENT_CREATE.teacher_create_lesson_id);

    //     if(ASSIGNMENT_CREATE.lst_material.length>0){
    //         form_data.append('number_file',  ASSIGNMENT_CREATE.lst_material.length);
    //         for(var i=0; i<ASSIGNMENT_CREATE.lst_material.length; i++){
    //             form_data.append('file'+i,  ASSIGNMENT_CREATE.lst_material[i]);
    //         }
    //         $.ajax({
    //             url: COMMON.base_api_url+"api/member/teacher_create_lessons/student_submit_assignment.json",
    //             type: "POST",
    //             data: form_data,
    //             dataType: "JSON",
    //             contentType: false,
    //             processData: false,
    //             beforeSend: function(){},
    //             success: function(resp){
    //                 bootbox.alert(resp.message);
    //                 if(resp.status == 200){
    //                     // window.history.back();
    //                     window.location=COMMON.base_url+'student_portals/browse';
    //                 }else{
                        
    //                 }
    //             },
    //             error: function(error){},
    //             complete: function(){}
    //         })
    //     }
    // },
    submit_teacher_create_assignment: function(){
        var assignment_date = $("#assignment_date").val();
        var assignment_time  = $("#assignment_time").val();
        var form_data   = new FormData();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);

        form_data.append('school_id',  $('select[name=school_id] option').filter(':selected').val());
        form_data.append('name',  $("#assignment_title").val());
        form_data.append('description',  $("#assignment_description").val());
        form_data.append('class_id',  JSON.stringify(ASSIGNMENT_CREATE.current_class));
        form_data.append('subject_id',  ASSIGNMENT_CREATE.current_subject);
        form_data.append('deadline', assignment_date+' '+assignment_time);

        if(ASSIGNMENT_CREATE.lst_material.length>0){
            form_data.append('number_file',  ASSIGNMENT_CREATE.lst_material.length);
            for(var i=0; i<ASSIGNMENT_CREATE.lst_material.length; i++){
                form_data.append('file'+i,  ASSIGNMENT_CREATE.lst_material[i]);
            }
        }

        SERVICE.teacher_create_assignment(form_data, function(resp){
            bootbox.alert(resp.message);
            if(resp.status == 200){
                var school_code = $("#school-code-"+ASSIGNMENT_CREATE.school_id).val();
                window.location=COMMON.base_url+'teacher_portals/assignments/'+school_code;
            }
        })
    },
    call_modal_subject: function(is_open){
        if(is_open){
            if(ASSIGNMENT_CREATE.school_id==undefined || ASSIGNMENT_CREATE.school_id==null || ASSIGNMENT_CREATE.school_id==''){
                bootbox.alert(lang.missing_school);
                return false;
            }
            if(ASSIGNMENT_CREATE.current_subject==''){
                $("#btn-confirm-subject").prop("disabled", true);
            }
            ASSIGNMENT_CREATE.get_list_subject_by_school_id();
        }else{
            COMMON.toggle_modal('modal-subject');
        }
    },
    confirm_modal_subject: function(){
        ASSIGNMENT_CREATE.call_modal_subject(false);
        var subject_data = $('input[name="subject"]:checked').val();
        if(subject_data!=undefined && subject_data!=null && subject_data!=''){
            ASSIGNMENT_CREATE.current_subject = subject_data;
            $("input[name='school_subject']").val(ASSIGNMENT_CREATE.current_subject);
            var display_name = $("input[name='display_name']:checked").val();
            var subject_name = $('#rd-subject-'+ASSIGNMENT_CREATE.current_subject).text();
            $("#subject-option-name").html(subject_name);
            $(".subject-option-name").toggleClass('hidden');
            // $("#subject-option-name").html(subject_name).removeClass('default-text').addClass('text-dark-green');
            if(display_name=='subject'){
                $("#lesson-title-preview").html($('#rd-subject-'+subject_data).text());
            }
        }
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    remove_material: function(index){
        ASSIGNMENT_CREATE.lst_material.splice(index, 1);
        ASSIGNMENT_CREATE.get_file_preview();
    },
    get_file_preview: function(){
        var files = ASSIGNMENT_CREATE.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="ASSIGNMENT_CREATE.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $("#lst-imported-material").html(preview_img);
    },
    call_modal_class: function(is_open){
        if(is_open){
            if(ASSIGNMENT_CREATE.school_id==undefined || ASSIGNMENT_CREATE.school_id==null || ASSIGNMENT_CREATE.school_id==''){
                bootbox.alert(lang.missing_school);
                return false;
            }
            if(ASSIGNMENT_CREATE.current_class==''){
                $("#btn-confirm-class").prop("disabled", true);
            }
            ASSIGNMENT_CREATE.get_list_class_by_school_id();
        }else{
            COMMON.toggle_modal('modal-classes');
        }
    },
    confirm_modal_class: function(){
        ASSIGNMENT_CREATE.call_modal_class(false);
        ASSIGNMENT_CREATE.current_class = [];
        var classes_name = [];
        $('input[name="class"]:checked').each(function() {
            var class_id = $(this).attr('value');
            var class_name = $('#rd-class-'+class_id).text();
            ASSIGNMENT_CREATE.current_class.push(class_id);
            classes_name.push(class_name);
        });
        classes_name = classes_name.join(lang.comma);
        $("#class-option-name").html(classes_name);
        $(".class-option-name").toggleClass('hidden');
        // $("#class-option-name").html(classes_name).removeClass('default-text').addClass('text-dark-green');
        $("input[name='school_class']").val(ASSIGNMENT_CREATE.current_class);
    },
    get_list_class_by_school_id: function(){
        var data_form = {
            school_id: ASSIGNMENT_CREATE.school_id
        }
        SERVICE.get_list_class_by_school_id(data_form, function(resp){
            if(resp.status === 200){
                var lst_current_classes = resp.params;
                var data_to_popup = '';
                for (id_class in lst_current_classes) {
                    var checked = ASSIGNMENT_CREATE.current_class.indexOf(id_class)!=-1?'checked':'';
                    data_to_popup += "<label class='col-md-6 p-0 normal-weight'> <input type='checkbox' name='class' class='required' value='"+id_class+"' "+checked+"/> <span id='rd-class-"+id_class+"'>"+lst_current_classes[id_class]+"</span></label>"; 
                }
                $("#lst-current-classes").html(data_to_popup);
                COMMON.toggle_modal('modal-classes');
            }else{
                bootbox.alert(resp.message);
            }
        })
    },
    get_list_subject_by_school_id: function(){
        var data_form = {
            school_id: ASSIGNMENT_CREATE.school_id
        }
        SERVICE.get_list_subject_by_school_id(data_form, function(resp){
            if(resp.status === 200){
                var lst_current_subject = resp.params;
                var data_to_popup = '';
                for (id_subject in lst_current_subject) {
                    var checked = (ASSIGNMENT_CREATE.current_subject==id_subject)?'checked':'';
                    data_to_popup += "<label class='col-md-6 p-0 normal-weight'> <input type='radio' name='subject' class='required' value='"+id_subject+"' "+checked+"/> <span id='rd-subject-"+id_subject+"'>"+lst_current_subject[id_subject]+"</span></label>"; 
                }
                $("#lst-current-subject").html(data_to_popup);
                COMMON.toggle_modal('modal-subject');
            }else{
                bootbox.alert(resp.message);
            }
        })
    }
}