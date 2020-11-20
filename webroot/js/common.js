Date.prototype.getWeek = function (dowOffset) {
/*getWeek() was developed by Nick Baicoianu at MeanFreePath: http://www.meanfreepath.com */

    dowOffset = typeof(dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
    var newYear = new Date(this.getFullYear(),0,1);
    var day = newYear.getDay() - dowOffset; //the day of week the year begins on
    day = (day >= 0 ? day : day + 7);
    var daynum = Math.floor((this.getTime() - newYear.getTime() - 
    (this.getTimezoneOffset()-newYear.getTimezoneOffset())*60000)/86400000) + 1;
    var weeknum;
    //if the year starts before the middle of a week
    if(day < 4) {
        weeknum = Math.floor((daynum+day-1)/7) + 1;
        if(weeknum > 52) {
            nYear = new Date(this.getFullYear() + 1,0,1);
            nday = nYear.getDay() - dowOffset;
            nday = nday >= 0 ? nday : nday + 7;
            /*if the next year starts before the middle of
              the week, it is week #1 of that year*/
            weeknum = nday < 4 ? 1 : 53;
        }
    }
    else {
        weeknum = Math.floor((daynum+day-1)/7);
    }
    return weeknum;
};
var COMMON = {
    base_api_url            : '',
    base_url                : '',
    cfg_lang                : '',
    current_validation_code : new Array(4),
    username                : '',
    token                   :  '',
    currentuser             : {},
    is_login                : false,
    is_login_w_invitation   : false,
    is_register_w_invitation: false,
    count_downloaded        : 0,
    list_downloadable       : [],
    list_downloadable_name  : [],
    zip                     :'',
    zip_fileName            :'',
    select_all              : false,
    included_ids            : [],
    excluded_ids            : [],
    role_teacher            : '',
    role_student            : '',
    role_school_admin       : '',
    regex_email             : /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    regex_special_char      : /[`!@#$%^&*()+\=\[\]{};':"\\|,.<>\/?~]/,
    regex_phone             : /^\+?([0-9-.+ ])+$/,
    regex_number_n_char     : /^[a-z0-9]+$/i,
    regex_school_code       : /^[a-z0-9-_.+/\\]+$/i,
    lst_material_extension_allowed: ['docx', 'doc', 'pptx', 'ppt', 'xls', 'xlsx', 'pdf', 'mp3', 'mp4', 'jpg', 'jpeg', 'gif', 'png', 'zip', 'rar'],
    max_upload_file         : 15728640,
    call_ajax: function(params){
        params.data.token = COMMON.token;
        params.data.language = COMMON.cfg_lang;
        $.ajax({
            url: params.url,
            type: params.type,
            data: params.data,
            dataType: params.dataType,
            beforeSend: params.beforeSend,
            success: function(data){
                if(data.status!=undefined && data.status!=null && data.status==600){
                    COMMON.currentuser = '';
                    COMMON.setCookie('currentuser', '', 0);
                    COMMON.redirect_to_landing();
                }else{
                    params.success(data);
                }
            },
            error: params.error,
            complete: function(){
                $("#loadingDiv").css("display","none");
            }
        })
    },
    fb_login: function(){
        $("#login_fb_form").submit();
    },
    init_page: function(cfg_lang, base_url, base_api_url) {
        // console.log('aaa', cfg_lang, base_url, base_api_url);
        var tdate = new Date();
        COMMON.cfg_lang = cfg_lang;
        COMMON.base_url = base_url;
        COMMON.base_api_url = base_api_url;
        COMMON.currentuser = COMMON.getCookie('currentuser');
        if(COMMON.currentuser!=undefined && COMMON.currentuser!=null && COMMON.currentuser!=''){
            COMMON.currentuser = JSON.parse(COMMON.currentuser);
            if(COMMON.currentuser.token!=''){
                COMMON.token = COMMON.currentuser.token;
            }
        }

        $(document).ajaxStart(function(){
          $("#loadingDiv").css("display","block");
        });
        $(document).ajaxComplete(function(){
          $("#loadingDiv").css("display","none");
        });

        $('[data-toggle="tooltip"]').tooltip();

        // $('.modal').on('show.bs.modal', COMMON.reposition_modal);
        $(document).on("show.bs.modal", '.modal', COMMON.reposition_modal);
        // COMMON.Reposition when the window is resized
        $(window).on('resize', function() {
            $('.modal:visible').each(COMMON.reposition_modal);
        });
        $(document).click(function(){
            $(".collapse").attr("aria-expanded","false");
            $(".collapse").removeClass("in");
        });

        $(".collapse").click(function(e){
          e.stopPropagation();
        });

        $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please check your input."
        );
        $.validator.addMethod(
                "unregex",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || !re.test(value);
                },
                "Please check your input."
        );

        // $('#loadingDiv').hide().ajaxStart(function(){
        //     $(this).show();  // show Loading Div
        // }).ajaxStop(function(){
        //     $(this).hide(); // hide loading div
        // });

        $(".select_id").prop('checked', false);
        $(".select_all").prop('checked', false);

        $(document).on('mouseenter', '#language-pane', function(){
            
        })
        .on('mouseleave','#language-pane',  function(){
            $("#user-pane").removeClass('hidden');
            $(this).addClass('hidden');
        });
        $(document).on('mouseenter', '#support-pane', function(){
            // $("#user-pane").removeClass('hidden');
            // $(".user-pane").css('display', '');
        })
        .on('mouseleave','#support-pane',  function(){
            $("#user-pane").removeClass('hidden');
            $(this).addClass('hidden');
        });
        
        $('.button-help').on('click', function(e){
            e.preventDefault();
            if ($('.div-tooltip').hasClass('hidden')) {
                $('.div-tooltip').removeClass('hidden');
            } else {
                $('.div-tooltip').addClass('hidden');
            }

        });

        $('.button-close').on('click', function(e){
            e.preventDefault();

            $('.div-tooltip').addClass('hidden');
        });

        $('.lesson-start-time').on('focus', function(e) {
            e.preventDefault();
            $(this).attr("autocomplete", "off");  
         });
        $(document).on('click', '#btn_toggle_menu', function(){
            $(".icon-open-menu").toggleClass("hidden");
            $(".icon-close-menu").toggleClass("hidden");
        })
        $(document).on('click', ".toggle-password", function(){
            var curr_type = $("input[name='password']").attr("type");
            $(".toggle-password").toggleClass("hidden");
            if(curr_type=='password'){
                $("input[name='password']").attr("type", "text");
            }else{
                $("input[name='password']").attr("type", "password");
            }
        })
        $(document).on('click', ".trigger-active-login", function(){
            $(".active-register").addClass("hidden");
            $(".active-login").removeClass("hidden");
        })
        $(document).on('click', ".trigger-active-register", function(){
            $(".active-login").addClass("hidden");
            $(".active-register").removeClass("hidden");
        })

        $(document).on('show.bs.modal', "#modal-forget-password", function(){
            COMMON.toggle_modal('login');
            $("#form_update_password").trigger('reset');
            $('#btn-submit-update-password').prop("disabled", true);
        })
        

        $(document).on('show.bs.modal', "#modal-reset-password", function(){
            $("#form_reset_password").trigger('reset');
            $("#form_reset_password .error").html('');
            $("#form_reset_password input").removeClass('error');
            $('#btn-submit-reset-password').prop("disabled", true);
        })

        $(document).on('keyup', "#form_reset_password input", function(){
            var lst_val = $("#form_reset_password input");
            let Disabled = true;

            lst_val.each(function() {
                let value = this.value;

                if ((value)&&(value.trim() !='')){
                    Disabled = false
                }else{
                    Disabled = true
                    return false
                }
            });
            if(Disabled){
                $('#btn-submit-reset-password').prop("disabled", true);
            }else{
                $('#btn-submit-reset-password').prop("disabled", false);
            }
        })

        $(document).on('submit', "#form_reset_password", function(e){
            e.preventDefault();
            $("#form_reset_password input").removeClass('error');
            $("#form_reset_password .error").html("");
            var data_form = {
                'old_password': $("#old_password").val(),
                'new_password': $("#new_password").val(),
                'repeat_new_password': $("#repeat_new_password").val()
            }
            if(data_form.new_password.length<8){
                $("#reset-password-error").html(lang.error_password);
                $("#new_password").addClass('error');
            }else if(data_form.new_password!=data_form.repeat_new_password){
                $("#reset-password-error").html(lang.new_password_does_not_match);
                $("#new_password").addClass('error');
                $("#repeat_new_password").addClass('error');
            }else if(data_form.new_password==data_form.old_password){
                $("#reset-password-error").html(lang.new_password_have_to_different_w_current_password);
                $("#new_password").addClass('error');
            }else{
                SERVICE.reset_password(data_form, function(resp){
                    if(resp.status === 200){
                        $("#modal-reset-password").modal('hide');
                        bootbox.alert(resp.message, function(){
                            COMMON.logout();
                        });
                    }else{
                        $("#reset-password-error").html(resp.message);
                    }
                })
            }
        })
        
        $(document).on('submit', "#form-login", function(e){
            e.preventDefault();
            var data_form = {
                'username': $("#login-username").val(),
                'password': $("#login-password").val(),
                'school_code': $("#login-school-code").val()
            }
            if(COMMON.is_login_w_invitation == true){
                var url = new URL(window.location.href);
                var username_link = url.searchParams.get("email");
                var school_id_link = url.searchParams.get("school_id");
                var role_id_link = url.searchParams.get("role_id");
                var school_code_link = url.searchParams.get("school_code");
                data_form.username_link = username_link;
                data_form.school_id_link = school_id_link;
                data_form.role_id_link = role_id_link;
                // data_form._school_code = school_code_link;
            }
            var validate= true;
            if(data_form.username==undefined || data_form.username==null || data_form.username==''){
                $("#form-login .grp-username input").addClass("error");
                $("#form-login .grp-username .error-msg").html(lang.missing_username);
                validate = false;
            }else{
                $("#form-login .grp-username input").removeClass("error");
                $("#form-login .grp-username .error-msg").html('');
            }

            if(data_form.password==undefined ||data_form.password==null || data_form.password==''){
                $("#form-login .grp-password input").addClass("error");
                $("#form-login .grp-password .error-msg").html(lang.missing_password);
                validate = false;
            }else{
                $("#form-login .grp-password input").removeClass("error");
                $("#form-login .grp-password .error-msg").html('');
            }
            
            if(validate){
                COMMON.is_login = true;
                COMMON.username = data_form.username;
                SERVICE.login(data_form, function(resp){
                    if(resp.status === 200){
                        $("#login").removeClass('show-modal');
                        var member = resp.params.MemberLoginMethod;
                        var obj_user= COMMON.parse_user_info(resp.params);
                        COMMON.currentuser = obj_user;
                        COMMON.token = obj_user.token;
                        if(COMMON.is_login_w_invitation){
                            COMMON.get_profile();
                        }
                        if(obj_user.avatar=='' ){
                            $("#preview-avatar").attr("src", obj_user.tmp_avatar);
                        }
                        if(obj_user.nick_name==''){
                            $("#update-profile").addClass('show-modal');
                        }
                        if(obj_user.avatar=='' && obj_user.nick_name!=''){
                            $("#update-profile").addClass('show-modal');
                            $("#update-avatar-step").css("display", "block");
                            $("#update-nickname-step").css("display", "none");
                        }
                        if(obj_user.nick_name!='' && obj_user.avatar!=''){
                            if(typeof SCHOOL_WELCOME!== 'undefined'){
                                if(SCHOOL_WELCOME.mark_apply_now){
                                    if(COMMON.currentuser['role_id'].indexOf(100)!=-1){
                                         $('#modal-school-application').modal({'backdrop': 'static'});
                                        return false;
                                    }else{
                                        location.reload();
                                    }
                                }
                            }
                            if(COMMON.is_login_w_invitation == true){
                                COMMON.redirect_to_landing();
                            }else{
                                location.reload();
                            }
                        }
                    }else{
                        if(resp.status==901){
                            $("#form-login .grp-username input").addClass("error");
                            $("#form-login .grp-username .error-msg").html(resp.message);
                            $("#form-login .login-error").html(lang.error_school_code);
                        }else if(resp.status==902){
                            $("#form-login .grp-password input").addClass("error");
                            $("#form-login .grp-password .error-msg").html(resp.message);
                        }else if(resp.status==903){
                            COMMON.currentuser = data_form;
                            $("#login").removeClass('show-modal');
                            $("#veriry-email").addClass("show-modal");
                            $("#validation-info").html(resp.message);
                        }else{
                            $(".login-error").html(resp.message);
                        }
                    }
                })
            }
            
        })
        $(document).on('submit', "#form-register", function(e){
            e.preventDefault();
            
            var data_form = {
                'language': COMMON.cfg_lang,
                'username': $("#register-username").val(),
                'name': $("#register-name").val(),
                // 'first_name': $("#register-firstname").val(),
                // 'last_name': $("#register-lastname").val(),
                'email': $("#register-email").val(),
                'phone_number': $("#register-phone-number").val(),
                // 'phone_prefix': $("#register-phone-prefix").val(),
                'password': $("#register-password").val(),
                'invitation_code': $("#register-invitation-code").val()
            }

            if(COMMON.is_register_w_invitation == true){
                var url = new URL(window.location.href);
                var username_link = url.searchParams.get("email");
                var school_id_link = url.searchParams.get("school_id");
                var role_id_link = url.searchParams.get("role_id");
                data_form.username_link = username_link;
                data_form.school_id_link = school_id_link;
                data_form.role_id_link = role_id_link;
                data_form.email = username_link;
            }
            
            var validate = COMMON.validate_register_form(data_form);
            // data_form.phone_number = $("#register-phone-prefix").val() + data_form.phone_number;

            if(validate){
                COMMON.currentuser = data_form;
                COMMON.currentuser.tmp_avatar = "https://ui-avatars.com/api/?name="+data_form.first_name+' '+data_form.last_name;
                SERVICE.register(data_form, function(resp){
                    if(resp.status === 200){
                        COMMON.username = data_form.username;
                        $("#login").removeClass('show-modal');
                        $("#veriry-email").addClass('show-modal');
                        $("#validation-info").html(resp.message);
                    }else{
                        $(".signup-error").html(resp.message);
                    }
                })
            }
        })
        $(document).on("submit", "#form_forget_password", function(e){
            e.preventDefault();
            var email = $("#forget_pw_email").val();
            if(email==undefined || email == null || email==''){
                $("#forget-password-error").html(lang.missing_email);
                return false;
            }
            
            var params = {
                email: email
            }
            SERVICE.forgot_password(params, function(resp){
                if(resp.status==200){
                    $("#modal-forget-password").modal('hide');
                    bootbox.alert({
                        title: lang.check_your_email,
                        message: resp.message,
                        className: "all4learn-bootbox-notification",
                        size: "sm",
                        buttons: {
                            ok: {
                                label: lang.complete
                            }
                        }
                    })
                }else{
                    $("#forget-password-error").html(resp.message);
                }
            })
            
        })
        $(document).on("submit", "#form_reset_forget_password", function(e){
            var password = $("#reset_forget_password").val();
            var password_confirm = $("#reset_forget_password_confirm").val();
            var validate = true;
            $("#form_reset_forget_password .error").html('');
            $("#form_reset_forget_password input").removeClass('error');
            if(password==undefined || password == null || password ==''){
                $("#grp-forget-reset-password input").addClass('error');
                $("#grp-forget-reset-password .error").html(lang.missing_password);
                validate = false;
            }else if(password.length<8){
                $("#grp-forget-reset-password input").addClass('error');
                $("#grp-forget-reset-password .error").html(lang.error_password);
                validate = false;
            }
            if(password_confirm==undefined || password_confirm==null || password_confirm==''){
                $("#grp-forget-reset-password-confirm input").addClass('error');
                $("#grp-forget-reset-password-confirm .error").html(lang.missing_password);
                validate = false;
            }else if(password_confirm!=password){
                $("#grp-forget-reset-password-confirm input").addClass('error');
                $("#grp-forget-reset-password-confirm .error").html(lang.new_password_does_not_match);
                validate = false;
            }
            if(!validate){
                e.preventDefault();
            }
        })
        $(document).on("change", "#inp-avatar", function(){
            var input = $(this)[0];
            if (input.files != undefined && input.files!=null && input.files!='') {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('#preview-avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        })
        $(document).on("mouseenter", ".n-dropdown-content", function(){
            $(this).css("display",'');
        })
        $(document).ready(function(){
             $('.lesson-slider').slick({
                  dots: false,
                  infinite: false,
                  speed: 300,
                  slidesToShow: 3,
                  centerMode: false,
                  variableWidth: false,
                  arrows: true,
                  responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                  ]
                });
        })
        
    },
    logout: function(){
        SERVICE.logout(function(resp){
            COMMON.setCookie('currentuser', '', 0);
            COMMON.currentuser = '';
            COMMON.redirect_to_landing();
        })
    },
    get_profile: function(){
        SERVICE.get_profile(function(resp){
            if(resp.status == 200){
                var obj_user= COMMON.parse_user_info(resp.params);
                COMMON.currentuser = obj_user;
            }else if(resp.status == 600){
                COMMON.setCookie('currentuser', '', 0);
                location.reload();
            }
        })
    },
    start_personal_setting:function(){
        $('#signup-success').removeClass('show-modal'); 
        $("#update-profile").addClass('show-modal'); 
    },
    resend_verify_code: function(){
        console.log(COMMON.currentuser);
        var data_form = {
            username: COMMON.currentuser['username'],
            //school_id: 0,   // self register
        }
        SERVICE.resend_email(data_form, function(resp) {
            if(resp.status === 200){
                $(".validation-code").val('');
            }
        })
    },
    validate_register_form: function(data_form){
        var validate     = true;
        $("#form-register input").removeClass("error");
        $("#form-register .error-msg").html('');

        if(data_form.username==undefined || data_form.username==null || data_form.username==''){
            $("#form-register .grp-username input").addClass("error");
            $("#form-register .grp-username .error-msg").html(lang.missing_username);
            validate = false;
        }
        else if(data_form.username.length<6 || data_form.username.length>255 || COMMON.regex_special_char.test(data_form.username)){
            $("#form-register .grp-username input").addClass("error");
            $("#form-register .grp-username .error-msg").html(lang.error_username);
            validate = false;
        }

        if(data_form.name==undefined || data_form.name==null || data_form.name==''){
            $("#form-register .grp-name input").addClass("error");
            $("#form-register .grp-name .error-msg").html(lang.missing_name);
            validate = false;
        }
        else if(data_form.name.length>255){
            $("#form-register .grp-name input").addClass("error");
            $("#form-register .grp-name .error-msg").html(lang.error_name);
            validate = false;
        }

        if(data_form.phone_number==undefined ||data_form.phone_number==null || data_form.phone_number==''){
            $("#form-register .grp-phone-number input").addClass("error");
            $("#form-register .grp-phone-number .error-msg").html(lang.missing_phone_number);
            validate = false;
        }else if(data_form.phone_number.length<6 || !COMMON.regex_phone.test(data_form.phone_number)){
            $("#form-register .grp-phone-number input").addClass("error");
            $("#form-register .grp-phone-number .error-msg").html(lang.error_phone_number);
            validate = false;
        }

        if(data_form.password==undefined ||data_form.password==null || data_form.password==''){
            $("#form-register .grp-password input").addClass("error");
            $("#form-register .grp-password .error-msg").html(lang.missing_password);
            validate = false;
        }
        else if(data_form.password.length<8 || data_form.password.length>255){
            $("#form-register .grp-password input").addClass("error");
            $("#form-register .grp-password .error-msg").html(lang.error_password);
            validate = false;
        }
        
        if(data_form.email==undefined ||data_form.email==null || data_form.email==''){
            $("#form-register .grp-email input").addClass("error");
            $("#form-register .grp-email .error-msg").html(lang.missing_email);
            validate = false;
        }else if(!COMMON.regex_email.test(data_form.email)){
            $("#form-register .grp-email input").addClass("error");
            $("#form-register .grp-email .error-msg").html(lang.error_email);
            validate = false;
        }
        return validate; 
    },
    watch_validation_code: function(element){
        var validation_code = [];
        var updated = false;
        if($(element).val()!=''){
            var this_id = $(element).attr('id').split('-');
            var next_id = parseInt(this_id[this_id.length-1])+1;
            $('#code-'+next_id).focus();
        }

        $("input[name='validation_code[]']").each(function(index) {
            var item = $(this).val();
            if(item!=''){
                validation_code.push(item);
                if(item!=COMMON.current_validation_code[index]){
                    updated = true;
                }
            }
        });
        if(validation_code.length==4 && updated){
            COMMON.current_validation_code = validation_code;
            var data_form = {
                register_code: validation_code.join(''),
                username: COMMON.username
            }
            if(COMMON.is_login_w_invitation == true || COMMON.is_register_w_invitation == true){
                var url = new URL(window.location.href);
                var username_link = url.searchParams.get("email");
                var school_id_link = url.searchParams.get("school_id");
                var school_code_link = url.searchParams.get("school_code");
                var role_id_link = url.searchParams.get("role_id");
                data_form.username_link = username_link;
                data_form.school_id_link = school_id_link;
                data_form.role_id_link = role_id_link;
                data_form.school_code = school_code_link;
            }
            SERVICE.confirm_register(data_form, function(resp){
                if(resp.status === 200){
                    var params = {
                        username: COMMON.currentuser.username,
                        password: COMMON.currentuser.password
                    }
                    $("#veriry-email").removeClass('show-modal');
                    SERVICE.login(params, function(resp){
                        if(resp.status === 200){
                            $("#login").removeClass('show-modal');
                            var member = resp.params.MemberLoginMethod;
                            var obj_user= COMMON.parse_user_info(resp.params);
                            // COMMON.setCookie('currentuser', JSON.stringify(obj_user), 30);
                            COMMON.currentuser = obj_user;
                            COMMON.token = obj_user.token;
                            if(COMMON.is_login_w_invitation){
                                COMMON.get_profile();
                            }
                            if(obj_user.avatar=='' ){
                                $("#preview-avatar").attr("src", obj_user.tmp_avatar);
                            }
                            if(obj_user.nick_name==''){
                                $("#update-profile").addClass('show-modal');
                            }
                            if(obj_user.avatar=='' && obj_user.nick_name!=''){
                                $("#update-profile").addClass('show-modal');
                                $("#update-avatar-step").css("display", "block");
                                $("#update-nickname-step").css("display", "none");
                            }
                            if(obj_user.nick_name!='' && obj_user.avatar!=''){
                                if(typeof SCHOOL_WELCOME!== 'undefined'){
                                    if(SCHOOL_WELCOME.mark_apply_now){
                                        // $('#modal-school-application').modal({'backdrop': 'static'});
                                        // return false;
                                        if(COMMON.currentuser['role_id'].indexOf(100)!=-1){
                                            $('#modal-school-application').modal({'backdrop': 'static'});
                                            return false;
                                        }else{
                                            location.reload();
                                        }
                                    }
                                }
                                COMMON.redirect_to_landing();  
                            }
                        }else{
                            if(resp.status==901){
                                $(".form-login .grp-username input").addClass("error");
                                $(".form-login .grp-username .error-msg").html(resp.message);
                            }else if(resp.status==902){
                                $(".form-login .grp-password input").addClass("error");
                                $(".form-login .grp-password .error-msg").html(resp.message);
                            }else if(resp.status==903){
                                $("#login").removeClass("show-modal");
                                $("#veriry-email").addClass('show-modal');
                                $("#validation-info").html(resp.message);
                            }else{
                                $(".login-error").html(resp.message);
                            }
                        }
                    })
                }else{
                    bootbox.alert(resp.message);
                    $(".validation-code").addClass('error');
                    $(".validation-code").val('');
                }
            })
        }
    },
    parse_user_info: function(data){
        var MemberLoginMethod = data.MemberLoginMethod;
        var keep_obj = {
            token: MemberLoginMethod.token,
            login_method_id: MemberLoginMethod.login_method_id,
        }
        if(MemberLoginMethod.login_method_id == 900002 || MemberLoginMethod.login_method_id == 900001){
            keep_obj.access_token = MemberLoginMethod.access_token;
        }
        var obj_user = {
            username: MemberLoginMethod.username,
            name: MemberLoginMethod.name,
            token: MemberLoginMethod.token,
            login_method_id: MemberLoginMethod.login_method_id,
            community: [],
            role_id: [],
            avatar: '',
            role: ''
        };
        var Member = data.Member;
        obj_user.nick_name = MemberLoginMethod.display_name;
        if(Member.MemberImage.length>0){
            for(var i=0; i<Member.MemberImage.length; i++){
                if(Member.MemberImage[i].image_type_id==2){
                    obj_user.avatar = COMMON.base_api_url+Member.MemberImage[i].path;
                    break;
                }
            }
        }
        if(Member.MemberLanguage.length>0){
            var member_lang = Member.MemberLanguage[0];
            obj_user.name = member_lang.name;
            obj_user.first_name = member_lang.first_name;
            obj_user.last_name = member_lang.last_name;
            if(obj_user.last_name=='' && obj_user.first_name ==''){
                obj_user.full_name = MemberLoginMethod.username;
            }else{
                obj_user.full_name = member_lang.last_name + ' '+member_lang.first_name;
            }
        }
        if(obj_user.avatar==''){
            obj_user.tmp_avatar = "https://ui-avatars.com/api/?name="+obj_user.full_name;
        }
        for($i=0;$i<Member.MemberRole.length; $i++){
            obj_user.role_id.push(parseInt(Member.MemberRole[$i].role_id));
        }
        // if(Member.community!=undefined && Member.community!=null && Member.community!=''){
        //     if(Member.community.length>0){
        //         // obj_user.community = Member.community;
        //         for(var i=0;i<Member.community.length; i++){
        //             var item_update = {
        //                 id: Member.community[i]['id'],
        //                 school_code: Member.community[i]['school_code'],
        //                 name: Member.community[i]['name'],
        //             };
        //             obj_user.community.push(item_update);
        //         }
        //     }
        // }
        // if(Member.MemberRole.length>0){
        //     obj_user.member_role = Member.MemberRole;
        // }
        COMMON.setCookie('currentuser', JSON.stringify(keep_obj), 30);
        return obj_user;
    },
    skip_update_profile: function(attribute){
        if(attribute=='nick_name'){
            COMMON.currentuser.nick_name = '';
            // COMMON.setCookie('currentuser', JSON.stringify(COMMON.currentuser), 30);
            document.getElementById('update-avatar-step').style.display='block';
            document.getElementById('update-nickname-step').style.display='none';
        }else{
            COMMON.currentuser.avatar = '';
            COMMON.currentuser.tmp_avatar = "https://ui-avatars.com/api/?name="+COMMON.currentuser.full_name;
            // COMMON.setCookie('currentuser', JSON.stringify(COMMON.currentuser), 30);
            if(typeof SCHOOL_WELCOME!== 'undefined'){
                if(SCHOOL_WELCOME.mark_apply_now){
                    if(COMMON.currentuser['role_id'].indexOf(100)!=-1){
                         $('#modal-school-application').modal({'backdrop': 'static'});
                        return false;
                    }else{
                        location.reload();
                    }
                }
            }
            if(COMMON.is_register_w_invitation == true || COMMON.is_login_w_invitation == true){
                COMMON.redirect_to_landing();
            }else{
                location.reload();
            }
        }
        
    },
    update_profile_by_attr: function(attribute){
        var form_data = new FormData();  
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);
        if(attribute=='nickname'){
            form_data.append('nick_name',  $("#inp-nickname").val());
            COMMON.currentuser.nick_name = $("#inp-nickname").val();
            SERVICE.update_profile(form_data, function(resp){
                if(resp.status === 200){
                    document.getElementById('update-avatar-step').style.display='block';
                    document.getElementById('update-nickname-step').style.display='none';
                }else{
                    bootbox.alert(resp.message);
                }
            })
        }else if(attribute=='avatar'){
            // var form_data = new FormData();    
            var file = $("#inp-avatar").prop('files')[0];
            if(file==undefined || file==null || file==''){
                $("#update-profile").removeClass('show-modal');
                COMMON.redirect_to_landing();
            }           
            form_data.append('avatar',  file);
            // form_data.append('token',  COMMON.token);
            // form_data.append('language',  COMMON.cfg_lang);
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#preview-avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(file); // convert to base64 string
            SERVICE.update_profile(form_data, function(resp){
                if(resp.status == 200){
                    COMMON.currentuser.avatar = COMMON.base_api_url+resp.params;
                    if(resp.params==''){
                        COMMON.currentuser.tmp_avatar = "https://ui-avatars.com/api/?name="+COMMON.currentuser.full_name;
                    }
                    $("#update-profile").removeClass('show-modal');
                    if(typeof SCHOOL_WELCOME!== 'undefined'){
                        if(SCHOOL_WELCOME.mark_apply_now){
                            // $('#modal-school-application').modal({'backdrop': 'static'});
                            // return false;
                            if(COMMON.currentuser['role_id'].indexOf(100)!=-1){
                                 $('#modal-school-application').modal({'backdrop': 'static'});
                                return false;
                            }else{
                                location.reload();
                            }
                        }
                    }
                    if(COMMON.is_register_w_invitation == true || COMMON.is_login_w_invitation == true){
                        COMMON.redirect_to_landing();
                    }else{
                        location.reload();
                    }
                }else{
                    bootbox.alert(resp.message);
                }
            })
        }
    },
    redirect_to_landing: function(){
        window.location = COMMON.base_url;
    },
    trigger_choose_avatar: function(){
        $("#inp-avatar").click();
    },
    setCookie: function(cname, cvalue, exdays) {
      var d = new Date();
      // console.log(cname, cvalue);
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+ d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    getCookie: function(cname) {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return decodeURIComponent(c.substring(name.length, c.length));
        }
      }
      return "";
    },
    dynamicallyLoadScript: function(url) {
        var script = document.createElement("script"); //Make a script DOM node
        script.src = url; //Set it's src to the provided URL
        document.head.appendChild(script);
    },
    trigger_form_login: function(form_type) {
        $("#login").addClass('show-modal');
        // document.getElementById('login').style.display='block';
        $("#form-register").trigger("reset");
        $("#form-login").trigger("reset");
        $("#login input").removeClass("error");
        $("#login .error-msg").html("");
        if(form_type=='login'){
            $(".active-register").addClass("hidden");
            $(".active-login").removeClass("hidden");
        }else{
            $(".active-login").addClass("hidden");
            $(".active-register").removeClass("hidden");
        }
    },
    show_menu: function(menu_id) {
        if(menu_id!="#user-pane"){
            $(".user-pane").css('display', 'block');
            $(menu_id).removeClass('hidden');
            $("#user-pane").addClass('hidden');
        }else{
            $("#user-pane").removeClass('hidden');
            $(".user-pane").css('display', '');
            if(!$("#support-pane").hasClass("hidden")){
                $("#support-pane").addClass('hidden');
            }
            if(!$("#language-pane").hasClass("hidden")){
                $("#language-pane").addClass('hidden');
            }
        }
    },
    invitation_code_login: function(){
        COMMON.is_register_w_invitation = false;
        COMMON.is_login_w_invitation    = true;
        $("#invitation-request-login").removeClass('show-modal');
        COMMON.trigger_form_login('login');
        // var url_string = window.location.href; //window.location.href
        // var url = new URL(url_string);
        // var c = url.searchParams.get("c");
        // console.log(c);
    },
    invitation_code_register: function(){
        COMMON.is_register_w_invitation = true;
        COMMON.is_login_w_invitation    = false;
        $("#invitation-request-login").removeClass('show-modal');
        COMMON.trigger_form_login('register');
    },
    back_to_invitation: function(){
        COMMON.is_register_w_invitation = false;
        COMMON.is_login_w_invitation    = false;
        $("#invitation-request-login").addClass('show-modal');
        $("#login").removeClass('show-modal');
    },
    close_invitation: function(){
        $("#invitation-request-login").removeClass("show-modal");
        window.location = COMMON.base_url;
    },
    close_login_form: function(){
        $("#login").removeClass('show-modal');
        if(COMMON.is_register_w_invitation || COMMON.is_login_w_invitation){
            window.location = COMMON.base_url;
        }
    },
    get_end_time: function(start_date, duration_hours, duration_minutes){
        var date = new Date(start_date);
        var duration_time = duration_hours*60 + parseInt(duration_minutes);
        date.setMinutes(date.getMinutes() + duration_time);
        return date;
    },
    download_all: function(zip_fileName){
        var tdate  = new Date();
        COMMON.zip = new JSZip();
        var month = parseInt(tdate.getMonth()) +1;
        zip_fileName += '_'+ tdate.getFullYear() + month + tdate.getDate() + tdate.getHours() + tdate.getMinutes()+ tdate.getSeconds();
        zip_fileName += '.zip';
        //COMMON.currentuser['nick_name']+"-"+tdate.getTime()+".zip"
        COMMON.zip_fileName = zip_fileName;
        COMMON.list_downloadable = [];
        COMMON.list_downloadable_name = [];

        COMMON.count_downloaded = 0;

        $( ".downloadable" ).each(function( index ) {
            var id = $(this).attr('id').split('-');
            id = id[id.length-1];
            var index_exclude = COMMON.excluded_ids.indexOf(id);
            var index_include = COMMON.included_ids.indexOf(id);
            if(COMMON.select_all){
                if(index_exclude==-1){
                    COMMON.list_downloadable.push($(this).attr('href'));
                    COMMON.list_downloadable_name.push($(this).attr('download'));
                }
            }else{
                if(index_include!=-1){
                    COMMON.list_downloadable.push($(this).attr('href'));
                    COMMON.list_downloadable_name.push($(this).attr('download'));
                }
            }
        });

        if(COMMON.list_downloadable.length==0){
            bootbox.alert(lang.no_file_to_download);
            return false;
        }

        $("#loadingDiv").css("display","block");

        COMMON.downloadFile(COMMON.list_downloadable[COMMON.count_downloaded], COMMON.onDownloadComplete);

    },
    urlToPromise: function(url){
        return new Promise(function(resolve, reject) {
            JSZipUtils.getBinaryContent(url, function (err, data) {
                if(err) {
                    reject(err);
                } else {
                    resolve(data);
                }
            });
        });
    },
    downloadFile : function(url, onSuccess) {
        // console.log(url, 'url');
        var xhr = new XMLHttpRequest();
        // xhr.onprogress = calculateAndUpdateProgress;
        xhr.open('GET', url, true);
        xhr.responseType = "blob";

        xhr.onreadystatechange = function () {
          // In local files, status is 0 upon success in Mozilla Firefox
          if(xhr.readyState === XMLHttpRequest.DONE) {
            var status = xhr.status;
            if (status === 0 || (status >= 200 && status < 400)) {
              // The request has been completed successfully
              // console.log(onSuccess, 'onSuccess');
              onSuccess(xhr.response);

            } else {
              // Oh no! There has been an error with the request!
            }
          }
        };
        xhr.send();
    },
    onDownloadComplete: function(blobData){
        // console.log(COMMON.count_downloaded, 'count_downloaded');
        if (COMMON.count_downloaded < COMMON.list_downloadable.length) {
            COMMON.blobToBase64(blobData, function(binaryData){
                    // add downloaded file to zip:
                    var fileName = COMMON.list_downloadable_name[COMMON.count_downloaded];
                    COMMON.zip.file(fileName, binaryData, {base64: true});
                    
                    if (COMMON.count_downloaded < (COMMON.list_downloadable.length -1)){
                        COMMON.count_downloaded++;
                        COMMON.downloadFile(COMMON.list_downloadable[COMMON.count_downloaded], COMMON.onDownloadComplete);
                    }
                    else {
                        COMMON.zip.generateAsync({type:"blob"}).then(function (zipFile) {
                            $("#loadingDiv").css("display","none");
                            saveAs(zipFile, COMMON.zip_fileName);
                        });
                    }
                });
        }else{

        }
    },
    blobToBase64: function(blob, callback) {
        var reader = new FileReader();
        reader.onload = function() {
            var dataUrl = reader.result;
            var base64 = dataUrl.split(',')[1];
            callback(base64);
        };
        reader.readAsDataURL(blob);
    },
    toggle_all_id: function(){
        COMMON.select_all = !COMMON.select_all;
        COMMON.included_ids = [];
        COMMON.excluded_ids = [];
        if(COMMON.select_all){
            $(".select_id").prop('checked', true);
        }else{
            $(".select_id").prop('checked', false);
        }
    },
    toggle_id: function(id){
        var index_include = COMMON.included_ids.indexOf(id);
        var index_exclude = COMMON.excluded_ids.indexOf(id);
        var lst_length = $(".select_id").length;

        if(COMMON.select_all){
            if(index_exclude==-1){
                COMMON.excluded_ids.push(id);
            }else{
                COMMON.excluded_ids.splice(index_exclude, 1);
            }
        }else{
            if(index_include==-1){
                COMMON.included_ids.push(id);
            }else{
                COMMON.included_ids.splice(index_include, 1);
            }
        }
    },
    toggle_modal: function(element){
        $("#"+element).toggleClass('show-modal');
    },
    reposition_modal: function(){
        var modal = $(this),
        dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    },
    minimal_name: function(name){
        var short_name = '';
        if(name!=undefined && name!=null && name!=''){
            var matches = name.match(/\b(\w)/g);
            short_name = matches.join(''); 
        }
        return short_name;
    },
    reset_form: function(){
        $("form").trigger('reset');
    },
    validation_file: function(file){
        var f_extension = file.name.split('.').pop();
        if(COMMON.lst_material_extension_allowed.indexOf(f_extension)==-1) return false;
        if(file.size>COMMON.max_upload_file) return false;
        return true;
    },
    auto_grow_textarea: function(element){
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }
}

