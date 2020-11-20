var SCHOOL_CATEGORY = {
	validation_form_create_category: '',
	lastest_created_category: '',
	category_select_paging: {},
	init_page: function(base_api_url){
		COMMON.base_api_url = base_api_url;
		SCHOOL_CATEGORY.category_select_paging = SCHOOL_CATEGORY.init_paging(SCHOOL_CATEGORY.category_select_paging);
		SCHOOL_CATEGORY.validation_form_create_category = $("#form-create-category").validate({
			 rules: {
		        category_name: {
		        	required: true,
		        }
		    },
		    messages: {
		        category_name: {
		        	required: lang.missing_name
		        },
		    },
		    invalidHandler: function(e, validator){
	            $('#btn-submit-create-category').prop("disabled", true);
	        },
	        success: function(){
	        	$('#btn-submit-create-category').prop("disabled", false);
	        }
		})

		$(document).on('show.bs.modal', '#modal-create-category', function(){
			$("#form-create-category").trigger('reset');
			SCHOOL_CATEGORY.validation_form_create_category.resetForm();
			$("#form-create-category .form-control").removeClass('error');
		})

		$('#select-a4l-category').select2({
			width: '100%',
			placeholder: "Select a category",
			ajax: {
				url: COMMON.base_api_url+'api/school/schools_categories/get_item.json',
				type: 'POST',
			    dataType: 'json',
			    beforeSend: function(){
			    	$("#loadingDiv").css("display","none");
			    },
			    data: function (params) {
					var query = {
						token: COMMON.token,
						language: COMMON.cfg_lang,
						search_text: '',
						school_id: SCHOOL_COMMON.school_id,
						
					}
					if(params.term!=undefined && params.term!=null && params.term!=''){
						query.search_text = params.term;
						if(query.search_text!=SCHOOL_CATEGORY.category_select_paging.search_text){
							SCHOOL_CATEGORY.category_select_paging.search_text = params.term;
							SCHOOL_CATEGORY.category_select_paging = SCHOOL_CATEGORY.init_paging(SCHOOL_CATEGORY.category_select_paging);
						}
					}
					query.limit = SCHOOL_CATEGORY.category_select_paging.limit;
					query.offset = SCHOOL_CATEGORY.category_select_paging.offset;
					return query;
			    },
			    processResults: function (data, params) {
			    	var more = false;
			    	var list_option = [];
			    	if(data.status==200){
			    		for(var i=0; i<data.params.content.length; i++){
			    			item = data.params.content[i];
			    			var id =  item.SchoolsCategory.id;
			    			var text = item.SchoolsCategoriesLanguage.name;
			    			list_option.push({id: id, text: text});
			    		}
			    		var paging = SCHOOL_CATEGORY.category_select_paging;
			    		paging.total_item = data.params.total;
			    		paging.current_page++;
				    	paging.offset = paging.current_page * paging.limit;
				    	paging.current_item+=data.params.content.length;
				        if(paging.current_item < paging.total_item){
				          more = true;
				        }
			    		SCHOOL_CATEGORY.category_select_paging = paging;
			    	}
			    	
				    return {
				        results: list_option,
				        pagination: {
				        	 more: more,
				        }
				       
				    };
				}
			}
		})
		.on('select2:open', () => {
			SCHOOL_CATEGORY.category_select_paging = SCHOOL_CATEGORY.init_paging(SCHOOL_CATEGORY.category_select_paging);
		    $(".select2-results:not(:has(a))").append('<a href="javascript:SCHOOL_CATEGORY.trigger_create_category()" class="add-option text-green" style="padding: 6px;height: 20px;display: inline-table;"><i class="fa fa-plus-circle text-green" aria-hidden="true"></i>Create new item</a>');
      	})
		$(document).on('submit', '#form-create-category', function(e){
			e.preventDefault();
			var params={
				name: $("input[name='category_name']").val(),
				school_id: SCHOOL_COMMON.school_id
			}
			SERVICE.create_catgory(params, function(resp){
				if(resp.status==200){
					$("#modal-create-category").modal('hide');
				}
				bootbox.alert(resp.message, function(){
                    if(resp.status==200){
                    	SCHOOL_CATEGORY.lastest_created_category ={id: resp.params.schools_category_id, text: params.name };
                    	if(typeof SCHOOL_GROUP!== 'undefined' && SCHOOL_GROUP.is_create_group){
                    		$("#modal-create-group").modal('show');
                    	}else{
                    		location.reload();
                    	}
                    	
                    }else{
                    	$("#create_category_error").html(resp.message);
                    }
                })
			})
		})
	},
	trigger_create_category: function(){
		$('#select-a4l-category').select2('close');
		$("#modal-create-group").modal('hide');
		$("#modal-create-category").modal('show');
	},
	init_paging: function(params){
		params.total_item 		= 0;
		params.current_item 	= 0;
		params.current_page 	= 0;
		params.offset 			= 0;
		params.limit 			= 10
		return params;
	}
}