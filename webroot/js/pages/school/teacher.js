var TEACHER = {
	school_id: '',
	member_id: '',
	validator_form_create_member: '',
	validator_form_edit_member: '',
	teacher_paging: {},
	init_page: function(){
		TEACHER.init_teacher_table_list();
		TEACHER.validator_form_create_member = $("#form-create-member").validate({
		    rules: {
		        member_roles: {
		        	required: true,
		        },
		        member_username: {
		        	required: true,
		            minlength: 6,
		            maxlength: 255,
		            unregex: COMMON.regex_special_char
		        },
		        member_password: {
		            required: true,
		            minlength: 8,
		            maxlength: 255,
		        },
		        member_name: {
		        	required: true,
		            maxlength: 255
		        },
		        member_email: {
		        	required: true,
		            regex: COMMON.regex_email
		        },
		        member_phone_number: {
		        	required: true,
		            minlength: 6,
		            regex: COMMON.regex_phone
		        }
		    },
		    messages: {
		        member_roles: {
		        	required: lang.missing_role
		        },
		        member_username: {
		        	required: lang.missing_username,
		        	minlength: lang.error_username,
		        	maxlength: lang.error_username,
		        	unregex: lang.error_username
		        },
		        member_password: {
		            required: lang.missing_password,
		            minlength: lang.error_password,
		            maxlength: lang.error_password
		        },
		        member_name: {
		        	required: lang.missing_name,
		        	maxlength: lang.error_name
		        },
		        member_email: {
		        	required: lang.missing_email,
		        	regex: lang.error_email
		        },
		        member_phone_number: {
		        	required: lang.missing_phone_number,
		        	minlength: lang.error_phone_number,
		            regex: lang.error_phone_number
		        }
		    }
		});
		TEACHER.validator_form_create_member = $("#form-edit-member").validate({
		    rules: {
		        current_roles: {
		        	required: true,
		        },
		        current_name: {
		        	required: true,
		            maxlength: 255
		        },
		        current_email: {
		        	required: true,
		            regex: COMMON.regex_email
		        },
		        current_phone_number: {
		        	required: true,
		            minlength: 6,
		            regex: COMMON.regex_phone
		        }
		    },
		    messages: {
		        current_roles: {
		        	required: lang.missing_role
		        },
		        current_name: {
		        	required: lang.missing_name,
		        	maxlength: lang.error_name
		        },
		        current_email: {
		        	required: lang.missing_email,
		        	regex: lang.error_email
		        },
		        current_phone_number: {
		        	required: lang.missing_phone_number,
		        	minlength: lang.error_phone_number,
		            regex: lang.error_phone_number
		        }
		    }
		});
		// $(document).on("click", "#trigger_export", function(){
		// 	$("#submit_export_teacher").click();
		// })
		$(document).on('show.bs.modal', '#modal-create-member', function(){
			TEACHER.reset_form();
		})
		$(document).on('submit', '#form-create-member', function(e){
			e.preventDefault();
			var params = {
				username: $("input[name='member_username']").val(),
				password: $("input[name='member_password']").val(),
				name: $("input[name='member_name']").val(),
				email: $("input[name='member_email']").val(),
				phone_number: $("input[name='member_phone_number']").val(),
				role: JSON.stringify($("#dataPicker").val()),
				school_id: $("input[name='school']").val()
			}
			SERVICE.create_member(params, function(resp){
				if(resp.status==200){
					$("#modal-create-member").modal('hide');
				}
				bootbox.alert(resp.message, function(){
                    if(resp.status==200){
                    	location.reload();
                    }else{
                    	$("#create_member_error").html(resp.message);
                    }
                })
			})
		})
		$(document).on('submit', '#form-edit-member', function(e){
			e.preventDefault();
			var params = {
				name: $("input[name='current_name']").val(),
				email: $("input[name='current_email']").val(),
				phone_number: $("input[name='current_phone_number']").val(),
				role: JSON.stringify($("#current_roles").val()),
				member_id: TEACHER.member_id,
				school_id: TEACHER.school_id
			}
			SERVICE.edit_member(params, function(resp){
				console.log(resp, 'resp');
				if(resp.status==200){
					$("#modal-edit-member").modal('hide');
				}
				bootbox.alert(resp.message, function(){
                    if(resp.status==200){
                    	TEACHER.init_teacher_table_list();
                    }else{
                    	$("#edit_member_error").html(resp.message);
                    }
                })
			})
		})
		$(document).on('show.bs.modal', '#modal-import-teacher', function(){
			$("#form-import-teacher").trigger('reset');
		})
		$(document).on('submit', '#form-import-teacher', function(e){
			e.preventDefault();
			var file = $('#file_element');
			if(file[0].files.length==0){
				$("#import_teacher_error").html(lang.missing_file);
				return false;
			}
			var form_data   = new FormData();
	        form_data.append('token',  COMMON.token);
	        form_data.append('language',  COMMON.cfg_lang);
	        form_data.append('school_id',  $("input[name='school']").val());
	        form_data.append('file',  file[0].files[0]);
	        form_data.append('role',  1);
	        SERVICE.import_member(form_data, function(resp){
				if(resp.status==200){
					$("#modal-import-teacher").modal('hide');
				}
				bootbox.alert(resp.message, function(){
                    if(resp.status==200){
                    	location.reload();
                    }else{
                    	$("#import_teacher_error").html(resp.message);
                    }
                })
			})
	        
		})
	},
	init_teacher_table_list: function(){
	    $("#table_school_teachers").dataTable().fnDestroy();
	    $('#table_school_teachers').DataTable({
	        "processing": true,
	        "serverSide": true,
	        "ajax": {
	            "type": "POST",
	            "url": COMMON.base_api_url + 'api/member/member_login_methods/get_member_belong_school_with_role_pagination.json',
	            data: function(params){
	            	var params_api = {
						school_id: SCHOOL_COMMON.school_id,
						token: COMMON.token,
						language: COMMON.cfg_lang,
						role: JSON.stringify([1, 3]),
						limit: params['length'],
						offset: params.start,
						search_text: params.search.value,
					};
	            	return params_api;
	            },
	            dataFilter: function(json){
	            	json = JSON.parse(json);
		            json.recordsTotal = json['params']['content'].length;
		            json.recordsFiltered = json['params']['total'];
		            json.aaData = json['params']['content'];
		            return JSON.stringify(json); 
	            }
	        },
	        "columnDefs": [
	            {
	                "targets": 0,
	                "data": "name",
	                "className": "group-img-radius pointer clearfix ",
	                render: function(data, type, row, meta){
	                	var grp_name = '<a href="javascript:TEACHER.show_teacher_info('+ row['member_id'] +', '+ SCHOOL_COMMON.school_id +')" class="text-dark-liver no-underline">';
	                	grp_name += '<div class="box-img border-grey pull-left " >';
	                	if(row['avatar']){
	                		grp_name += '<img class="profile-image" src = "'+COMMON.base_url+row['avatar']+'" />';
	                	}else{
	                		grp_name += '<span class="default-text-avatar">';
	                		grp_name += COMMON.minimal_name(data);
	                		grp_name += '</span>';
	                	}
	                	grp_name += '</div><div class="addon-text"> <p class="member_name member_roles">';
	                	grp_name += data;
	                	for(var key in row['role']){
	                		grp_name += '<span class="'+SCHOOL_COMMON.cfg_role[key]['class']+'">'+row['role'][key]+'</span>'
	                		;
	                	}
	                	grp_name += '</p></div></a>';
	                	return grp_name;
	                }
	            },
	            {
	                "targets": 1,
	                "data": "username"
	            },
	            {
	                "targets": 2,
	                "className": "text-green text-right",
	                "data": "no",
	                render: function ( data, type, row, meta ) {
	                    return '<span class="fa fa-chevron-right"></span>';
	                }
	            }
	        ],
	        language: { 
	        	search: "",
	        	searchPlaceholder: lang.search,
	        	info: lang.teacher+" (_TOTAL_)",
	        	infoFiltered: "",
	        	paginate:{
	        		next: "<i class='fa fa-long-arrow-right'></i>",
	        		previous: "<i class='fa fa-long-arrow-left'></i>"
	        	}
	        },
	        dom: 	"<'row count-datatable' i>"+
	        		"<'row m-0'<'col-sm-8 p-0' B><'col-sm-4 teacher-searcher flex-end p-0'<'input-w-icon-t' f<'icon icon-search'>>>>" +
				    "<'row m-0'<'col-sm-12 p-0' t>>" +
				    "<'row m-0'<'col-sm-12 flex-end a4l-pagination p-0' p>>",
	        buttons: {
		        buttons: [
		            {
		                text: '<i class="fa fa-plus"></i> '+lang.teacher,
		                className: 'btn btn-w-radius btn-green-o mr-10',
		                width: "25%",
		                action: function ( dt ) {
		                   $("#modal-create-member").modal({'backdrop': 'static'})
		                }
		            },
		            {
		                text: '<i class="fa fa-cloud-upload"></i> '+lang.import_teacher,
		                className: 'btn btn-w-radius btn-green-o mr-10',
		                action: function ( dt ) {
		                     $("#modal-import-member").modal({'backdrop': 'static'})
		                }
		            },
		            {
		                text: '<i class="fa fa-cloud-download"></i> '+lang.export_teacher,
		                className: 'btn btn-w-radius btn-green-o mr-10',
		                action: function ( dt ) {
		                    $("#submit_export_teacher").click();
		                }
		            }
		        ]
		    }
	    });
	},
	reset_form: function(){
		$("#form-create-member").trigger('reset');
		$("#dataPicker").selectpicker("refresh");
		TEACHER.validator_form_create_member.resetForm();
		$("#form-create-member .form-control").removeClass('error');
	},
	edit_member_school_profile: function(){
		var params = {
			member_id: TEACHER.member_id,
			school_id: TEACHER.school_id
		}
		SERVICE.get_member_school_by_id(params, function(resp){
			if(resp.status==200){
				var member = resp.params;
				$("#member_id").val(member_id);
				$("input[name='current_name']").val(member.MemberLanguage[0].name);
				$("input[name='current_email']").val(member.Member.email);
				$("input[name='current_phone_number']").val(member.Member.phone_number);
				var roles = [];
				for(var i=0; i<member.MemberRole.length; i++){
					roles.push(member.MemberRole[i]['role_id']);
				}
				$("#current_roles").selectpicker('val', roles);
				$("#modal-edit-member").modal('show');
			}else{
				bootbox.alert(resp.message);
			}
		})
	},
	show_teacher_info: function(member_id, school_id){
		TEACHER.school_id = school_id;
		TEACHER.member_id = member_id;
		var params = {
			member_id: member_id,
			school_id: school_id
		}
		$("#member-profile-image").attr('src', '').addClass('hidden');
		$("#member-default-text-avatar").html('').addClass('hidden');
		SERVICE.get_member_school_by_id(params, function(resp){
			if(resp.status==200){
				var member = resp.params;
				$("#member_full_name").html(member.MemberLanguage[0].name);
				$("#member_email").html(member.Member.email);
				$("#member_class").html('There is no info about class which teacher is belong to.');

				var member_name = member.Member.nick_name;
				var member_role = "";
				for(var i=0;i<member.MemberRole.length; i++){
					member_role += "<span class='"+SCHOOL_COMMON.cfg_role[member.MemberRole[i].role_id]['class']+"'>"+member.MemberRole[i]['Role']['RoleLanguage'][0]['name']+"</span>";
				}
				$("#member_nick_name").html(member_name+member_role);

				var avatar = '';
				if(member.MemberImage.length>0){
					avatar = COMMON.base_url + member.MemberImage[0].path;
					$("#member-profile-image").attr('src', avatar).removeClass('hidden');
				}else{
					var minimal_name = '';
					if(member_name){
						minimal_name = COMMON.minimal_name(member_name);
					}else{
						minimal_name = COMMON.minimal_name(member.MemberLanguage[0].name);
					}
					$("#member-default-text-avatar").html(minimal_name).removeClass('hidden');
				}

				$("#modal-teacher-info").modal('show');

			}else{
				bootbox.alert(resp.message);
			}
		})
	}
}