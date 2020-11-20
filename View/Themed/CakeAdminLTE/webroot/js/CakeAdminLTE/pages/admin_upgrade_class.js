var ADMIN_UPGRADE_CLASS = {
    UPGRADE_CLASS_TEXT: '',

    init_page: function() {

        $('#chk-all-student').on('ifChecked', function(event) {             // checked
            $(".icheckbox_minimal").addClass('checked');
            $(".icheckbox_minimal").attr('aria-checked', true);
            $(".choose_id").attr('checked', true);
        });

        $('#chk-all-student').on('ifUnchecked', function(event) {           // unchecked
            $(".icheckbox_minimal").removeClass('checked');
            $(".icheckbox_minimal").attr('aria-checked', false);
            $(".choose_id").attr('checked', false);
            
        });

        // button_pressed = "";
        // $('#add_all_student_to_class').click(function() {
        //     button_pressed = $(this).attr('name');
        //     console.log(button_pressed);
        // });
    }
}