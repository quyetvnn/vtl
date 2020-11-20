var SCHOOL_COMMON = {
	data_school: [],
	school_id: '',
    cfg_role:{
        1: {
            class: 'role text-blue-light border-blue-light' 
        },
        2: {
            class: 'role text-green border-green'
        },
        3: {
            class: 'role text-green border-green'
        } 
    },
	init_page: function(school_id){
		SCHOOL_COMMON.school_id = school_id;
		SCHOOL_COMMON.data_school = {
            about_us: $("#frm-edit-school #school_about").val(),
            phone_number: $("#frm-edit-school #school_phone_number").val(),
            email: $("#frm-edit-school #school_email").val(),
            address: $("#frm-edit-school #school_address").val(),
            id: SCHOOL_COMMON.school_id
        }
		/*Begin Update logo*/
        $(document).on('click', '#trigger_update_logo', function(){
            $("#update_logo").click();
        })
        $(document).on('change', '#update_logo', function(e){
            var input = $(this)[0];
            if (input.files != undefined && input.files!=null && input.files!='') {
                SCHOOL_COMMON.data_school.logo0 = input.files[0];
                SCHOOL_COMMON.submit_edit_school(SCHOOL_COMMON.data_school);
            }
        })
        /*End Update logo*/

        /*Begin Update banner*/
        $(document).on('click', '#trigger_update_banner', function(){
            $("#update_banner").click();
        })
        $(document).on('change', '#update_banner', function(e){
            var input = $(this)[0];
            if (input.files != undefined && input.files!=null && input.files!='') {
                SCHOOL_COMMON.data_school.banner0 = input.files[0];
                SCHOOL_COMMON.submit_edit_school(SCHOOL_COMMON.data_school);
            }
        })
        /*End Update banner*/
	},
	submit_edit_school: function(data){
        var form_data   = new FormData();
        form_data.append('token',  COMMON.token);
        form_data.append('language',  COMMON.cfg_lang);
        for (var key in data) {
            form_data.append(key, data[key]);
        }
        SERVICE.edit_school(form_data, function(resp){
            if(resp.status == 200){
                $('#modal-school-edit').modal('hide');
                location.reload();
            }else{
                bootbox.alert(resp.message);
                $("#frm-crt-school .grp_error .error-msg").html(resp.message);
            }
        })
    },
}