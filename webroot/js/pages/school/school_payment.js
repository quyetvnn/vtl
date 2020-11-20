var SCHOOL_PAYMENT = {
    lst_material    : [],
    lst_material_extension_allowed: ['pdf', 'jpg', 'jpeg', 'png'],
    mark_apply_now: false,
    is_submit_application_form: false,
    school_id: '',
    amount: '',
    init_page: function() {
        SCHOOL_PAYMENT.lst_material      = [];
        SCHOOL_PAYMENT.school_id = '';
        SCHOOL_PAYMENT.amount = '';

        $("#frm-crt-school").trigger("reset");
        $('#submit-create-school').prop("disabled", true);
        $("#lst-imported-material").html("");

        $(document).on('hidden.bs.modal', '#modal-payment-fail', function(){
            window.location = COMMON.base_url+'schools/payment/';
        })

        $(document).on('hidden.bs.modal', '#modal-payment-success', function(){
            window.location = COMMON.base_url+'schools/payment/';
        })

        $(document).on('hidden.bs.modal', '#modal-success', function(){
            location.reload();
        })
        $(document).on('keyup', ".format-number", function(){
            var $this = $( this );
            var input = $this.val();
             
            // 2
            var input = input.replace(/[\D\s\._\-]+/g, "");
             
            // 3
            input = input ? parseInt( input, 10 ) : 0;
             
            // 4
            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
            } );
        })

        $(document).on('submit', '.create-payment', function(e){
            e.preventDefault();
            SCHOOL_PAYMENT.school_id = $(this).attr('id');
            var school_name = $("#name-"+SCHOOL_PAYMENT.school_id).html();

            $("#amount-"+SCHOOL_PAYMENT.school_id).removeClass('error');
            $("#error-"+SCHOOL_PAYMENT.school_id).html('');
            var amount_format = $("#amount-"+SCHOOL_PAYMENT.school_id).val();
            SCHOOL_PAYMENT.amount = amount_format.replace(',','');

            if(SCHOOL_PAYMENT.amount==undefined || SCHOOL_PAYMENT.amount==null || SCHOOL_PAYMENT.amount=='' || isNaN(SCHOOL_PAYMENT.amount)){
                $("#amount-"+SCHOOL_PAYMENT.school_id).addClass('error');
                $("#error-"+SCHOOL_PAYMENT.school_id).html(lang.missing_mount);
                return false;
            }
            $("#modal-confirm-payment #long-message").html(sprintf(lang.confirm_topup_message, amount_format, school_name));
            $("#modal-confirm-payment").modal('show');
        })
    },
    confirm_payment: function(is_confirmed){
        $("#modal-confirm-payment").modal('hide');
        if(is_confirmed){
            var data_request = {
                school_id: SCHOOL_PAYMENT.school_id,
                amount: SCHOOL_PAYMENT.amount
            }
            SERVICE.add_pay_dollar(data_request, function(resp){
                if(resp.status === 200){
                    var params = resp.params;
                    $("#form-school-payment #school_id").val(SCHOOL_PAYMENT.school_id);
                    $("#form-school-payment #amount").val(SCHOOL_PAYMENT.amount);
                    $("#form-school-payment #orderRef").val(params.orderRef);
                    $("#form-school-payment #secureHash").val(params.secureHash);
                    $("#form-school-payment #school_name").val($("#name-"+SCHOOL_PAYMENT.school_id).html());
                    $("#form-school-payment").trigger('submit');
                }else{
                    bootbox.alert(resp.message);
                }
            })
        }else{
            $("#"+SCHOOL_PAYMENT.school_id).trigger('reset');
        }
    },
    // asiapay: function(data){
    //     var data_request = {

    //     }
    //     COMMON.call_ajax({
    //         url: COMMON.base_api_url+'api/school/schools/get_school_by_id.json',
    //         type: 'POST',
    //         data: data_request,
    //         dataType: 'json',
    //         success: function(resp){
    //             if(resp.status === 200){
                    
    //             }else{
    //                 bootbox.alert(resp.message);
    //             }
    //         },
    //         error: function(error){
    //             bootbox.alert("Connection error!");
    //         }
    //     })
    // }
}