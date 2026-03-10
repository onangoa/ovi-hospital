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
                        <li class="breadcrumb-item"><a href="{{ route('therapy-reports.index') }}">Therapy Reports</a></li>
                        <li class="breadcrumb-item active">Edit Individual Therapy Session</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Individual Therapy Session Details</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('individual-therapy.update', $therapyReport->id) }}" class="form-material form-horizontal">
                        @csrf
                        @method('PUT')
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
                        
                        <!-- Individual Therapy Session Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">Individual Therapy Session</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="session_time">Session Time</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <select name="session_time" class="form-control @error('session_time') is-invalid @enderror" id="session_time">
                                                    <option value="">Select Time</option>
                                                    <option value="9:00 AM - 10:00 AM" {{ old('session_time', $therapyReport->session_time) == '9:00 AM - 10:00 AM' ? 'selected' : '' }}>9:00 AM - 10:00 AM</option>
                                                    <option value="10:00 AM - 11:00 AM" {{ old('session_time', $therapyReport->session_time) == '10:00 AM - 11:00 AM' ? 'selected' : '' }}>10:00 AM - 11:00 AM</option>
                                                    <option value="11:00 AM - 12:00 PM" {{ old('session_time', $therapyReport->session_time) == '11:00 AM - 12:00 PM' ? 'selected' : '' }}>11:00 AM - 12:00 PM</option>
                                                    <option value="3:00 PM - 4:30 PM" {{ old('session_time', $therapyReport->session_time) == '3:00 PM - 4:30 PM' ? 'selected' : '' }}>3:00 PM - 4:30 PM</option>
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
                                            <label for="patient_id">Patient Name</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <select name="patient_id" class="form-control @error('patient_id') is-invalid @enderror" id="patient_id">
                                                    <option value="">--@lang('Select Patient')--</option>
                                                    @foreach($patients as $patient)
                                                        <option value="{{ $patient->id }}"
                                                            @if(old('patient_id') == $patient->id)
                                                                selected
                                                            @elseif(!old('patient_id') && $therapyReport->patient_id == $patient->id)
                                                                selected
                                                            @endif
                                                        >{{ $patient->name }}</option>
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
                                </div>
                                
                                <div class="form-group">
                                    <label for="session_summary">Session Summary</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        </div>
                                        <textarea name="session_summary" class="form-control @error('session_summary') is-invalid @enderror" id="session_summary" rows="5" placeholder="Describe the session activities and progress">{{ old('session_summary', $therapyReport->session_summary) }}</textarea>
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
                                        <a href="{{ route('therapy-reports.index') }}" class="btn btn-outline btn-warning btn-lg">Cancel</a>
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
@endpush