@extends('layouts.layout')
@section('content')
<div class="content-header">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
            <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('therapy-reports.group') }}">Group Therapy Reports</a></li>

                        <li class="breadcrumb-item active">Create Group Therapy Session</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Group Therapy Session Details</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('group-therapy.store') }}" class="form-material form-horizontal">
                        @csrf
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        
                        <!-- Report Details Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">Report Details</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
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
                                            <label for="physiotherapist">Conducted by</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                                </div>
                                                <input type="text" name="physiotherapist" class="form-control" id="physiotherapist" placeholder="Physiotherapist name" value="{{ $currentUser->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Group Therapy Session Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">Group Therapy Session</h3></div>
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
                                                        @foreach($wardAssignments as $assignment)
                                                            @if($assignment->ward && $assignment->start_time && $assignment->end_time)
                                                                <?php
                                                                $startTime = \Carbon\Carbon::parse($assignment->start_time);
                                                                $endTime = \Carbon\Carbon::parse($assignment->end_time);
                                                                $slotString = $startTime->format('g:i A') . ' - ' . $endTime->format('g:i A');
                                                                ?>
                                                                <option value="{{ $slotString }}" {{ old('session_time') == $slotString ? 'selected' : '' }}>
                                                                    {{ $slotString }} - {{ $assignment->ward->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="" disabled>@lang('No ward assignments available for today.')</option>
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
                                    <label for="ward_name">Ward</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <input type="text" name="ward_name" class="form-control @error('ward_id') is-invalid @enderror" id="ward_name" readonly placeholder="Select a time slot to see assigned ward">
                                        <input type="hidden" name="ward_id" id="ward_id">
                                        @error('ward_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="participants_preview">Participants (from selected ward)</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                        <textarea name="participants_preview" class="form-control" id="participants_preview" rows="3" readonly placeholder="Participants will be automatically populated from the selected ward"></textarea>
                                    </div>
                                    <small class="form-text text-info">
                                        <i class="fas fa-info-circle"></i> Participants are automatically loaded from the selected ward. Only active patients (not discharged) will be included.
                                    </small>
                                </div>
                                    </div>
                                </div>

                                
                                <div class="form-group">
                                    <label for="group_session_summary">Session Summary</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        </div>
                                        <textarea name="group_session_summary" class="form-control @error('group_session_summary') is-invalid @enderror" id="group_session_summary" rows="5" placeholder="Describe the group session activities, engagement level, and notable responses">{{ old('group_session_summary') }}</textarea>
                                        @error('group_session_summary')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- End-of-Day Notes & Clean-Up Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">End-of-Day Notes & Clean-Up</h3></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="overall_observations">Overall Observations</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-binoculars"></i></span>
                                        </div>
                                        <textarea name="overall_observations" class="form-control @error('overall_observations') is-invalid @enderror" id="overall_observations" rows="3" placeholder="General trends, key improvements, any concerns for follow-up">{{ old('overall_observations') }}</textarea>
                                        @error('overall_observations')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="equipment_clean_up">Equipment/Room Clean-Up</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-broom"></i></span>
                                        </div>
                                        <textarea name="equipment_clean_up" class="form-control @error('equipment_clean_up') is-invalid @enderror" id="equipment_clean_up" rows="3" placeholder="Any notes on maintenance or supplies needed">{{ old('equipment_clean_up') }}</textarea>
                                        @error('equipment_clean_up')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="additional_comments">Additional Comments</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                        </div>
                                        <textarea name="additional_comments" class="form-control @error('additional_comments') is-invalid @enderror" id="additional_comments" rows="3" placeholder="Any other relevant information">{{ old('additional_comments') }}</textarea>
                                        @error('additional_comments')
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
                                        <a href="{{ route('therapy-reports.group') }}" class="btn btn-outline btn-warning btn-lg">Cancel</a>
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
    <script>
        $(document).ready(function() {
            $('#session_time').on('change', function() {
                const timeSlot = $(this).val();
                console.log('Time slot selected:', timeSlot);
                
                if (timeSlot) {
                    // Fetch ward for the selected time slot
                    $.ajax({
                        url: "{{ route('group-therapy.get-ward-by-slot') }}",
                        method: 'GET',
                        data: { time_slot: timeSlot },
                        beforeSend: function() {
                            console.log('Sending request for time slot:', timeSlot);
                        },
                        success: function(response) {
                            console.log('Response received:', response);
                            if (response.ward_id) {
                                console.log('Setting ward ID:', response.ward_id);
                                console.log('Ward name:', response.ward_name);
                                
                                // Set the ward name and ID in the readonly fields
                                $('#ward_name').val(response.ward_name);
                                $('#ward_id').val(response.ward_id);
                            } else {
                                console.log('No ward_id in response');
                                // Clear the ward fields
                                $('#ward_name').val('');
                                $('#ward_id').val('');
                            }
                        },
                        error: function(xhr) {
                            console.log('Error fetching ward:', xhr.status, xhr.responseJSON ? xhr.responseJSON.error : 'Unknown error');
                            console.log('Response text:', xhr.responseText);
                            // Clear ward fields
                            $('#ward_name').val('');
                            $('#ward_id').val('');
                        }
                    });
                } else {
                    console.log('No time slot selected, clearing ward');
                    // Clear ward fields
                    $('#ward_name').val('');
                    $('#ward_id').val('');
                }
            });
        });
    </script>
@endpush
@push('footer')
    <script>
        $(document).ready(function() {
            $('#session_time').on('change', function() {
                const timeSlot = $(this).val();
                console.log('Time slot selected:', timeSlot);
                
                if (timeSlot) {
                    // Fetch ward for selected time slot
                    $.ajax({
                        url: "{{ route('group-therapy.get-ward-by-slot') }}",
                        method: 'GET',
                        data: { time_slot: timeSlot },
                        beforeSend: function() {
                            console.log('Sending request for time slot:', timeSlot);
                        },
                        success: function(response) {
                            console.log('Response received:', response);
                            if (response.ward_id) {
                                console.log('Setting ward ID:', response.ward_id);
                                console.log('Ward name:', response.ward_name);
                                
                                // Set to ward name and ID in readonly fields
                                $('#ward_name').val(response.ward_name);
                                $('#ward_id').val(response.ward_id);
                                
                                // Fetch participants for this ward
                                fetchWardParticipants(response.ward_id);
                            } else {
                                console.log('No ward_id in response');
                                // Clear ward fields
                                $('#ward_name').val('');
                                $('#ward_id').val('');
                                $('#participants_preview').val('');
                            }
                        },
                        error: function(xhr) {
                            console.log('Error fetching ward:', xhr.status, xhr.responseJSON ? xhr.responseJSON.error : 'Unknown error');
                            console.log('Response text:', xhr.responseText);
                            // Clear ward fields
                            $('#ward_name').val('');
                            $('#ward_id').val('');
                            $('#participants_preview').val('');
                        }
                    });
                } else {
                    console.log('No time slot selected, clearing ward');
                    // Clear ward fields
                    $('#ward_name').val('');
                    $('#ward_id').val('');
                    $('#participants_preview').val('');
                }
            });
            
            // Function to fetch participants for a ward
            function fetchWardParticipants(wardId) {
                if (!wardId) {
                    $('#participants_preview').val('');
                    return;
                }
                
                $.ajax({
                    url: "/api/wards/" + wardId + "/patients",
                    method: 'GET',
                    beforeSend: function() {
                        console.log('Fetching patients for ward:', wardId);
                    },
                    success: function(patients) {
                        console.log('Patients received:', patients);
                        if (patients && patients.length > 0) {
                            const participantNames = patients.map(p => p.name).join(', ');
                            $('#participants_preview').val(participantNames);
                        } else {
                            $('#participants_preview').val('No active patients in this ward');
                        }
                    },
                    error: function(xhr) {
                        console.log('Error fetching patients:', xhr.status);
                        $('#participants_preview').val('Error loading participants');
                    }
                });
            }
        });
    </script>
@endpush
