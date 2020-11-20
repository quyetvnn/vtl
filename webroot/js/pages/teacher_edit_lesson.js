var TEACHER_EDIT_LESSON = {
    current_subject : '',
    current_class   : [],
    current_teacher : [],
    lst_material    : [],
    current_attend_teacher : [],
    lst_delete_material : [],
    lst_material_extension_allowed: ['docx', 'ppt', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png'],
    school_id       : '',
    validator       : '',
    option_validation : {
        ignore:"ui-tabs-hide",
        focusInvalid: false,
        errorPlacement: function (error, element) {
            //do nothing
            return false;
        },
        highlight: function(element, errorClass) {
            //do nothing
            return false;
        },
        invalidHandler: function(e, validator){
            $('#btn-submit-lesson').prop("disabled", true);
        },
        submitHandler: function(){
            //do nothing
            return false;
        }
    },
    init_page: function() {
        TEACHER_EDIT_LESSON.current_subject   = $("#subject_id").val();
        TEACHER_EDIT_LESSON.current_class     = $("#list_class").val().split(',');
        TEACHER_EDIT_LESSON.current_teacher   = $("#list_teacher").val().split(',');
        TEACHER_EDIT_LESSON.current_attend_teacher   = $("#list_attend_teacher").val().split(',');
        TEACHER_EDIT_LESSON.lst_material      = [];
        TEACHER_EDIT_LESSON.lst_delete_material = [];
        TEACHER_EDIT_LESSON.school_id   = $('select[name=school_id] option').filter(':selected').val();
        TEACHER_EDIT_LESSON.validator = $('form').validate(TEACHER_EDIT_LESSON.option_validation);

        $(document).on('keyup change paste input', 'input, select, textarea', function(){
            var is_valid = TEACHER_EDIT_LESSON.validator.form();
            if(is_valid){
                $('#btn-submit-lesson').prop("disabled", false);
            }
        })
        
        $(document).on('focus', 'input[type="text"]', function(e){
            e.preventDefault();
            $(this).attr("autocomplete", "off");  
        })
        $(document).on('focus', 'input[type="search"]', function(e){
            e.preventDefault();
            $(this).attr("autocomplete", "off");  
        })

        $(document).on('click', 'input[name="allow_frequency"]', function(){
            if($(this).is(':checked')){
                $("#frequency").prop("disabled", false);
            }
        })

        $(document).on('change', 'select[name=school_id]', function(){
            TEACHER_EDIT_LESSON.school_id   = $('select[name=school_id] option').filter(':selected').val();
            $(".avatar-lesson-card").addClass('hidden');
            $("#school-image-"+TEACHER_EDIT_LESSON.school_id).removeClass('hidden');
        })

        $(document).on('click', 'input[name="cycle"]', function(){
            var cycle = $('input[name="cycle"]:checked').attr('value');
            if(cycle!=10 ){
                $("#allow_frequency1").prop("disabled", false);
            }else{
                $("#allow_frequency1").prop("disabled", true);
            }
        })

        $(document).on('click', 'input[name="subject"]', function(){
            if($(this).is(':checked')){
                $("#btn-confirm-subject").prop("disabled", false);
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

        $(document).on('click', 'input[name="attend-teacher"]', function(){
            var current_attend_teacher= [];
            $('input[name="attend-teacher"]:checked').each(function() {
                current_attend_teacher.push($(this).attr('value'));
            });
           
        })

        $(document).on('click', 'input[name="teacher"]', function(){
            var current_teacher= [];
            $('input[name="teacher"]:checked').each(function() {
                current_teacher.push($(this).attr('value'));
            });
            
        })
        $(document).on("change", "#lesson_title", function(){
            var display_name = $("input[name='display_name']:checked").val();
            if(display_name=='lesson_title'){
                $("#lesson-title-preview").html($(this).val());
            }
        })
        $(document).on('click', 'input[name="display_name"]', function(){
            var display_name = $("input[name='display_name']:checked").val();
            if(display_name == 'lesson_title'){
                $("#lesson-title-preview").html($("#lesson_title").val());
            }else{
                var subject_name = $('#rd-subject-'+TEACHER_EDIT_LESSON.current_subject).text();
                $("#lesson-title-preview").html(subject_name);
            }
        })

        $(document).on("change", "#duration_hours", function(e){
            TEACHER_EDIT_LESSON.get_end_time();
            $('#duration_hours option').each(function(index, value){
                $(value).text($(value).attr('value'));
             })
            var text = $('#duration_hours option').filter(':selected').val() + lang.hr;
            $('#duration_hours option').filter(':selected').html(text);
            var is_valid = TEACHER_EDIT_LESSON.validator.form();
            if(is_valid){
                $('#btn-submit-lesson').prop("disabled", false);
            }
        })

        $(document).on("change", "#duration_minutes", function(e){
            TEACHER_EDIT_LESSON.get_end_time();
             $('#duration_minutes option').each(function(index, value){
                $(value).text($(value).attr('value'));
             })
            var text = $('#duration_minutes option').filter(':selected').val() + lang.min;
            $('#duration_minutes option').filter(':selected').html(text);
            var is_valid = TEACHER_EDIT_LESSON.validator.form();
            if(is_valid){
                $('#btn-submit-lesson').prop("disabled", false);
            }
        })


        $(document).on("dp.change", "#start_time", function(e){
            var hours = e.date._d.getHours();
            var minutes = e.date._d.getMinutes();
            var txt_show = ("0" + hours).slice(-2)  + ":" +("0" + minutes).slice(-2);
            $("#lesson-start-time").html(txt_show);
            TEACHER_EDIT_LESSON.get_end_time();
            var is_valid = TEACHER_EDIT_LESSON.validator.form();
            if(is_valid){
                $('#btn-submit-lesson').prop("disabled", false);
            }
            var lesson_date = $("#lesson_date").data('DateTimePicker').date()._d;
            var tday = new Date();

            var is_todate = (tday.toDateString() === lesson_date.toDateString());
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
        $(document).on("dp.change", "#end_time", function(e){
            var txt_show = ("0" + e.date._d.getHours()).slice(-2)  + ":" +("0" + e.date._d.getMinutes()).slice(-2);
            $("#lesson-end-time").html(txt_show);
            $("#lesson-end-time").html(formatedValue);
        })

        $(document).on("dp.change", "#lesson_date", function(e){
            if(e.date==undefined || e.date==null || e.date == '') return false;
            var d = new Date();
            var is_todate = (d.toDateString() === e.date._d.toDateString());
            if(!is_todate){
                $('#start_time').data('DateTimePicker').destroy();
                var $start_time = $("#start_time").datetimepicker({
                    'showClose' : true,
                    'format' : "HH:mm",
                    'useCurrent': false
                })
            }else{
                $('#start_time').data('DateTimePicker').destroy();
                var tdate = new Date(); 
                var min_time = new Date();

                var $start_time = $("#start_time").datetimepicker({
                    'showClose' : true,
                    'format' : "HH:mm",
                    'useCurrent': false,
                    'minDate': min_time
                })
            }
            $('#start_time').prop("disabled", false);
            TEACHER_EDIT_LESSON.get_end_time();
            var is_valid = TEACHER_EDIT_LESSON.validator.form();
            if(is_valid){
                $('#btn-submit-lesson').prop("disabled", false);
            }
        })

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
                if(TEACHER_EDIT_LESSON.validation_file(files[i])){
                    TEACHER_EDIT_LESSON.lst_material.push(files[i]);
                    TEACHER_EDIT_LESSON.get_file_preview();
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
                if(TEACHER_EDIT_LESSON.validation_file(files[i])){
                    TEACHER_EDIT_LESSON.lst_material.push(files[i]);
                    TEACHER_EDIT_LESSON.get_file_preview();
                }
            }
        });
        /*File drag n drop handler*/

    },
    get_end_time: function(){
        var duration_hours = $('select[name=duration_hours] option').filter(':selected').val();
        var duration_minutes = $('select[name=duration_minutes] option').filter(':selected').val();
        var lesson_start = $("#lesson_date").val()+' '+$("#start_time").val()+':00';
        var lesson_end = COMMON.get_end_time(lesson_start, duration_hours, duration_minutes);
        
        var txt_show = ("0" + lesson_end.getHours()).slice(-2)  + ":" +("0" + lesson_end.getMinutes()).slice(-2);
        $("#lesson-end-time").html(txt_show);
    },
    submit_create_lesson: function(){
        var lesson_date = $("#lesson_date").val();
        var start_time  = $("#start_time").val();
        var end_time    = $("#end_time").val();
        var cycle = $("input[name='cycle']:checked").val();
        var allow_frequency = parseInt($("input[name='allow_frequency']:checked").val());
        var display_name = $("input[name='display_name']:checked").val();
        var duration_hours = $('select[name=duration_hours] option').filter(':selected').val();
        var duration_minutes = $('select[name=duration_minutes] option').filter(':selected').val();
        
        var frequency = 1;
        if(allow_frequency==1 && $("#frequency").val()!=''){
            frequency = $("#frequency").val();
        }
        
        var form_data   = new FormData();
        form_data.append('teacher_create_lesson_id',  $("#teacher_create_lesson_id").val());
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);
        form_data.append('school_id',  $('select[name=school_id] option').filter(':selected').val());
        form_data.append('duration_hours',  duration_hours);
        form_data.append('duration_minutes',  duration_minutes);
        form_data.append('subject_id',  $("#subject_id").val());
        form_data.append('lesson_title',  $("#lesson_title").val());
        form_data.append('display_card_subject',  $("#display_card_subject").val());
        form_data.append('lesson_description',  $("#lesson_description").val());
        if(TEACHER_EDIT_LESSON.lst_material.length>0){
            form_data.append('number_file',  TEACHER_EDIT_LESSON.lst_material.length);
            for(var i=0; i<TEACHER_EDIT_LESSON.lst_material.length; i++){
                form_data.append('file'+i,  TEACHER_EDIT_LESSON.lst_material[i]);
            }
        }
        form_data.append('list_class',  JSON.stringify(TEACHER_EDIT_LESSON.current_class));
        form_data.append('list_teacher',  JSON.stringify(TEACHER_EDIT_LESSON.current_teacher));
        form_data.append('list_attend_teacher',  JSON.stringify(TEACHER_EDIT_LESSON.current_attend_teacher));
        form_data.append('allow_playback', $("input[name='allow_playback']:checked").val());
        form_data.append('start_time',  lesson_date+' '+start_time);
        form_data.append('is_allow_overlap',  0);
        // form_data.append('end_time',  lesson_date+' '+end_time);
        form_data.append('cycle',  cycle);
        form_data.append('frequency', frequency);
        form_data.append('remove_file_id', JSON.stringify(TEACHER_EDIT_LESSON.lst_delete_material));
        
        SERVICE.update_lesson(form_data, function(resp){
            
            if(resp.status == 200){
                bootbox.alert(resp.message, function(){
                    var school_code = $("#school-code-"+TEACHER_EDIT_LESSON.school_id).val();
                    window.location = COMMON.base_url+'teacher_portals/browse/'+school_code;
                });
            }else if(resp.status==904){
                bootbox.confirm({
                    message: resp.message + '. '+lang.confirm_allow_create_overlapped_lesson,
                    buttons: {
                        cancel: {
                            label: lang.no,
                            className: 'btn btn-w-radius btn-green-o'
                        },
                        confirm: {
                            label: lang.yes,
                            className: 'btn btn-w-radius btn-green'
                        }
                    },
                    callback: function (result) {
                        if(result){
                            form_data.set('is_allow_overlap', 1);
                            SERVICE.update_lesson(form_data, function(resp_then){
                                if(resp_then.status == 200){
                                    bootbox.alert(resp_then.message, function(){
                                        var school_code = $("#school-code-"+TEACHER_EDIT_LESSON.school_id).val();
                                        window.location = COMMON.base_url+'teacher_portals/browse/'+school_code;
                                    });
                                }else{
                                     bootbox.alert(resp_then.message);
                                }
                            })
                        }
                    }
                });
            }else{
                bootbox.alert(resp.message);
            }
        })
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>5242880) return false;
        return true;
    },
    remove_material: function(index){
        TEACHER_EDIT_LESSON.lst_material.splice(index, 1);
        TEACHER_EDIT_LESSON.get_file_preview();
    },
    remove_current_material: function(id){
        TEACHER_EDIT_LESSON.lst_delete_material.push(id);
        $("#marterial-"+id).addClass('hidden');
    },
    get_file_preview: function(){
        var files = TEACHER_EDIT_LESSON.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="TEACHER_EDIT_LESSON.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $("#lst-imported-material").html(preview_img);
    }, 
    confirm_modal_subject: function(){
        TEACHER_EDIT_LESSON.call_modal_subject(false);
        var subject_data = $('input[name="subject"]:checked').val();
        if(subject_data!=undefined && subject_data!=null && subject_data!=''){
            TEACHER_EDIT_LESSON.current_subject = subject_data;
            $("input[name='school_subject']").val(TEACHER_EDIT_LESSON.current_subject);
            var display_name = $("input[name='display_name']:checked").val();
            var subject_name = $('#rd-subject-'+TEACHER_EDIT_LESSON.current_subject).text();
            $("#subject-option-name").html(subject_name).removeClass('default-text').addClass('text-dark-green');
            if(display_name=='subject'){
                $("#lesson-title-preview").html($('#rd-subject-'+subject_data).text());
            }
        }
        var is_valid = TEACHER_EDIT_LESSON.validator.form();
        if(is_valid){
            $('#btn-submit-lesson').prop("disabled", false);
        }
    },
    confirm_modal_class: function(){
        TEACHER_EDIT_LESSON.call_modal_class(false);
        TEACHER_EDIT_LESSON.current_class = [];
        var classes_name = [];
        $('input[name="class"]:checked').each(function() {
            var class_id = $(this).attr('value');
            var class_name = $('#rd-class-'+class_id).text();
            TEACHER_EDIT_LESSON.current_class.push(class_id);
            classes_name.push(class_name);
        });
        classes_name = classes_name.join(lang.comma);
        
        $("#class-option-name").html(classes_name).removeClass('default-text').addClass('text-dark-green');
        $("input[name='school_class']").val(TEACHER_EDIT_LESSON.current_class);
    },
    confirm_modal_teacher: function(){
        TEACHER_EDIT_LESSON.call_modal_teacher(false);
        TEACHER_EDIT_LESSON.current_teacher = [];
        var teachers_name = [];
        $('input[name="teacher"]:checked').each(function() {
            var teacher_id = $(this).attr('value');
            var teacher_name = $('#rd-teacher-'+teacher_id).text();
            TEACHER_EDIT_LESSON.current_teacher.push(teacher_id);
            teachers_name.push(teacher_name);
        });
        teachers_name = teachers_name.join(lang.comma);
        
        $("#lesson-co-teaching").html(teachers_name);
        if(TEACHER_EDIT_LESSON.current_teacher.length>0){
            $("#teacher-option-name").html(teachers_name);
            if(!($("#teacher-option-name-default-text").hasClass('hidden'))){
                $("#teacher-option-name").removeClass('hidden');
                $("#teacher-option-name-default-text").addClass('hidden');
            }
        }else{
            $("#teacher-option-name").html('');
            if(!($("#teacher-option-name").hasClass('hidden'))){
                $("#teacher-option-name").addClass('hidden');
                $("#teacher-option-name-default-text").removeClass('hidden');
            }
        }
        $("input[name='school_teacher']").val(TEACHER_EDIT_LESSON.current_teacher);
    },
    confirm_modal_attend_teacher: function(){
        TEACHER_EDIT_LESSON.call_modal_attend_teacher(false);
        TEACHER_EDIT_LESSON.current_attend_teacher = [];
        var teachers_name = [];
        $('input[name="attend-teacher"]:checked').each(function() {
            var teacher_id = $(this).attr('value');
            var teacher_name = $('#rd-attend-teacher-'+teacher_id).text();
            TEACHER_EDIT_LESSON.current_attend_teacher.push(teacher_id);
            teachers_name.push(teacher_name);
        });
        teachers_name = teachers_name.join(lang.comma);
        
        if(TEACHER_EDIT_LESSON.current_attend_teacher.length>0){
            $("#attend-teacher-option-name").html(teachers_name);
            if(!($("#attend-teacher-option-name-default-text").hasClass('hidden'))){
                $("#attend-teacher-option-name").removeClass('hidden');
                $("#attend-teacher-option-name-default-text").addClass('hidden');
            }
            // $("#attend-teacher-option-name-default-text").toggleClass('hidden');
        }else{
            $("#attend-teacher-option-name").html('');
            if(!($("#attend-teacher-option-name").hasClass('hidden'))){
                $("#attend-teacher-option-name").addClass('hidden');
                $("#attend-teacher-option-name-default-text").removeClass('hidden');
            }
        }
    },
    call_modal_subject: function(is_open){
        if(is_open){
            if(TEACHER_EDIT_LESSON.school_id==undefined || TEACHER_EDIT_LESSON.school_id==null || TEACHER_EDIT_LESSON.school_id==''){
                bootbox.alert(lang.missing_school);
                return false;
            }
            if(TEACHER_EDIT_LESSON.current_subject==''){
                $("#btn-confirm-subject").prop("disabled", true);
            }
            TEACHER_EDIT_LESSON.get_list_subject_by_school_id();
        }else{
            COMMON.toggle_modal('modal-subject');
        }
    },
    call_modal_class: function(is_open){
        if(is_open){
            if(TEACHER_EDIT_LESSON.school_id==undefined || TEACHER_EDIT_LESSON.school_id==null || TEACHER_EDIT_LESSON.school_id==''){
                bootbox.alert(lang.missing_school);
                return false;
            }
            if(TEACHER_EDIT_LESSON.current_class.length==0){
                $("#btn-confirm-class").prop("disabled", true);
            }
            TEACHER_EDIT_LESSON.get_list_class_by_school_id();
        }else{
            COMMON.toggle_modal('modal-classes');
        }
        var is_valid = TEACHER_EDIT_LESSON.validator.form();
        if(is_valid){
            $('#btn-submit-lesson').prop("disabled", false);
        }
    },
    call_modal_teacher: function(is_open){
        if(is_open){
            if(TEACHER_EDIT_LESSON.school_id==undefined || TEACHER_EDIT_LESSON.school_id==null || TEACHER_EDIT_LESSON.school_id==''){
                bootbox.alert(lang.missing_school);
                return false;
            }
            TEACHER_EDIT_LESSON.get_list_teacher();
        }else{
            COMMON.toggle_modal('modal-teachers');
        }
    },
    call_modal_attend_teacher: function(is_open){
        if(is_open){
            if(TEACHER_EDIT_LESSON.school_id==undefined || TEACHER_EDIT_LESSON.school_id==null || TEACHER_EDIT_LESSON.school_id==''){
                bootbox.alert(lang.missing_school);
                return false;
            }
            TEACHER_EDIT_LESSON.get_list_attend_teacher();
        }else{
            COMMON.toggle_modal('modal-attend-teacher');
        }
    },
    get_list_class_by_school_id: function(){
        var data_form = {
            school_id: TEACHER_EDIT_LESSON.school_id
        }
        SERVICE.get_list_class_by_school_id(data_form, function(resp){
            if(resp.status === 200){
                var lst_current_classes = resp.params;
                var data_to_popup = '';
                for (id_class in lst_current_classes) {
                    var checked = TEACHER_EDIT_LESSON.current_class.indexOf(id_class)!=-1?'checked':'';
                    data_to_popup += "<label class='col-md-6 p-0 normal-weight'> <input type='checkbox' name='class' value='"+id_class+"' "+checked+" required/> <span id='rd-class-"+id_class+"'>"+lst_current_classes[id_class]+"</span></label>"; 
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
            language: COMMON.cfg_lang,
            school_id: TEACHER_EDIT_LESSON.school_id
        }
        SERVICE.get_list_subject_by_school_id(data_form, function(resp){
            if(resp.status === 200){
                var lst_current_subject = resp.params;
                var data_to_popup = '';
                for (id_subject in lst_current_subject) {
                    var checked = (TEACHER_EDIT_LESSON.current_subject==id_subject)?'checked':'';
                    data_to_popup += "<label class='col-md-6 p-0 normal-weight'> <input type='radio' name='subject' value='"+id_subject+"' "+checked+" required/> <span id='rd-subject-"+id_subject+"'>"+lst_current_subject[id_subject]+"</span></label>"; 
                }
                $("#lst-current-subject").html(data_to_popup);
                COMMON.toggle_modal('modal-subject');
            }else{
                bootbox.alert(resp.message);
            }
        })
    },
    get_list_teacher: function(){
        var data_form = {
            school_id: TEACHER_EDIT_LESSON.school_id
        }
        SERVICE.get_list_teacher(data_form, function(resp){
            if(resp.status === 200){
                var lst_current_teacher = resp.params;
                var data_to_popup = '';
                for (id_teacher in lst_current_teacher) {
                    if(id_teacher!=COMMON.currentuser['member_id']){
                        var checked = TEACHER_EDIT_LESSON.current_teacher.indexOf(id_teacher)!=-1?'checked':'';
                        data_to_popup += "<label class='col-md-4 p-0 normal-weight'> <input type='checkbox' name='teacher' value='"+id_teacher+"' "+checked+"/> <span id='rd-teacher-"+id_teacher+"'>"+lst_current_teacher[id_teacher]+"</span></label>"; 
                    }
                }
                $("#lst-current-teachers").html(data_to_popup);
                COMMON.toggle_modal('modal-teachers');
            }else{
                bootbox.alert(resp.message);
            }
        })
    },
    get_list_attend_teacher: function(){
        var data_form = {
            school_id: TEACHER_EDIT_LESSON.school_id
        }
        SERVICE.get_list_teacher(data_form, function(resp){
            if(resp.status === 200){
                var lst_attend_teacher = resp.params;
                var data_to_popup = '';
                for (id_teacher in lst_attend_teacher) {
                    if(id_teacher!=COMMON.currentuser['member_id']){
                        var checked = TEACHER_EDIT_LESSON.current_attend_teacher.indexOf(id_teacher)!=-1?'checked':'';
                        data_to_popup += "<label class='col-md-4 p-0 normal-weight'> <input type='checkbox' name='attend-teacher' value='"+id_teacher+"' "+checked+"/> <span id='rd-attend-teacher-"+id_teacher+"'>"+lst_attend_teacher[id_teacher]+"</span></label>"; 
                    }
                }
                $("#lst-attend-teacher").html(data_to_popup);
                COMMON.toggle_modal('modal-attend-teacher');
            }else{
                bootbox.alert(resp.message);
            }
        })
    }
}