var SCHOOL_WELCOME = {
    lst_material    : [],
    lst_material_extension_allowed: ['pdf', 'jpg', 'jpeg', 'png'],
    mark_apply_now: false,
    is_submit_application_form: false,
    validator       : '',
    option_validation : {
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
            if(validator.errorList.length){
                $('#submit-create-school').prop("disabled", true);
            }
        },
        submitHandler: function(){
            //do nothing
            return false;
        }
    },
    init_page: function() {
        SCHOOL_WELCOME.lst_material      = [];

        $(document).on('keyup change paste input', 'input, select, textarea', function(){
            SCHOOL_WELCOME.validator = $('#frm-crt-school').validate(SCHOOL_WELCOME.option_validation);
            var is_valid = SCHOOL_WELCOME.validator.form();
            if(is_valid){
                $('#submit-create-school').prop("disabled", false);
            }
        })

        $("#frm-crt-school").trigger("reset");
        $('#submit-create-school').prop("disabled", true);
        $("#lst-imported-material").html("");

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
                if(SCHOOL_WELCOME.validation_file(files[i])){
                    SCHOOL_WELCOME.lst_material.push(files[i]);
                    SCHOOL_WELCOME.get_file_preview();
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
                if(SCHOOL_WELCOME.validation_file(files[i])){
                    SCHOOL_WELCOME.lst_material.push(files[i]);
                    SCHOOL_WELCOME.get_file_preview();
                }
            }
        });
        /*File drag n drop handler*/

        $(document).on('hidden.bs.modal', '#modal-school-application', function(){
            if(!SCHOOL_WELCOME.is_submit_application_form){
                var data={
                    name: $("#frm-crt-school #school_name").val(),
                    school_code: $("#frm-crt-school #school_code").val(),
                    contact_person: $("#frm-crt-school #school_contact_person").val(),
                    phone_number: $("#frm-crt-school #school_phone_number").val(),
                    email: $("#frm-crt-school #school_email").val(),
                    address: $("#frm-crt-school #school_address").val()
                }
                for (var key in data) {
                    if(data[key]!=''){
                        $('#modal-confirm-close-school-application').modal({'backdrop': 'static'});
                        return false;
                    }
                }
            }
        })
        $(document).on('shown.bs.modal', '#modal-school-application', function(){
            SCHOOL_WELCOME.validator = $('#frm-crt-school').validate(SCHOOL_WELCOME.option_validation);
        })
        $(document).on('hidden.bs.modal', '#modal-success', function(){
            location.reload();
        })
    },
    create_school: function(e){
        e.preventDefault();
        var form_data   = new FormData();
        var validation = false;
        var data={
            name: $("#frm-crt-school #school_name").val(),
            school_code: $("#frm-crt-school #school_code").val().toLowerCase(),
            title: $("#frm-crt-school #school_title").val(),
            contact_person: $("#frm-crt-school #school_contact_person").val(),
            // phone_prefix: $("#frm-crt-school #school_phone_prefix").val(),
            phone_number: $("#frm-crt-school #school_phone_number").val(),
            email: $("#frm-crt-school #school_email").val(),
            address: $("#frm-crt-school #school_address").val()
        }
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);

        if(SCHOOL_WELCOME.lst_material.length>0){
            form_data.append('number_file',  SCHOOL_WELCOME.lst_material.length);
            for(var i=0; i<SCHOOL_WELCOME.lst_material.length; i++){
                form_data.append('file'+i,  SCHOOL_WELCOME.lst_material[i]);
            }
        }
        validation = SCHOOL_WELCOME.validation_create_school(data);
        if(validation){
            SCHOOL_WELCOME.is_submit_application_form = true;
            // data.phone_number = data.phone_prefix + data.phone_number;
            data.contact_person = data.title +' '+ data.contact_person;
            for (var key in data) {
                form_data.append(key, data[key]);
            }
            SERVICE.create_school(form_data, function(resp){
                if(resp.status == 200){
                    SCHOOL_WELCOME.init_page();
                    $('#modal-approve-school').modal({'backdrop': 'static'});
                    $("#url-landing-access").attr('href', COMMON.base_url+'schools/landing/'+data.school_code);
                    $('#modal-school-application').modal('hide');
                }else{
                    bootbox.alert(resp.message);
                    $("#frm-crt-school .grp_error .error-msg").html(resp.message);
                }
            })
        }
    },
    validation_create_school: function(data_form){
        var validate     = true;
        $("#frm-crt-school input").removeClass("error");
        $("#frm-crt-school .error-msg").html('');

        if(data_form.name==undefined || data_form.name==null || data_form.name==''){
            $("#frm-crt-school .grp_school_name input").addClass("error");
            $("#frm-crt-school .grp_school_name .error-msg").html(lang.missing_school_name);
            validate = false;
        }
        else if(data_form.name.length>255 ){
            $("#frm-crt-school .grp_school_name input").addClass("error");
            $("#frm-crt-school .grp_school_name .error-msg").html(lang.error_school_name);
            validate = false;
        }

        if(data_form.school_code==undefined || data_form.school_code==null || data_form.school_code==''){
            $("#frm-crt-school .grp_school_code input").addClass("error");
            $("#frm-crt-school .grp_school_code .error-msg").html(lang.error_school_code);
            validate = false;
        }
        else if(data_form.school_code.length>9 || data_form.school_code.length<5){
            $("#frm-crt-school .grp_school_code input").addClass("error");
            $("#frm-crt-school .grp_school_code .error-msg").html(lang.error_school_code);
            validate = false;
        }else if(!COMMON.regex_school_code.test(data_form.school_code)){
            $("#frm-crt-school .grp_school_code input").addClass("error");
            $("#frm-crt-school .grp_school_code .error-msg").html(lang.error_school_code);
            validate = false;
        }

        if(data_form.contact_person==undefined || data_form.contact_person==null || data_form.contact_person==''){
            $("#frm-crt-school .grp_contact_person input").addClass("error");
            $("#frm-crt-school .grp_contact_person .error-msg").html(lang.missing_contact_person);
            validate = false;
        }
        else if(data_form.contact_person.length>255){
            $("#frm-crt-school .grp_contact_person input").addClass("error");
            $("#frm-crt-school .grp_contact_person .error-msg").html(lang.error_contact_person);
            validate = false;
        }

        if(data_form.phone_number!=undefined && data_form.phone_number!=null && data_form.phone_number!=''){
            if(data_form.phone_number.length<6 || !COMMON.regex_phone.test(data_form.phone_number)){
                $("#frm-crt-school .grp_phone_number input").addClass("error");
                $("#frm-crt-school .grp_phone_number .error-msg").html(lang.error_phone_number);
                validate = false;
            }
        }
        
        if(data_form.email==undefined ||data_form.email==null || data_form.email==''){
            $("#frm-crt-school .grp_email input").addClass("error");
            $("#frm-crt-school .grp_email .error-msg").html(lang.missing_email);
            validate = false;
        }else if(!COMMON.regex_email.test(data_form.email)){
            $("#frm-crt-school .grp_email input").addClass("error");
            $("#frm-crt-school .grp_email .error-msg").html(lang.error_email);
            validate = false;
        }

        if(data_form.address!=undefined && data_form.address!=null && data_form.address!=''){
            if(data_form.address.length>255){
                $("#frm-crt-school .grp_address input").addClass("error");
                $("#frm-crt-school .grp_address .error-msg").html(lang.error_address);
                validate = false;
            }
        }

        return validate; 
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(SCHOOL_WELCOME.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    remove_material: function(index){
        SCHOOL_WELCOME.lst_material.splice(index, 1);
        SCHOOL_WELCOME.get_file_preview();
    },
    get_file_preview: function(){
        var files = SCHOOL_WELCOME.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="SCHOOL_WELCOME.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $('.modal:visible').each(COMMON.reposition_modal);
        $("#lst-imported-material").html(preview_img);
    },
    apply_now: function(){
        SCHOOL_WELCOME.mark_apply_now = true;
        COMMON.trigger_form_login('login');
    },
    quit_form_school_application: function(is_quit){
        $('#modal-confirm-close-school-application').modal('hide')
        if(is_quit){
            $("#frm-crt-school input").removeClass("error");
            $("#frm-crt-school .error-msg").html('');
            SCHOOL_WELCOME.init_page();
        }else{
            $('#modal-school-application').modal({'backdrop': 'static'});
        }
    }
}