var ASSIGNMENT = {
	init_page: function(){

	},
	confirm_delete_assignment: function(assignment_id, assignment_name, assignment_class){
		if(assignment_id!=undefined && assignment_id!=null && assignment_id!=''){
			var params = {
				teacher_create_assignment_id: assignment_id
			}
			SERVICE.get_submission_count_by_assignment_id(params, function(resp){
				if(resp.status === 200){
					if(resp.params!=undefined && resp.params != null && resp.params!=''){
						var submission_count = resp.params.submission_count;
						if(submission_count>0){
							bootbox.confirm( sprintf(lang.confirm_delete_assignment, assignment_name, assignment_class, submission_count) , function(result){
			   					if(result){
			   						SERVICE.teacher_delete_assignment(params, function(resp){
			   							if(resp.status === 200){
			   								location.reload();
			   							}else{
			   								bootbox.alert(resp.message);
			   							}
			   						});
			   					}
							})
						}else if(submission_count==0){
							SERVICE.teacher_delete_assignment(params, function(resp){
								if(resp.status === 200){
									location.reload();
	   							}else{
	   								bootbox.alert(resp.message);
	   							}
							});
						}
					}
	            }else{
	                bootbox.alert(resp.message);
	            }
			})
		}
	},
	
}
