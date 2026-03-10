@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('therapy-reports.index') }}">@lang('Therapy Reports')</a></li>
                        <li class="breadcrumb-item active">@lang('Add Therapy Report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Daily Physical Therapy Client Report')</h3>
                </div>
                <div class="card-body">
                    <form id="therapyReportForm" class="form-material form-horizontal" action="{{ route('therapy-reports.store') }}" method="POST">
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
                                                <input type="text" name="date" id="date" class="form-control flatpickr @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date') }}">
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
                                            <label for="physiotherapist_signature">@lang('Physiotherapist Signature')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                                </div>
                                                <input type="text" name="physiotherapist_signature" id="physiotherapist_signature" class="form-control @error('physiotherapist_signature') is-invalid @enderror" placeholder="@lang('Physiotherapist Signature')" value="{{ old('physiotherapist_signature') }}">
                                                @error('physiotherapist_signature')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Individual Therapy Sessions Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Individual Therapy Sessions')</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-muted">@lang('Provide patient name, diagnosis, and a brief summary of progress, exercises performed, patient response, and any concerns or improvements noted.')</p>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patient_name">@lang('Patient Name')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <input type="text" name="patient_name" id="patient_name" class="form-control @error('patient_name') is-invalid @enderror" placeholder="@lang('Patient Name')" value="{{ old('patient_name') }}">
                                                @error('patient_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="session_time">@lang('Session Time')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                </div>
                                                <select name="session_time" id="session_time" class="form-control @error('session_time') is-invalid @enderror">
                                                    <option value="">@lang('Select Session Time')</option>
                                                    <option value="8:00 AM" {{ old('session_time') == '8:00 AM' ? 'selected' : '' }}>8:00 AM</option>
                                                    <option value="9:00 AM" {{ old('session_time') == '9:00 AM' ? 'selected' : '' }}>9:00 AM</option>
                                                    <option value="10:00 AM" {{ old('session_time') == '10:00 AM' ? 'selected' : '' }}>10:00 AM</option>
                                                    <option value="11:00 AM" {{ old('session_time') == '11:00 AM' ? 'selected' : '' }}>11:00 AM</option>
                                                    <option value="1:00 PM" {{ old('session_time') == '1:00 PM' ? 'selected' : '' }}>1:00 PM</option>
                                                    <option value="2:00 PM" {{ old('session_time') == '2:00 PM' ? 'selected' : '' }}>2:00 PM</option>
                                                </select>
                                                @error('session_time')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="session_summary">@lang('Session Summary')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                </div>
                                                <textarea name="session_summary" id="session_summary" class="form-control @error('session_summary') is-invalid @enderror" rows="5" placeholder="@lang('Session Summary')">{{ old('session_summary') }}</textarea>
                                                @error('session_summary')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group Therapy Session Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Group Therapy Session')</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="group_participants">@lang('Participants')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                </div>
                                                <textarea name="group_participants" id="group_participants" class="form-control @error('group_participants') is-invalid @enderror" rows="2" placeholder="@lang('List Patient Names')">{{ old('group_participants') }}</textarea>
                                                @error('group_participants')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="group_session_summary">@lang('Session Summary')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                </div>
                                                <textarea name="group_session_summary" id="group_session_summary" class="form-control @error('group_session_summary') is-invalid @enderror" rows="3" placeholder="@lang('Activities performed, group engagement, notable patient responses, any challenges or progress')">{{ old('group_session_summary') }}</textarea>
                                                @error('group_session_summary')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- End-of-Day Notes & Clean-Up Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('End-of-Day Notes & Clean-Up')</h3></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="overall_observations">@lang('Overall Observations')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                </div>
                                                <textarea name="overall_observations" id="overall_observations" class="form-control @error('overall_observations') is-invalid @enderror" rows="3" placeholder="@lang('General trends, key improvements, any concerns for follow-up')">{{ old('overall_observations') }}</textarea>
                                                @error('overall_observations')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="equipment_clean_up">@lang('Equipment/Room Clean-Up')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-broom"></i></span>
                                                </div>
                                                <textarea name="equipment_clean_up" id="equipment_clean_up" class="form-control @error('equipment_clean_up') is-invalid @enderror" rows="2" placeholder="@lang('Any notes on maintenance or supplies needed')">{{ old('equipment_clean_up') }}</textarea>
                                                @error('equipment_clean_up')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="additional_comments">@lang('Additional Comments')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                                </div>
                                                <textarea name="additional_comments" id="additional_comments" class="form-control @error('additional_comments') is-invalid @enderror" rows="3" placeholder="@lang('Additional Comments')">{{ old('additional_comments') }}</textarea>
                                                @error('additional_comments')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('therapy-reports.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection