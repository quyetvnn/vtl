var SERVICE = {
    create_group: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+"api/school/schools_groups/add_item.json",
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    create_catgory: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+"api/school/schools_categories/add_item.json",
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    edit_member: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+"api/member/members/edit_member.json",
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    import_member: function(params, handleData){
        $.ajax({
            url: COMMON.base_api_url+"api/member/members/import_member.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(resp){
                handleData(resp)
            },
            error: function(error){}
        })
    },
    create_member: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+"api/member/members/create_member.json",
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    get_member_school_by_id: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+"api/member/members/get_member_school_by_id.json",
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    login_social_method: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+"api/member/member_login_methods/login_social_method.json",
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    
    use_link_reset_password: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/use_link_reset_password.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    forgot_password: function(params, handleData){
        COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/forgot_password.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
    },
    teacher_update_assignment: function(params, handleData){
        $.ajax({
            url: COMMON.base_api_url+"api/member/teacher_create_lessons/teacher_update_assignment.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(resp){
                handleData(resp)
            },
            error: function(error){}
        })
    },
	get_school_by_id: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/school/schools/get_school_by_id.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	edit_school: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/school/schools/edit_school.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(resp){
                handleData(resp)
            },
            error: function(error){}
        })
	},
	create_school: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/school/schools/create_school.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(resp){
                handleData(resp);
            },
            error: function(error){}
        })
	},
	add_pay_dollar: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/payment/pay_dollars/add_pay_dollar.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	student_submit_assignment: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/member/teacher_create_lessons/student_submit_assignment.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            beforeSend: function(){},
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){},
            complete: function(){}
        })
	},
	register: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/register.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert(lang.error_connection);
            }
        })
	},
	reset_password: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/reset_password.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert(lang.error_connection);
            }
        })
	},
	logout: function(handleData){
		var params={};
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/logout.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
            	bootbox.alert(lang.error_connection);
            }
        })
	},
	get_profile: function(handleData){
		var params={};
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/get_profile.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
            	 bootbox.alert(lang.error_connection);
            }
        })
	},
	resend_email: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/members/resend_email.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert(lang.error_connection);
            }
        })
	},
	login: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/login.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	confirm_register: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/confirm_register.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	update_profile: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/member/members/update_profile.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            beforeSend: function(){},
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            },
            complete: function(){}
        })
	},
	teacher_create_assignment: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/member/teacher_create_lessons/teacher_create_assignment.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            beforeSend: function(){},
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){},
            complete: function(){}
        })
	},
	update_lesson: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/member/teacher_create_lessons/update_lesson.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            beforeSend: function(){},
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            },
            complete: function(){}
        })
	},
	add_lesson: function(params, handleData){
		$.ajax({
            url: COMMON.base_api_url+"api/member/teacher_create_lessons/add_lesson.json",
            type: "POST",
            data: params,
            dataType: "JSON",
            contentType: false,
            processData: false,
            beforeSend: function(){

            },
            success: function(resp){
                handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            },
            complete: function(){

            }
        })
	},
	get_list_class_by_school_id: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/school/school_classes/get_list_class_by_school_id.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	get_list_teacher: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/member_login_methods/get_list_teacher.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	get_list_subject_by_school_id: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/school/school_subjects/get_list_subject_by_school_id.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	},
	get_submission_count_by_assignment_id: function(assignment_id, handleData){
		if(assignment_id!=undefined && assignment_id!=null && assignment_id!=''){
			var params = {
				teacher_create_assignment_id: assignment_id
			}
			COMMON.call_ajax({
	            url: COMMON.base_api_url+'api/member/teacher_create_lessons/get_submission_count_by_assignment_id.json',
	            type: 'POST',
	            data: params,
	            dataType: 'json',
	            success: function(resp){
	            	handleData(resp);
	            },
	            error: function(error){
	                bootbox.alert("Connection error!");
	            }
	        })
		}
	},
	teacher_delete_assignment: function(params, handleData){
		COMMON.call_ajax({
            url: COMMON.base_api_url+'api/member/teacher_create_lessons/teacher_delete_assignment.json',
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(resp){
            	handleData(resp);
            },
            error: function(error){
                bootbox.alert("Connection error!");
            }
        })
	}
}