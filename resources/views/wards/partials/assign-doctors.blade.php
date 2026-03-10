<div class="modal fade" id="assignDoctorsModal" tabindex="-1" role="dialog" aria-labelledby="assignDoctorsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('wards.assign-doctors', $ward) }}" id="assignDoctorsForm" data-ward-id="{{ $ward->id }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignDoctorsModalLabel">@lang('Assign Doctors to Ward')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> @lang('Select doctors, dates, and their available time slots for ward assignment. Doctors without schedules will be highlighted.')
                    </div>
                    
                    <div class="form-group">
                        <label>@lang('Available Doctors')</label>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th width="50px">@lang('Select')</th>
                                        <th>@lang('Doctor Name')</th>
                                        <th>@lang('Schedule Status')</th>
                                        <th>@lang('Available Days')</th>
                                        <th>@lang('Select Date')</th>
                                        <th>@lang('Select Time Slot')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn-primary" id="assignButton">@lang('Assign Selected Doctors')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle doctor checkbox changes
    const doctorCheckboxes = document.querySelectorAll('.doctor-checkbox');
    doctorCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const doctorId = this.value;
            const slotSelect = document.getElementById('slots_' + doctorId);
            
            if (this.checked) {
                // Enable date and slot selection
                const dateInput = document.getElementById('date_' + doctorId);
                dateInput.disabled = false;
                initializeDatePicker(doctorId);
            } else {
                // Disable and clear date and slot selection
                const dateInput = document.getElementById('date_' + doctorId);
                dateInput.disabled = true;
                dateInput.value = '';
                
                slotSelect.disabled = true;
                slotSelect.innerHTML = '<option value="">@lang('Select a slot')</option>';
                document.getElementById('slot_info_' + doctorId).innerHTML = '';
                document.getElementById('date_info_' + doctorId).innerHTML = '';
            }
        });
        
        // Add warning when trying to select doctors without schedules
        if (checkbox.hasAttribute('data-no-schedule')) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    alert('@lang("Warning: This doctor does not have an active schedule. Assignment may not be successful.")');
                }
            });
        }
    });
    
    // Initialize date picker for a doctor
    function initializeDatePicker(doctorId) {
        const dateInput = document.getElementById('date_' + doctorId);
        
        // Initialize flatpickr if not already initialized
        if (!dateInput._flatpickr) {
            flatpickr(dateInput, {
                dateFormat: "Y-m-d",
                minDate: "today",
                onMonthChange: function(selectedDates, dateStr, instance) {
                    const currentMonth = instance.currentMonth;
                    const currentYear = instance.currentYear;
                    updateDisabledDatesForWard(doctorId, currentYear, currentMonth + 1);
                },
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length > 0) {
                        document.getElementById('date_info_' + doctorId).innerHTML =
                            '<small class="text-info"><i class="fas fa-calendar"></i> ' + dateStr + '</small>';
                        loadDoctorSlots(doctorId, dateStr);
                    } else {
                        document.getElementById('date_info_' + doctorId).innerHTML = '';
                        clearSlots(doctorId);
                    }
                }
            });

            // Initial call for the current month
            const currentMonth = new Date().getMonth();
            const currentYear = new Date().getFullYear();
            updateDisabledDatesForWard(doctorId, currentYear, currentMonth + 1);
        }
    }

    // Update disabled dates for the ward assignment calendar
    function updateDisabledDatesForWard(doctorId, year, month) {
        const dateInput = document.getElementById('date_' + doctorId);
        if (!dateInput || !dateInput._flatpickr) return;

        fetch(`/doctor-unavailable-days/${doctorId}?year=${year}&month=${month}`)
            .then(response => response.json())
            .then(data => {
                const fullyBooked = function(date) {
                    const dateStr = date.getFullYear() + "-" + (date.getMonth() + 1).toString().padStart(2, '0') + "-" + date.getDate().toString().padStart(2, '0');
                    return data.fully_booked_dates.includes(dateStr);
                };
                const pastDates = function(date) {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    return date < today;
                };
                dateInput._flatpickr.set('disable', [pastDates, fullyBooked]);
            })
            .catch(error => {
                console.error('Error fetching unavailable dates:', error);
            });
    }
    
    // Load doctor slots when date is selected
    function loadDoctorSlots(doctorId, selectedDate) {
        const form = document.getElementById('assignDoctorsForm');
        const wardId = form.dataset.wardId;
        
        fetch(`/wards/doctor-schedules/${doctorId}?date=${selectedDate}&ward_id=${wardId}`)
            .then(response => response.json())
            .then(slots => {
                const slotSelect = document.getElementById('slots_' + doctorId);
                slotSelect.disabled = false;
                slotSelect.innerHTML = '<option value="">@lang('Select a slot')</option>';
                
                slots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot.id;
                    option.textContent = slot.text;
                    slotSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading slots:', error);
                document.getElementById('slot_info_' + doctorId).innerHTML =
                    '<small class="text-danger">@lang('Error loading slots')</small>';
            });
    }
    
    // Clear slots when date is cleared
    function clearSlots(doctorId) {
        const slotSelect = document.getElementById('slots_' + doctorId);
        slotSelect.disabled = true;
        slotSelect.innerHTML = '<option value="">@lang('Select a slot')</option>';
        document.getElementById('slot_info_' + doctorId).innerHTML = '';
    }
    
    // Handle slot selection changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('slot-select')) {
            const doctorId = e.target.id.replace('slots_', '');
            const slotInfo = document.getElementById('slot_info_' + doctorId);
            
            if (e.target.value) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                slotInfo.innerHTML = '<small class="text-info"><i class="fas fa-clock"></i> ' + selectedOption.textContent + '</small>';
            } else {
                slotInfo.innerHTML = '';
            }
        }
    });
    
    // Form validation before submission
    document.getElementById('assignDoctorsForm').addEventListener('submit', function(e) {
        const selectedDoctors = document.querySelectorAll('.doctor-checkbox:checked');
        let valid = true;
        let errorMessage = '';
        
        selectedDoctors.forEach(function(checkbox) {
            const doctorId = checkbox.value;
            const dateInput = document.getElementById('date_' + doctorId);
            const slotSelect = document.getElementById('slots_' + doctorId);
            
            if (!checkbox.hasAttribute('data-no-schedule')) {
                if (!dateInput.value) {
                    valid = false;
                    errorMessage = '@lang('Please select a date for each selected doctor.')';
                } else if (!slotSelect.value) {
                    valid = false;
                    errorMessage = '@lang('Please select a time slot for each selected doctor.')';
                }
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert(errorMessage);
        }
    });
});
</script>
