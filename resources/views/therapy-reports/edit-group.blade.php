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
                        <li class="breadcrumb-item active">Edit Group Therapy Session</li>
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
                    <form method="POST" action="{{ route('group-therapy.update', $therapyReport->id) }}" class="form-material form-horizontal">
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
                        
                        <!-- Group Therapy Session Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">Group Therapy Session</h3></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="participant_ids">Participants</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        </div>
                                        <select name="participant_ids[]" class="form-control select2 @error('participant_ids') is-invalid @enderror" id="participant_ids" multiple="multiple" data-placeholder="@lang('Select participants')" style="width: 100%;">
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ (is_array(old('participant_ids')) && in_array($patient->id, old('participant_ids'))) || (is_array($selectedParticipants) && in_array($patient->id, $selectedParticipants)) ? 'selected' : '' }}>{{ $patient->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('participant_ids')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                
                                <div class="form-group">
                                    <label for="group_session_summary">Session Summary</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        </div>
                                        <textarea name="group_session_summary" class="form-control @error('group_session_summary') is-invalid @enderror" id="group_session_summary" rows="5" placeholder="Describe the group session activities, engagement level, and notable responses">{{ old('group_session_summary', $therapyReport->group_session_summary) }}</textarea>
                                        @error('group_session_summary')
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
