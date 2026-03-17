$(document).ready( function () {
    "use strict";
    var rolefor = $('#role_for').val();
    if(rolefor == '1') {
        $('#staff_block').show();
        $('#user_block').hide();
    } else {
        $('#staff_block').hide();
        $('#user_block').show();
    }

    $('#role_for').change(function(){
        if($('#role_for').val() == '1') {
            $('#staff_block').show();
            $('#user_block').hide();
        } else {
            $('#staff_block').hide();
            $('#user_block').show();
        }
    });

    // Show/hide doctor block based on staff role selection
    function toggleDoctorBlock() {
        var staffRole = $('#staff_roles').val();
        if (staffRole === 'Doctor') {
            $('#doctor_block').show();
        } else {
            $('#doctor_block').hide();
        }
    }

    // Initialize on page load
    toggleDoctorBlock();

    // Toggle when staff role changes
    $('#staff_roles').change(function(){
        toggleDoctorBlock();
    });

    var quill = new Quill('#input_address', {
        theme: 'snow'
    });

    var address = $("#address").val();
    quill.clipboard.dangerouslyPasteHTML(address);
    quill.root.blur();
    $('#input_address').on('keyup', function(){
        var input_address = quill.container.firstChild.innerHTML;
        $("#address").val(input_address);
    });

    $(".select2").select2();
});
