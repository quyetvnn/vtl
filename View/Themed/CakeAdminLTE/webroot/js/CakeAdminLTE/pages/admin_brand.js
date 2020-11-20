var ADMIN_BRAND = {
    url_index: '',
    url_get_item_detail: '',
    url_upgrade_item_detail: '',
    url_check_new_old_data: '',
    data_change_status: {},
    message_confirm: '',
    is_have_pending: 0,
    currency_title: '',
    payment_title: '',
    are_more_than_publish_record: '',
    init_page: function(){
		COMMON.init_validate_form_tabs($("#btn-submit-data"));
    },
    init_edit_form: function(){
        $('#brand-edit-form').on('submit', function(event){
            if(ADMIN_BRAND.is_have_pending == 1){
                var result = confirm(ADMIN_BRAND.message_confirm_continuous_edit_pending);
                if (result == false) {
                    event.preventDefault();
                } 
            }
        });
    },
    init_detail_page: function(){
        var hashtag = window.location.hash.substr(1);
        if(hashtag){
            $('a[href="#' + hashtag+ '"]').trigger('click');
        }

        $('.btn-approve').off().on('click', function(){
            ADMIN_BRAND.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 1
            };

            ADMIN_BRAND.init_confirm_change_status(COMMON.action_flow.approve);
        });

        $('.btn-reject').off().on('click', function(){
            ADMIN_BRAND.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 4
            };

            ADMIN_BRAND.init_confirm_change_status(COMMON.action_flow.reject);
        });

        $('.btn-view-detail').on('click', function(){
            var id = $(this).data('id');

            COMMON.call_ajax({
                url: ADMIN_BRAND.url_get_item_detail + '/' + id,
                type: 'GET',
                dataType: 'text',
                success: function(result){
                    $('.brand-detail-modal .modal-body').html(result);
                    $('.brand-detail-modal').modal('show');
                    ADMIN_BRAND.init_action_popup_view_detail();
                },
                error: function(error){
                    alert("Get data for brand detail is error!")
                }
            });
        });
    },
    init_action_popup_view_detail: function(){
        $('.btn-approve-modal').off().on('click', function(){
            ADMIN_BRAND.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 1
            };

            ADMIN_BRAND.init_confirm_change_status(COMMON.action_flow.approve);
        });

        $('.btn-reject-modal').off().on('click', function(){
            ADMIN_BRAND.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 4
            };

            ADMIN_BRAND.init_confirm_change_status(COMMON.action_flow.reject);
        });
    },
    init_confirm_change_status: function(action){
        // because brand have currency and payment method reference to all active shop => check old and new data (ONLY approved)
        if(action == COMMON.action_flow.approve){
            COMMON.call_ajax({
                url: ADMIN_BRAND.url_check_new_old_data + '/' + ADMIN_BRAND.data_change_status.id,
                type: 'POST',
                data: {
                    brand_detail_id: ADMIN_BRAND.data_change_status.detail_id,
                },
                dataType: 'json',
                success: function(result){
                    if(result.status == true){
                        if(result.params.is_change == true){
                            var arr_messages = [];
                            var currencies = Object.values(result.params.currency_names);
                            var payment_methods = Object.values(result.params.payment_method_names);
                            if(currencies.length > 0){
                                arr_messages.push('[' + ADMIN_BRAND.currency_title + '] ' + currencies.join(', ') + ' ' + ADMIN_BRAND.are_more_than_publish_record)
                            }
    
                            if(payment_methods.length > 0){
                                arr_messages.push('[' + ADMIN_BRAND.payment_title + '] ' + payment_methods.join(', ') + ' ' + ADMIN_BRAND.are_more_than_publish_record)
                            }
    
                            ADMIN_BRAND.init_action_confirm_change_status(action, arr_messages, result.params.is_change);
                        }else{
                            ADMIN_BRAND.init_action_confirm_change_status(action, [], false);
                        }
                    }else{
                        alert("Get compare old and new data is FAILED");
                    }
                },
                error: function(error){
                    alert("Get compare old and new data is FAILED");
                }
            });
        }else{
            ADMIN_BRAND.init_action_confirm_change_status(action, [], false);
        }
    },
    init_action_confirm_change_status: function(action, arr_messages, is_change){
        var message = ADMIN_BRAND.message_confirm.replace("[action]", action);
        if(arr_messages.length > 0){
            message = arr_messages.join('<br/>') + "<br/>" + message;
        }
        $('.confirm-change-status-modal .modal-body h3').html(message);
        $('.confirm-change-status-modal').modal('show');
        
        if(action == COMMON.action_flow.approve && is_change == true){
            // approve new shop was created
            $('.btn-confirm-approve-shop').off().show().on('click', function(){
                ADMIN_BRAND.init_form_submit_change_status(action, true);
            });
            // not approve new shop was created
            $('.btn-confirm-add-reference-shop').off().show().on('click', function(){
                ADMIN_BRAND.init_form_submit_change_status(action, false);
            });

            $('.btn-confirm-yes').off().hide();
        }else{
            $('.btn-confirm-approve-shop').off().hide();
            $('.btn-confirm-add-reference-shop').off().hide();
            $('.btn-confirm-yes').off().show().on('click', function(){
                ADMIN_BRAND.init_form_submit_change_status(action, false);
            });
        }
    },
    init_form_submit_change_status: function(action, is_approve_shop){
        COMMON.call_ajax({
            url: ADMIN_BRAND.url_upgrade_item_detail + '/' + ADMIN_BRAND.data_change_status.id,
            type: 'POST',
            data: {
                brand_detail_id: ADMIN_BRAND.data_change_status.detail_id,
                status: ADMIN_BRAND.data_change_status.status,
                is_approve_shop: is_approve_shop ? 1 : 0
            },
            dataType: 'json',
            success: function(result){
                if(typeof(result.status) != "undefined"){
                    alert(result.params.message);
                    if(result.status === true){
                        window.location.href = ADMIN_BRAND.url_index;
                    }
                }else{
                    alert(action + " this brand was FAILED!");
                }
            },
            error: function(error){
                alert(action + " this brand was FAILED!");
            }
        });
    }
}