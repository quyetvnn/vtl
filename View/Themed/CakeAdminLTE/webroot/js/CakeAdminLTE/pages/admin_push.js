var ADMIN_PUSH = {
    have_section_object: ['section-brand', 'section-coupon', 'section-menu', 'section-news', 'section-shop'],
    url_get_section_data: '',
    url_get_members: '',
    message_confirm_push_all: '',
    message_must_choose_member: '',
    init_page: function(){
        COMMON.init_element_number($('#txt_phone'));
		// init datetime picker range
        COMMON.init_datetimepicker_range($('#period_start'), $('#period_end'));
        COMMON.init_datetimepicker_range($('#join_from'), $('#join_to'));

        // init datetime for instant
        COMMON.init_datepicker(false);
        COMMON.init_datetimepicker();
        COMMON.init_timepicker("HH:mm:ss");
        COMMON.init_monthdaypicker();

        ADMIN_PUSH.init_autocomplete_member();
        // check type
        ADMIN_PUSH.check_type();

        $('#push_type').on('change',function (){
            ADMIN_PUSH.check_type();
        });
        
        // check push section
        ADMIN_PUSH.check_section();

	    // push method
        ADMIN_PUSH.check_method();
        
		$('#push_method').on('change',function (){
			ADMIN_PUSH.check_method();
		});

        $('#promotion_section').on('change',function (){
            ADMIN_PUSH.check_section();
        });

        $('#confirmSubmission').on('click', function(event) {
            $('.push-to-someone').find('.alert-choose-member').remove();

			var slug = $('#push_method').find("option:selected").data('slug');
	        switch (slug) {
				case 'push-to-all':
		  	    	if(confirm(ADMIN_PUSH.message_confirm_push_all)){
                        $('#push-form').submit();
                    }
                    break;
                case 'push-to-someone':
                    if($('input[name="data[Push][member_token][]"]').length == 0){
                        $('.push-to-someone').prepend('<div class="alert alert-warning alert-choose-member">' +
	                        '<button type="button" class="close" data-dismiss="alert">×</button>' +
	                        ADMIN_PUSH.message_must_choose_member + '</div>');
                    }else{
                        $('#push-form').submit();
                    }
                    break;
				default:
                    $('#push-form').submit();
					break;
			}
        });

        $('#push_company_id').on('change', function(){
            $('.member-autocomplete').val('');
            ADMIN_PUSH.check_section();
        });
    },
    init_autocomplete_member: function(){
        $('.member-autocomplete').autocomplete({
            delay: 500,
            source: function(request, response) {
                if(!$('#push_company_id').val()){
                    alert('Please choose company first');
                    return {};
                }

                var data = {
                    "company_id": $('#push_company_id').val(),
                    "text": request.term,
                    "member_ids": []
                };

                $.each($('.txt-member-token'), function(){
                    data['member_ids'].push($(this).val());
                });

                COMMON.call_ajax({
                    url: ADMIN_PUSH.url_get_members,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(json) {
                        if(json.status == true){
                            response($.map(json.params, function(item, key) {
                                return {
                                    label: item,
                                    value: parseInt(key)
                                }
                            }));
                        }else{
                            return {};
                        }
                    }
                });
            }, 
            select: function(event, ui) {
                $('.member-autocomplete').val('');
                $('.list-member-name').append('<span>' + 
                    ui.item.label + '<i class="fa fa-remove"></i>' +
                    '<input type="hidden" name="data[Push][member_token][]" value="' + ui.item.value + '" class="txt-member-token" />' +
                '</span>');
                $('.push-to-someone').find('.alert-choose-member').remove();
                ADMIN_PUSH.init_remove_member();
                return false;
            },
            focus: function(event, ui) {
                return false;
            }
        });
    },
    init_remove_member: function(){
        $('.list-member-name i').on('click', function(){
            $(this).parent().remove();
        });
    },
    check_type: function() {
        var slug = $('#push_type').find("option:selected").text();
        var value = $('#push_type').val();
        $('.push_type_rules').hide().find('input,select').attr('disabled',true);
        $('.dv-status').show().find('input').prop('checked', true);
        if(value && slug && slug != 'specific_datetime' && slug != 'instant'){
            $('.period_date').show().find('input,select').attr('disabled',false);
        }else{
            $('.period_date').hide().find('input,select').attr('disabled',true);
        }

        if(value){
            switch (slug) {
                case 'specific_datetime':
                    $('.specific_date').show().find('input,select').attr('disabled',false);
                    break;
                case 'daily':
                    $('.execute-time').show().find('input,select').attr('disabled',false);
                    break;
                case 'weekly':
                    $('.dv-weekly').show().find('input,select').attr('disabled',false);
                    $('.execute-time').show().find('input,select').attr('disabled',false);
                    break;
                case 'monthly':
                    $('.dv-monthly').show().find('input,select').attr('disabled',false);
                    $('.execute-time').show().find('input,select').attr('disabled',false);
                    break;
                case 'yearly':
                    $('.dv-yearly').show().find('input,select').attr('disabled',false);
                    $('.execute-time').show().find('input,select').attr('disabled',false);
                    break;
                case 'instant':
                    $('.dv-status').hide().find('input').prop('checked', true);
                    break;
                default:
                    break;
            }
        }
    },
    check_method: function(){
        var slug = $('#push_method').find("option:selected").data('slug');

        $('.push-to-someone').hide().find('.list-member-name').html('');
        $('.push-by-criteria').hide().find('input,select,textarea').val('');
        $('.push-by-criteria').find('input[type=checkbox]').prop('checked', false);

        switch (slug) 
        {
            case 'push-to-someone':
                $('.push-to-someone').show();
                break;
            case 'push-by-criteria':
                $('.push-by-criteria').show();
                break;
            case 'push-to-all':
                break;
            default:
                break;
        }
    },
    check_section: function(){
        var slug = $('#promotion_section').find("option:selected").data('slug');
        var section_id = $('#promotion_section').val();
        var company_id = $('#push_company_id').val();
        $('.promotion_section_type').hide().find('input,select').attr('disabled',true);

        if (section_id != '' && company_id != '') {
            if (ADMIN_PUSH.have_section_object.indexOf(slug) > -1) {
                COMMON.call_ajax({
                    type: "POST",
                    url: ADMIN_PUSH.url_get_section_data,
                    dataType: 'html',
                    cache: false,
                    data: {
                        section_id: section_id,
                        company_id: company_id,
                    },
                    success: function( result ){
                        if (result != '') {
                            $('.promotion_section_object').find('select').html(result);
                            $('.promotion_section_object').show().find('input,select').attr('disabled',false);
                        }
                    },
                    error: function( error ){

                    }
                });
            }else{
                $('.promotion_section_link').show().find('input,select').attr('disabled',false);
            }
        }
    }
}