$(document).ready(function() {
    var container = $('#vital-signs-container');
    
    // Determine the form name based on the current page URL
    function getFormName() {
        var path = window.location.pathname;
        
        if (path.includes('ward-round-notes')) {
            return 'ward_round_note';
        } else if (path.includes('nursing-cardexes')) {
            return 'nursing_cardex';
        } else if (path.includes('medical-referrals')) {
            return 'medical_referral';
        } else if (path.includes('lab-requests')) {
            return 'lab_request';
        } else if (path.includes('initial-evaluations')) {
            return 'initial_evaluation';
        } else if (path.includes('weekly-wellness-checks')) {
            return 'weekly_wellness_check';
        }
        
        // Check if data attribute exists on container
        if (container.length > 0 && container.data('form-name')) {
            return container.data('form-name');
        }
        
        return 'default';
    }
    
    // Auto-display vital signs form on page load if container exists and is empty
    if (container.length > 0 && container.children().length === 0) {
        var formName = getFormName();
        console.log(formName,'form 1');
        $.get("/components/vital-signs?form_name=" + formName, function(data) {
            container.append(data);
        });
    }
    
    // Keep the click functionality in case it's still needed elsewhere
    $('body').on('click', '#add-vital-signs', function() {
        var container = $('#vital-signs-container');
        
        // Check if vital signs form is already visible
        if (container.children().length > 0) {
            // If visible, hide/remove it
            container.empty();
        } else {
            // If not visible, fetch and display the vital signs component
            var formName = getFormName();
            console.log(formName,'form 2');
            $.get("/components/vital-signs?form_name=" + formName, function(data) {
                container.append(data);
            });
        }
    });
});