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

    // Password validation
    function validatePassword() {
        var password = $('#password').val();
        var passwordConfirmation = $('#password_confirmation').val();
        var isValid = true;

        // Clear previous error styles
        $('#password').removeClass('is-invalid is-valid');
        $('#password_confirmation').removeClass('is-invalid is-valid');

        // If password field is not empty, validate it
        if (password.length > 0) {
            // Check minimum length
            if (password.length < 8) {
                $('#password').addClass('is-invalid');
                isValid = false;
            } else {
                $('#password').addClass('is-valid');
            }

            // Check if password confirmation matches
            if (passwordConfirmation.length > 0) {
                if (password !== passwordConfirmation) {
                    $('#password_confirmation').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#password_confirmation').addClass('is-valid');
                }
            }
        } else {
            // If password is empty, confirmation should also be empty
            if (passwordConfirmation.length > 0) {
                $('#password_confirmation').addClass('is-invalid');
                isValid = false;
            }
        }

        return isValid;
    }

    // Validate password on input
    $('#password').on('input', function() {
        validatePassword();
    });

    // Validate password confirmation on input
    $('#password_confirmation').on('input', function() {
        validatePassword();
    });

    // Form submission validation
    $('form').on('submit', function(e) {
        var password = $('#password').val();
        var passwordConfirmation = $('#password_confirmation').val();

        // If either password field has a value, validate both
        if (password.length > 0 || passwordConfirmation.length > 0) {
            if (!validatePassword()) {
                e.preventDefault();
                // Show error message if passwords don't match
                if (password !== passwordConfirmation) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Password and confirm password must match.');
                    } else {
                        alert('Password and confirm password must match.');
                    }
                } else if (password.length < 8) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Password must be at least 8 characters long.');
                    } else {
                        alert('Password must be at least 8 characters long.');
                    }
                }
                return false;
            }
        }
    });

    $(".select2").select2();
    var equill = new Quill('#edit_input_address', {
        theme: 'snow'
    });
    var address = $("#address").val();
    equill.clipboard.dangerouslyPasteHTML(address);
    equill.root.blur();
    $('#edit_input_address').on('keyup', function(){
        var edit_input_address = equill.container.firstChild.innerHTML;
        $("#address").val(edit_input_address);
    });
});
