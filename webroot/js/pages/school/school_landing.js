var SCHOOL_LANDING = {
    lst_material    : [],
    lst_material_extension_allowed: ['pdf', 'jpg', 'jpeg', 'png'],
    mark_apply_now: false,
    is_submit_application_form: false,
    data_school: {},
    editor: '',
    post_data: {},
    validator_form_create_post: {},
    validator_form_create_post_w_video: {},
    validator_form_create_post_w_video_config: {
        rules: {
            video_title: {
                required: true
            },
            post_privacy: {
                required: true
            },
            video_price: {
                required: true
            },
            video_tokens: {
                required: function(element){
                    var is_charge = $("input[name=video_price]:checked").val();
                    if(is_charge=='paid'){
                        return true;
                    }
                    return false;
                }
            }
        },
        messages: {
            video_title: {
                required: lang.missing_video_title
            },
            post_privacy: {
                required: lang.missing_post_privacy
            },
            video_price: {
                required: lang.missing_video_price
            },
            video_credits:{
                required: lang.missing_video_credits
            }
        },
        invalidHandler: function(e, validator){
            if(validator.errorList.length>0){
                $('#submit-create-post-w-video').prop("disabled", true);
            }
            
        },
        errorPlacement: function (error, element) {
            //do nothing
            return false;
        },
        highlight: function(element, errorClass) {
            //do nothing
            return false;
        },
    },
    init_page: function() {
        
        SCHOOL_LANDING.validator_form_create_post = $("#form-create-post").validate({
            rules: {
                video_title: {
                    required: true
                },
                post_privacy: {
                    required: true
                }
            },
            messages: {
                video_title: {
                    required: lang.missing_video_title
                },
                post_privacy: {
                    required: lang.missing_post_privacy
                }
            }
        });
        SCHOOL_LANDING.post_data = {};
        SCHOOL_LANDING.lst_material      = [];
        $("#lst-imported-material").html("");
        /*Ck editor balloon config*/
        BalloonEditor
        .create( document.querySelector( '#post-preview' ),{
            placeholder: lang.any_good_news_lately,
            toolbar: ['bold', 'italic', 'link', 'undo', 'redo']
        }).then( newEditor => {
            SCHOOL_LANDING.editor = newEditor;
        }).catch( error => {
            console.error( error );
        });
        /*Ck editor config*/

        $(document).on('change', 'input[name=video_price]', function(){
            var is_charge = $(this).val();
            if(is_charge=='paid'){
                $("#grb-input-video-credits").removeClass('hidden');
            }else{
                $("#grb-input-video-credits").addClass('hidden');
            }
        })
        $(document).on('keyup change paste input', '#form-create-post-w-video input, #form-create-post-w-video select, #form-create-post-w-video textarea', function(){
            SCHOOL_LANDING.validator_form_create_post_w_video = $("#form-create-post-w-video").validate(SCHOOL_LANDING.validator_form_create_post_w_video_config);
            // SCHOOL_WELCOME.validator = $('#frm-crt-school').validate(SCHOOL_WELCOME.option_validation);

            var is_valid = SCHOOL_LANDING.validator_form_create_post_w_video.form();
            if(is_valid){
                $('#submit-create-post-w-video').prop("disabled", false);
            }
        })
        $(document).on('show.bs.modal', '#modal-config-video', function(e){
            $("#form-create-post-w-video").trigger('reset');
            $('#submit-create-post-w-video').prop("disabled", true);
        })
        

        $(document).on('click', '#trigger-add-file', function(){
            var id_file = Date.now();
            var item_file = "<div class='item hidden' id='item-"+id_file+"'>"
                                +"<input type ='file' class='hidden attached-file-item' name='attached-file' id='file-"+id_file+"' />"
                            + "</div>";
            $("#attached-file").append(item_file);
            $("#file-"+id_file).click();
        })
        $(document).on('change', '.attached-file-item', function(){
            var id_item = $(this).attr('id').split('-').pop();
            var files = $('#file-'+id_item)[0].files;
            for(var i=0; i<files.length; i++){
                if(SCHOOL_LANDING.validation_file(files[i])){
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("#item-"+id_item).css('background', 'url('+e.target.result+')').removeClass('hidden');
                    }
                    reader.readAsDataURL(files[i]); // convert to base64 string
                }
            }
        })
        /*Video uploader*/
        $('.import-file-area').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(".import-file-area").addClass('hover');
        }).on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Drop
        $('#import-post-video').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(".import-file-area").removeClass('hover');
            var file = e.originalEvent.dataTransfer.files[0];
            SCHOOL_LANDING.config_post_video(file);
        });

        // Open file selector on div click
        $("#import-post-video").click(function(){
            $("#upload-post-video").click();
        });

        // file selected
        $("#upload-post-video").change(function(){
            var file = $('#upload-post-video')[0].files[0];
            SCHOOL_LANDING.config_post_video(file);
        });
        /*Video uploader*/

        /*Video cover uploader*/
        $('.import-file-area').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(".import-file-area").addClass('hover');
        }).on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Drop
        $('#import-video-cover').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(".import-file-area").removeClass('hover');
            var file = e.originalEvent.dataTransfer.files[0];
            SCHOOL_LANDING.config_post_video_cover(file);
        });

        // Open file selector on div click
        $("#import-video-cover").click(function(){
            $("#upload-video-cover").click();
        });

        // file selected
        $("#upload-video-cover").change(function(){
            var file = $('#upload-video-cover')[0].files[0];
            SCHOOL_LANDING.config_post_video_cover(file);
        });
        /*Video cover uploader*/

        $(document).on('change', '.required', function(e){
            let Disabled = false;
            SCHOOL_COMMON.data_school = {
                about_us: $("#frm-edit-school #school_about").val(),
                phone_number: $("#frm-edit-school #school_phone_number").val(),
                email: $("#frm-edit-school #school_email").val(),
                address: $("#frm-edit-school #school_address").val(),
                id: SCHOOL_COMMON.school_id
            }
        })

        $(document).on('change', '.form-control', function(e){
            let Disabled = false;
            SCHOOL_COMMON.data_school = {
                about_us: $("#frm-edit-school #school_about").val(),
                phone_number: $("#frm-edit-school #school_phone_number").val(),
                email: $("#frm-edit-school #school_email").val(),
                address: $("#frm-edit-school #school_address").val(),
                id: SCHOOL_COMMON.school_id
            }
        })
        $(document).on('show.bs.modal', '#modal-insert-link', function(e){
            $("#form-inser-link").trigger('reset');
        })
        $(document).on('show.bs.modal', '#modal-school-edit', function(e){
            $("#frm-edit-school").trigger('reset');
            $("#frm-edit-school input").removeClass("error");
            $("#frm-edit-school textarea").removeClass("error");
            $("#frm-edit-school .error-msg").html('');
            var data_form = {
                school_id: SCHOOL_COMMON.school_id
            }
            SERVICE.get_school_by_id(data_form, function(resp){
                if(resp.status === 200){
                    var school = resp.params[0];
                    $("#school_about").html(school['about_us']);
                    $("#school_phone_number").html(school['phone_number']);
                    $("#school_email").html(school['email']);
                    $("#school_address").html(school['address']);
                    SCHOOL_COMMON.data_school = {
                        about_us: school['about_us'],
                        phone_number: school['phone_number'],
                        email: school['email'],
                        address: school['address'],
                        id: SCHOOL_COMMON.school_id
                    }
                }else{
                    bootbox.alert(resp.message);
                }
            })
        })
        $(document).on('hidden.bs.modal', function(e){
            $(e.target).removeData('bs.modal');
        })
        var template_option_privacy = "<ul class='list-style-none p-0 lst-post-privacy'>"
                                       + "<li class='item'> <i class='fa fa-globe' aria-hidden='true'></i> Public <i class='checked-icon fa fa-check-circle' aria-hidden='true'></i></li>"
                                       + "<li class='item'><i class='fa fa-users' aria-hidden='true'></i> School Members  <i class='checked-icon fa fa-check-circle' aria-hidden='true'></i></li>"
                                       + "<li class='item'><button type='submit' class='btn btn-w-radius btn-green'> Publish now</button></li>"
                                       + "</ul>";  
        var popover_option ={
            trigger: 'click',
            container: 'body',
            placement: 'bottom',
            html: true,
            content: template_option_privacy,
            template: '<div class="popover" role="tooltip"><div class="popover-content"></div></div>'
        }
        $("#post_privacy_toggle").popover(popover_option);
        
        // $(document).on('click', '#post_privacy_toggle', function(){
        //     console.log('click');
        // })
    },
    edit_school: function(e){
        e.preventDefault();
        var validation = false;
        validation = SCHOOL_LANDING.validation_edit_school(SCHOOL_COMMON.data_school);
        if(validation){
            SCHOOL_LANDING.is_submit_application_form = true;
            SCHOOL_COMMON.submit_edit_school(SCHOOL_COMMON.data_school);
        }
    },
    
    validation_edit_school: function(data_form){
        var validate     = true;
        var phone_char   = /^\+?([0-9-.+ ])+$/;
        var special_char = /[`!@#$%^&*()+\=\[\]{};':"\\|,.<>\/?~]/;
        var regex_email  = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        $("#frm-edit-school input").removeClass("error");
        $("#frm-edit-school .error-msg").html('');
        $("#frm-edit-school textarea").removeClass("error");

        if(data_form.phone_number!=undefined && data_form.phone_number != null && data_form.phone_number!=''){
            if(data_form.phone_number.length<6 || !phone_char.test(data_form.phone_number)){
                $("#frm-edit-school .grp_phone_number input").addClass("error");
                $("#frm-edit-school .grp_phone_number .error-msg").html(lang.error_phone_number);
                validate = false;
            }
        }
        
        if(data_form.email==undefined ||data_form.email==null || data_form.email==''){
            $("#frm-edit-school .grp_email input").addClass("error");
            $("#frm-edit-school .grp_email .error-msg").html(lang.missing_email);
            validate = false;
        }else if(!regex_email.test(data_form.email)){
            $("#frm-edit-school .grp_email input").addClass("error");
            $("#frm-edit-school .grp_email .error-msg").html(lang.error_email);
            validate = false;
        }
        
        if(data_form.about_us==undefined || data_form.about_us==null || data_form.about_us==''){
            $("#frm-edit-school .grp_about_us textarea").addClass("error");
            $("#frm-edit-school .grp_about_us .error-msg").html(lang.missing_school_about_us);
            validate = false;
        }
        else if(data_form.about_us.length>500){
            $("#frm-edit-school .grp_about_us textarea").addClass("error");
            $("#frm-edit-school .grp_about_us .error-msg").html(lang.error_school_about_us);
            validate = false;
        }

        if(data_form.address!=undefined && data_form.address!=null && data_form.address!=''){
           if(data_form.address.length>255){
                $("#frm-edit-school .grp_address input").addClass("error");
                $("#frm-edit-school .grp_address .error-msg").html(lang.error_address);
                validate = false;
            }
        }

        return validate; 
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(SCHOOL_LANDING.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    remove_material: function(index){
        SCHOOL_LANDING.lst_material.splice(index, 1);
        SCHOOL_LANDING.get_file_preview();
    },
    get_file_preview: function(){
        var files = SCHOOL_LANDING.lst_material;
        var preview_img = "";
        for(var i=0; i<files.length; i++){
            var f_extension = files[i].name.split('.').pop();
            preview_img+='<li class="item">';
            preview_img+='<p class="file-name m-0">'+files[i].name+'</p>';
            preview_img+='<p class="file-info text-grey">';
            preview_img+=files[i].size + ' Bytes ';
            preview_img+='<span class="fa fa-circle seperate" ></span>';
            preview_img+=f_extension;
            preview_img+='</p><span class="fa fa-times remove-file pointer" onclick="SCHOOL_LANDING.remove_material('+i+')"></span>';
            preview_img+='</li>';
        }
        $('.modal:visible').each(COMMON.reposition_modal);
        $("#lst-imported-material").html(preview_img);
    },
    insert_link: function(event){
        event.preventDefault();
        var insert_text = $("#text-display").val();
        var insert_link = $("#link").val();
        var cur_content = "<a href='"+insert_link+"'>"+insert_text+"</a>";
        $("#modal-insert-link").modal('hide');
        SCHOOL_LANDING.editor.model.change( writer => {
            const insertPosition = SCHOOL_LANDING.editor.model.document.selection.getFirstPosition();
            writer.insertText( insert_text, { linkHref:insert_link }, insertPosition );
        } );
    },
    trigger_upload_post_image: function(){
        $("#upload-post-image").click();
    },
    upload_post_image: function(event){
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#item-preview-media").css('background', 'url('+e.target.result+')').removeClass('hidden');
        }
        reader.readAsDataURL(file); // convert to base64 string
        SCHOOL_LANDING.post_data.image = file;
        SCHOOL_LANDING.post_data.video = {};
        
    },
    remove_post_media: function(){
        SCHOOL_LANDING.post_data.image = '';
        SCHOOL_LANDING.post_data.video = {};
    },
    config_post_video: function(file){
        if(COMMON.validation_file(file)){
            var video_title = file['name'].split('.');
            var size = file['size']/(1000*1000);
            var file_ex = video_title.pop();
            video_title = video_title.join('.');
            file.video_title = video_title;
            SCHOOL_LANDING.post_data.video = file;
            SCHOOL_LANDING.post_data.image = '';
            $("#post-video-name").html(video_title);
            $("#post-video-size").html(size.toFixed(2) + 'MB'+ ' . '+ file_ex);
            $("#modal-upload-video").modal('hide');
            $("#modal-config-video").modal({'backdrop': 'static'});
            $("#video_title").val(video_title);
            $("#post_description").val($("#post-preview").text());
        }else{
            bootbox.alert('File error');
        }
    },
    config_post_video_cover: function(file){
        if(COMMON.validation_file(file)){
            SCHOOL_LANDING.post_data.video['cover'] = file;
            $("#grb-dropfile-video-cover").addClass('hidden');
            $(".preview-image").removeClass("hidden");
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#preview-video-cover").css('background', 'url('+e.target.result+')').removeClass('hidden');
            }
            reader.readAsDataURL(file); // convert to base64 string
        }
    },
    trigger_submit_create_post: function(){
        $("#post_description").prop('required', 'false');
        $("#form-create-post").submit();
    }
}