$(document).ready(function() {
    "use strict";
    $(document).on('change', '#doctor_id, #appointment_date', function() {
        let userId = $('#doctor_id').val();
        let appointmentDate = $('#appointment_date').val();
        let siteUrl = $('meta[name="site-url"]').attr('content');
        let url = siteUrl + '/patient-appointments/get-schedule/doctorwise';
        if (userId && appointmentDate)
            $.get(url, {userId, appointmentDate},function(response, status){
                $('#appointment_slot').html(response.slots);
                if (response.next_available_date) {
                    // You can add a notification to the user about the next available date.
                    // For example, using a library like Toastr or just a simple alert.
                    alert('No slots available for the selected date. Next available date is ' + response.next_available_date);
                }
            });
    });
});
