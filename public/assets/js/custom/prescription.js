$(document).ready(function () {
    "use strict";
    
    // Remove the page reload on patient selection since patient-details.js handles this via AJAX
    // $(document).on('change', '#user_id', function () {
    //     let patientId = $('#user_id').val();
    //     let url = window.location.href.split(/[?#]/)[0];
    //     window.location.href = url + '?user_id=' + patientId;
    // });

    let medicine = $('#medicine').html();
    $(document).on('click', '.m-add', function () {
        $('#medicine').append(medicine);
    });

    $(document).on('click', '.m-remove', function () {
        $(this).parent().parent().remove();
    });

    let diagnosis = $('#diagnosis').html();
    $(document).on('click', '.d-add', function () {
        $('#diagnosis').append(diagnosis);
    });

    $(document).on('click', '.d-remove', function () {
        $(this).parent().parent().remove();
    });
});
