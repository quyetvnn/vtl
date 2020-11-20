var SCHOOL_GROUP = {
	validation_form_create_group: '',
	is_create_group: false,
	group_id: '',
	init_page: function(){
		SCHOOL_GROUP.validation_form_create_group = $("#form-create-group").validate({
			 rules: {
		        group_name: {
		        	required: true,
		        }
		    },
		    messages: {
		        group_name: {
		        	required: lang.missing_name
		        },
		    },
		    invalidHandler: function(e, validator){
	            $('#btn-submit-create-group').prop("disabled", true);
	        },
	        success: function(){
	        	$('#btn-submit-create-group').prop("disabled", false);
	        }
		})
		$(document).on('show.bs.modal', '#modal-create-group', function(){
			if(!SCHOOL_GROUP.is_create_group){
				SCHOOL_GROUP.reset_form();
				SCHOOL_GROUP.is_create_group = true;
			}else{
				if(typeof SCHOOL_CATEGORY!== 'undefined' && SCHOOL_CATEGORY.lastest_created_category){
					var ele = $('#select-a4l-category').append("<option value='"+SCHOOL_CATEGORY.lastest_created_category.id+"' selected>"+SCHOOL_CATEGORY.lastest_created_category.text+"</option>");
	      		}
			}
		})
		
		$(document).on('submit', '#form-create-group', function(e){
			e.preventDefault();
			var params={
				name: $("input[name='group_name']").val(),
				school_id: SCHOOL_COMMON.school_id,
				category_id: $("#select-a4l-category").val()
			}
			SERVICE.create_group(params, function(resp){
				if(resp.status==200){
					$("#modal-create-group").modal('hide');
				}
				bootbox.alert(resp.message, function(){
                    if(resp.status==200){
                    	location.reload();
                    }else{
                    	$("#create_category_error").html(resp.message);
                    }
                })
			})
		})
	},
	init_table_teacher: function(group_id){
		SCHOOL_GROUP.group_id = group_id;
		$("#table_teacher_group").dataTable().fnDestroy();
	    $('#table_teacher_group').DataTable({
	        "processing": true,
	        "serverSide": true,
	        "lengthMenu": [ 6 ],
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
	                "className": "group-img-radius pointer ",
	                render: function(data, type, row, meta){
	                	var grp_name = '';
	                	grp_name += '<div class="box-img border-grey " >';
	                	if(row['avatar']){
	                		grp_name += '<img class="profile-image" src = "'+COMMON.base_url+row['avatar']+'" />';
	                	}else{
	                		grp_name += '<span class="default-text-avatar">';
	                		grp_name += COMMON.minimal_name(data);
	                		grp_name += '</span>';
	                	}
	                	
	                	grp_name += '</div>';
	                	return grp_name;
	                }
	            },
	            {
	                "targets": 1,
	                "data": "username",
	                "className": "text-center",
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
				    "<'row m-0'<'col-sm-12 p-0' t>>" +
				    "<'row m-0'<'col-sm-12 flex-end a4l-pagination p-0' p>>"
	    });
	},
	reset_form: function(){
		$("#form-create-group").trigger('reset');
		$("#dataPicker").selectpicker("refresh");
		SCHOOL_GROUP.validation_form_create_group.resetForm();
		$("#form-create-group .form-control").removeClass('error');
	},
}