class PatientDetailsHandler {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        // delegated handlers so it works for dynamic content
        $(document).on('change', '.patient-select', this.handlePatientChange.bind(this));
        // select2 sometimes fires select2:select — handle it too
        $(document).on('select2:select', '.patient-select', this.handlePatientChange.bind(this));

        // initialize any existing selects on load
        $(document).ready(() => {
            $('.patient-select').each((i, el) => {
                if ($(el).val()) {
                    $(el).trigger('change');
                }
            });
        });
    }

    handlePatientChange(event) {
        const $select = $(event.target);
        const patientId = $select.val();

        // 1) explicit target via data attribute on the select is the most reliable
        const explicit = $select.data('patient-container') || $select.data('patientContainer') || $select.attr('data-patient-container');
        let $container = explicit ? $(explicit) : $();

        // 2) fallback: search nearby containers (scoped search)
        if (!$container || $container.length === 0) {
            // search within sensible ancestors (form, card, row, container)
            $container = $select.closest('form, .card, .row, .container, .col-md-6, .form-group')
                                .find('.patient-details-container')
                                .first();
        }

        // 3) fallback: siblings
        if (!$container || $container.length === 0) {
            $container = $select.siblings('.patient-details-container').first();
        }

        // 4) last resort: global first
        if (!$container || $container.length === 0) {
            $container = $('.patient-details-container').first();
        }

        if (!$container || $container.length === 0) {
            console.warn('Patient details container not found for', $select);
            return; // can't do anything
        }

        if (patientId) {
            this.fetchPatientDetails(patientId, $container);
        } else {
            this.hidePatientDetails($container);
        }
    }

    fetchPatientDetails(patientId, $container) {
        $.ajax({
            url: `/api/patient-details/${patientId}`,
            type: 'GET',
            dataType: 'json',
            success: (data) => {
                // quick sanity log (remove in production)
                console.debug('Patient details response for', patientId, data);
                this.displayPatientDetails(data, $container);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                console.error('Error fetching patient details:', textStatus, errorThrown, jqXHR);
                this.hidePatientDetails($container);
            }
        });
    }

    displayPatientDetails(data, $container) {
        // prefer data-field attributes or classes; fall back to ids for backward compatibility

        // formatted panel (labels/spans)
        const ageNode = $container.find('[data-field="age"], .patient-age, #patient-age').first();
        const weightNode = $container.find('[data-field="weight"], .patient-weight, #patient-weight').first();
        const heightNode = $container.find('[data-field="height"], .patient-height, #patient-height').first();
        const genderNode = $container.find('[data-field="gender"], .patient-gender, #patient-gender').first();
        const bloodNode = $container.find('[data-field="blood_group"], .patient-blood-group, #patient-blood-group').first();

        if (ageNode.length || weightNode.length || heightNode.length || genderNode.length || bloodNode.length) {
            ageNode.text(data.age ?? '');
            weightNode.text(data.weight ?? '');
            heightNode.text(data.height ?? '');
            genderNode.text(data.gender ?? '');
            bloodNode.text(data.blood_group ?? '');
        }

        // form fields (inputs)
        const ageInput = $container.find('input[name="age"], #age, .age-input').first();
        const weightInput = $container.find('input[name="weight"], #weight, .weight-input').first();
        const heightInput = $container.find('input[name="height"], #height, .height-input').first();
        const bloodInput = $container.find('input[name="blood_group"], #blood_group, .blood-input').first();

        if (ageInput.length || weightInput.length || heightInput.length || bloodInput.length) {
            ageInput.val(data.age ?? '');
            weightInput.val(data.weight ?? '');
            heightInput.val(data.height ?? '');
            bloodInput.val(data.blood_group ?? '');

            // gender radio buttons (name="sex")
            if (data.gender) {
                $container.find('input[name="sex"]').prop('checked', false);
                $container.find(`input[name="sex"][value="${data.gender}"]`).prop('checked', true);
            }
        }

        $container.show();
    }

    hidePatientDetails($container) {
        $container.hide();

        // clear form inputs if present
        $container.find('input[name="age"], input[name="weight"], input[name="height"], input[name="blood_group"]').val('');
        $container.find('input[name="sex"]').prop('checked', false);

        // clear formatted fields (data-field or class or id)
        $container.find('[data-field="age"], .patient-age, #patient-age').text('');
        $container.find('[data-field="weight"], .patient-weight, #patient-weight').text('');
        $container.find('[data-field="height"], .patient-height, #patient-height').text('');
        $container.find('[data-field="gender"], .patient-gender, #patient-gender').text('');
        $container.find('[data-field="blood_group"], .patient-blood-group, #patient-blood-group').text('');
    }
}

// init
$(document).ready(() => {
    new PatientDetailsHandler();
});
