@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('medical-referrals.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('medical-referrals.index') }}">@lang('Medical Referral List')</a></li>
                        <li class="breadcrumb-item active">@lang('Add Medical Referral')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Add Medical Referral')</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('medical-referrals.store') }}" method="POST">
                        @csrf
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_id">@lang('Patient')</label>
                                    <select name="patient_id" id="patient_id" class="patient-select form-control @error('patient_id') is-invalid @enderror">
                                        <option value="">@lang('Select Patient')</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" @if(old('patient_id') == $patient->id) selected @endif>{{ $patient->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referring_doctor_name">@lang('Conducted by')</label>
                                    <input type="text" class="form-control @error('referring_doctor_name') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly>
                                    <input type="hidden" name="referring_doctor_name" value="{{ Auth::user()->id }}">
                                    @error('referring_doctor_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="reason_for_referral">@lang('Reason for referral')</label>
                                    <textarea name="reason_for_referral" id="reason_for_referral" class="form-control @error('reason_for_referral') is-invalid @enderror" rows="3">{{ old('reason_for_referral') }}</textarea>
                                    @error('reason_for_referral')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="chief_complaint">@lang('Chief complaint')</label>
                                    <textarea name="chief_complaint" id="chief_complaint" class="form-control @error('chief_complaint') is-invalid @enderror" rows="3">{{ old('chief_complaint') }}</textarea>
                                    @error('chief_complaint')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="patient_brief_history">@lang('Patient Brief history')</label>
                                    <textarea name="patient_brief_history" id="patient_brief_history" class="form-control @error('patient_brief_history') is-invalid @enderror" rows="3">{{ old('patient_brief_history') }}</textarea>
                                    @error('patient_brief_history')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="vital-signs-container"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="lab_investigation_done">@lang('Lab investigation done before referral')</label>
                                    <textarea name="lab_investigation_done" id="lab_investigation_done" class="form-control @error('lab_investigation_done') is-invalid @enderror" rows="3">{{ old('lab_investigation_done') }}</textarea>
                                    @error('lab_investigation_done')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="treatment_done">@lang('Treatment done before referral')</label>
                                    <textarea name="treatment_done" id="treatment_done" class="form-control @error('treatment_done') is-invalid @enderror" rows="3">{{ old('treatment_done') }}</textarea>
                                    @error('treatment_done')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('medical-referrals.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
@push('footer')
    <script src="{{ asset('assets/js/custom/patient-details.js') }}"></script>
    <script src="{{ asset('assets/js/custom/vital-signs.js') }}"></script>
@endpush
