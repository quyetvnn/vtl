var ASSIGNMENT_SUBMIT = {
    lst_material    : [],
    current_class   : [],
    teacher_create_assignment_id : '',
    resubmit: 0,
    lst_material_extension_allowed: ['docx', 'ppt', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'mp4'],
    init_page: function() {
        ASSIGNMENT_SUBMIT.lst_material      = [];
        ASSIGNMENT_SUBMIT.current_class     = [];
        if(COMMON.currentuser){
            if(COMMON.currentuser['community']){
                if(COMMON.currentuser['community'].length==1){
                    ASSIGNMENT_SUBMIT.school_id = COMMON.currentuser['community'][0].id;
                }
            }
            
        }
        ASSIGNMENT_SUBMIT.resubmit = $("#resubmit").val();
        ASSIGNMENT_SUBMIT.teacher_create_assignment_id = $("#teacher_create_assignment_id").val();
        if(ASSIGNMENT_SUBMIT.teacher_create_assignment_id==''){
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
                    ASSIGNMENT_SUBMIT.lst_material.push(files[i]);
                    ASSIGNMENT_SUBMIT.get_file_preview();
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
                    ASSIGNMENT_SUBMIT.lst_material.push(files[i]);
                    ASSIGNMENT_SUBMIT.get_file_preview();
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

        $(document).on("dp.change", "#assignment_time", function(e){
            var txt_show = e.date._d.getHours() + ":" +e.date._d.getMinutes();
            $("#lesson-end-time").html(txt_show);
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
            if(Disabled){
                $('#btn-submit-create-assignment').prop("disabled", true);
            }else{
                $('#btn-submit-create-assignment').prop("disabled", false);
            }
               
        })

    },
    submit_student_assignment: function(){
        var form_data   = new FormData();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);

        form_data.append('teacher_create_assignment_id',  ASSIGNMENT_SUBMIT.teacher_create_assignment_id);
        form_data.append('resubmit',  ASSIGNMENT_SUBMIT.resubmit);

        if(ASSIGNMENT_SUBMIT.lst_material.length>0){
            form_data.append('number_file',  ASSIGNMENT_SUBMIT.lst_material.length);
            for(var i=0; i<ASSIGNMENT_SUBMIT.lst_material.length; i++){
                form_data.append('file'+i,  ASSIGNMENT_SUBMIT.lst_material[i]);
            }
            SERVICE.student_submit_assignment(form_data, function(resp){
                bootbox.alert(resp.message);
                if(resp.status == 200){
                    window.location = document.referrer;
                }else{
                    
                }
            })
        }else{
            bootbox.alert(lang.missing_file);
        }
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    remove_material: function(index){
        ASSIGNMENT_SUBMIT.lst_material.splice(index, 1);
        ASSIGNMENT_SUBMIT.get_file_preview();
    },
    get_file_preview: function(){
        var files = ASSIGNMENT_SUBMIT.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="ASSIGNMENT_SUBMIT.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $("#lst-imported-material").html(preview_img);
    },
    call_modal_class: function(is_open){
        if(is_open){
            if(ASSIGNMENT_SUBMIT.current_class==''){
                $("#btn-confirm-class").prop("disabled", true);
            }
            ASSIGNMENT_SUBMIT.get_list_class_by_school_id();
        }else{
            $("#modal-classes").css("display", "none");
        }
    },
    confirm_modal_class: function(){
        ASSIGNMENT_SUBMIT.call_modal_class(false);
        ASSIGNMENT_SUBMIT.current_class = [];
        var classes_name = [];
        $('input[name="class"]:checked').each(function() {
            var class_id = $(this).attr('value');
            var class_name = $('#rd-class-'+class_id).text();
            ASSIGNMENT_SUBMIT.current_class.push(class_id);
            classes_name.push(class_name);
        });
        if(COMMON.cfg_lang=='eng'){
            classes_name = classes_name.join(", ");
        }else if(COMMON.cfg_lang=='zho'){
            classes_name = classes_name.join("、");
        }
        $("#class-option-name").html(classes_name).removeClass('default-text').addClass('text-dark-green');
        $("input[name='school_class']").val(ASSIGNMENT_SUBMIT.current_class);
    },
    get_list_class_by_school_id: function(){
        var data_form = {
            school_id: ASSIGNMENT_SUBMIT.school_id
        }
        SERVICE.get_list_class_by_school_id(data_form, function(resp){
            if(resp.status === 200){
                var lst_current_classes = resp.params;
                var data_to_popup = '';
                for (id_class in lst_current_classes) {
                    var checked = ASSIGNMENT_SUBMIT.current_class.indexOf(id_class)!=-1?'checked':'';
                    data_to_popup += "<label class='col-md-6 p-0 normal-weight'> <input type='checkbox' name='class' class='required' value='"+id_class+"' "+checked+"/> <span id='rd-class-"+id_class+"'>"+lst_current_classes[id_class]+"</span></label>"; 
                }
                $("#lst-current-classes").html(data_to_popup);
                $("#modal-classes").css("display", "block");
            }else{
                bootbox.alert(resp.message);
            }
        })
    },
}