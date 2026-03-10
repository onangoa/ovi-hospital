@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('doctor-assignments.index') }}">Doctor Assignments</a></li>
                    <li class="breadcrumb-item active">Edit Doctor Assignment</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Doctor Assignment</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form id="assignmentForm" class="form-material form-horizontal" action="{{ route('doctor-assignments.update', $doctorAssignment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Assignment Type <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <select name="type" id="type" class="form-control select2 @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="appointment" {{ $doctorAssignment->isAppointment() ? 'selected' : '' }}>Patient Appointment</option>
                                        <option value="ward_assignment" {{ $doctorAssignment->isWardAssignment() ? 'selected' : '' }}>Ward Assignment</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_id">Doctor <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <select name="doctor_id" id="doctor_id" class="form-control select2 @error('doctor_id') is-invalid @enderror" required>
                                        <option value="">Select Doctor</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" {{ $doctorAssignment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" id="patient_field" style="display: {{ $doctorAssignment->isAppointment() ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="patient_id">Patient</label>
                                <div class="form-group input-group mb-3">
                                    <select name="patient_id" id="patient_id" class="form-control select2 @error('patient_id') is-invalid @enderror" {{ $doctorAssignment->isAppointment() ? 'required' : '' }}>
                                        <option value="">Select Patient</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ $doctorAssignment->patient_id == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="ward_field" style="display: {{ $doctorAssignment->isWardAssignment() ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="ward_id">Ward</label>
                                <div class="form-group input-group mb-3">
                                    <select name="ward_id" id="ward_id" class="form-control select2 @error('ward_id') is-invalid @enderror" {{ $doctorAssignment->isWardAssignment() ? 'required' : '' }}>
                                        <option value="">Select Ward</option>
                                        @foreach($wards as $ward)
                                            <option value="{{ $ward->id }}" {{ $doctorAssignment->ward_id == $ward->id ? 'selected' : '' }}>
                                                {{ $ward->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ward_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="schedule_type">Schedule Type <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <select name="schedule_type" id="schedule_type" class="form-control select2 @error('schedule_type') is-invalid @enderror" required>
                                        <option value="">Select Schedule Type</option>
                                        <option value="specific_date" {{ $doctorAssignment->appointment_date && !$doctorAssignment->weekday ? 'selected' : '' }}>Specific Date</option>
                                        <option value="recurring" {{ $doctorAssignment->weekday ? 'selected' : '' }}>Recurring (Weekly)</option>
                                    </select>
                                    @error('schedule_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="date_field" style="display: {{ $doctorAssignment->appointment_date && !$doctorAssignment->weekday ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="appointment_date">Date <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ $doctorAssignment->appointment_date ? $doctorAssignment->appointment_date->format('Y-m-d') : '' }}">
                                    @error('appointment_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="weekday_field" style="display: {{ $doctorAssignment->weekday ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="weekday">Weekday <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-week"></i></span>
                                    </div>
                                    <select name="weekday" id="weekday" class="form-control select2 @error('weekday') is-invalid @enderror">
                                        <option value="">Select Weekday</option>
                                        <option value="Sunday" {{ $doctorAssignment->weekday == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                        <option value="Monday" {{ $doctorAssignment->weekday == 'Monday' ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ $doctorAssignment->weekday == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ $doctorAssignment->weekday == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ $doctorAssignment->weekday == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ $doctorAssignment->weekday == 'Friday' ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ $doctorAssignment->weekday == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    </select>
                                    @error('weekday')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_time">Start Time <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ $doctorAssignment->start_time->format('H:i') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ $doctorAssignment->end_time ? $doctorAssignment->end_time->format('H:i') : '' }}">
                                    @error('end_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="status_field" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <b class="ambitious-crimson">*</b></label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <select name="status" id="status" class="form-control select2 @error('status') is-invalid @enderror" required>
                                        <option value="scheduled" {{ $doctorAssignment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="in_progress" {{ $doctorAssignment->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $doctorAssignment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $doctorAssignment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="problem_field">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="problem">Problem/Reason</label>
                                <div class="form-group input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                                    </div>
                                    <textarea name="problem" id="problem" class="form-control @error('problem') is-invalid @enderror" rows="3">{{ $doctorAssignment->problem }}</textarea>
                                    @error('problem')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-8">
                            <input type="submit" value="Update" class="btn btn-outline btn-info btn-lg"/>
                            <a href="{{ route('doctor-assignments.index') }}" class="btn btn-outline btn-warning btn-lg">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('footer')
<script>
$(document).ready(function() {
    // Initialize Select2 with custom options
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
    
    // Handle schedule type change
    $('#schedule_type').on('change', function() {
        const value = $(this).val();
        
        // Hide both fields first
        $('#date_field').hide();
        $('#weekday_field').hide();
        
        // Reset required attributes
        $('#appointment_date').prop('required', false);
        $('#weekday').prop('required', false);
        
        // Clear values
        $('#appointment_date').val('');
        $('#weekday').val(null).trigger('change');
        
        if (value === 'specific_date') {
            $('#date_field').show();
            $('#appointment_date').prop('required', true);
        } else if (value === 'recurring') {
            $('#weekday_field').show();
            $('#weekday').prop('required', true);
        }
    });
    
    // Use jQuery for event handling to work better with Select2
    $('#type').on('change', function() {
        console.log('Type changed to:', $(this).val());
        const value = $(this).val();
        
        // Hide both fields first
        $('#patient_field').hide();
        $('#ward_field').hide();
        
        // Reset required attributes
        $('#patient_id').prop('required', false);
        $('#ward_id').prop('required', false);
        
        // Reset Select2 values
        $('#patient_id').val(null).trigger('change');
        $('#ward_id').val(null).trigger('change');
        
        // Always show problem field regardless of assignment type
        $('#problem_field').show();
        
        if (value === 'appointment') {
            console.log('Showing patient field');
            $('#patient_field').show();
            $('#patient_id').prop('required', true);
        } else if (value === 'ward_assignment') {
            console.log('Showing ward field');
            $('#ward_field').show();
            $('#ward_id').prop('required', true);
        }
    });
    
    // Handle form submission to ensure patient_id is properly handled
    $('form').on('submit', function(e) {
        const type = $('#type').val();
        const scheduleType = $('#schedule_type').val();
        
        // If this is a ward assignment, ensure patient_id is empty
        if (type === 'ward_assignment') {
            $('#patient_id').val(null).trigger('change');
        }
        
        // If this is an appointment, ensure ward_id is empty
        if (type === 'appointment') {
            $('#ward_id').val(null).trigger('change');
        }
        
        // Handle schedule type validation
        if (scheduleType === 'specific_date') {
            $('#weekday').val(null).trigger('change');
        } else if (scheduleType === 'recurring') {
            $('#appointment_date').val('');
        }
    });
});
</script>
@endpush
@endsection