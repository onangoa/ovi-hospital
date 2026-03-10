@extends('layouts.layout')

@section('content')
<div class="content-header">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
<div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Home')</a></li>
<li class="breadcrumb-item"><a href="{{ route('therapy-reports.individual') }}">@lang('Individual Therapy Reports')</a></li>

                        <li class="breadcrumb-item active">@lang('Create Individual Therapy Session')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
<div class="card-header">
                    <h3 class="card-title">@lang('Individual Therapy Session Details')</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('individual-therapy.store') }}" class="form-material form-horizontal">
                        @csrf
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        
                        <!-- Report Details Section -->
                        <div class="card mb-4">
<div class="card-header"><h3 class="card-title">@lang('Report Details')</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
<label for="date">@lang('Date')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                                </div>
                                                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" readonly>
                                                @error('date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
<label for="physiotherapist">@lang('Conducted by')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                                </div>
<input type="text" name="physiotherapist" class="form-control" id="physiotherapist" placeholder="@lang('Physiotherapist name')" value="{{ $currentUser->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Individual Therapy Session Section -->
                        <div class="card mb-4">
<div class="card-header"><h3 class="card-title">@lang('Individual Therapy Session')</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
<label for="session_time">@lang('Session Time')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <select name="session_time" class="form-control @error('session_time') is-invalid @enderror" id="session_time">
                                                    <option value="">@lang('Select Time')</option>
                                                    @if(!empty($timeSlots))
                                                        @foreach($individualAssignments as $assignment)
                                                            @if($assignment->patient && $assignment->start_time && $assignment->end_time)
                                                                <?php
                                                                $startTime = \Carbon\Carbon::parse($assignment->start_time);
                                                                $endTime = \Carbon\Carbon::parse($assignment->end_time);
                                                                $slotString = $startTime->format('g:i A') . ' - ' . $endTime->format('g:i A');
                                                                ?>
                                                                <option value="{{ $slotString }}" {{ old('session_time') == $slotString ? 'selected' : '' }}>
                                                                    {{ $slotString }} - {{ $assignment->patient->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="" disabled>@lang('No patient assignments available for today.')</option>
                                                    @endif
                                                </select>
                                                @error('session_time')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
<label for="patient_id">@lang('Patient Name')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <input type="text" name="patient_name_display" class="form-control @error('patient_id') is-invalid @enderror" id="patient_name_display" readonly placeholder="Select a time slot to see assigned patient">
                                                <input type="hidden" name="patient_id" id="patient_id">
                                                @error('patient_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
<label for="session_summary">@lang('Session Summary')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        </div>
<textarea name="session_summary" class="form-control @error('session_summary') is-invalid @enderror" id="session_summary" rows="5" placeholder="@lang('Describe the session activities and progress')">{{ old('session_summary') }}</textarea>
                                        @error('session_summary')
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
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="Submit" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('therapy-reports.individual') }}" class="btn btn-outline btn-warning btn-lg">Cancel</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer')
    <script src="{{ asset('assets/js/custom/patient-details.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#session_time').on('change', function() {
                const timeSlot = $(this).val();
                console.log('Time slot selected:', timeSlot);
                
                if (timeSlot) {
                    // Fetch patient for the selected time slot
                    $.ajax({
                        url: "{{ route('individual-therapy.get-patient-by-slot') }}",
                        method: 'GET',
                        data: { time_slot: timeSlot },
                        beforeSend: function() {
                            console.log('Sending request for time slot:', timeSlot);
                        },
                        success: function(response) {
                            console.log('Response received:', response);
                            if (response.patient_id) {
                                console.log('Setting patient ID:', response.patient_id);
                                console.log('Patient name:', response.patient_name);
                                
                                // Set the patient name and ID in the readonly fields
                                $('#patient_name_display').val(response.patient_name);
                                $('#patient_id').val(response.patient_id);
                                
                                // Trigger change event to update patient details if needed
                                $('#patient_id').trigger('change');
                            } else {
                                console.log('No patient_id in response');
                                // Clear the patient fields
                                $('#patient_name_display').val('');
                                $('#patient_id').val('');
                            }
                        },
                        error: function(xhr) {
                            console.log('Error fetching patient:', xhr.status, xhr.responseJSON ? xhr.responseJSON.error : 'Unknown error');
                            console.log('Response text:', xhr.responseText);
                            // Clear patient fields
                            $('#patient_name_display').val('');
                            $('#patient_id').val('');
                        }
                    });
                } else {
                    console.log('No time slot selected, clearing patient');
                    // Clear patient fields
                    $('#patient_name_display').val('');
                    $('#patient_id').val('');
                }
            });
        });
    </script>
@endpush