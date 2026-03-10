@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('radiology-requests.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('radiology-requests.index') }}">@lang('Radiology Request List')</a></li>
                        <li class="breadcrumb-item active">@lang('Add Radiology Request')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Add Radiology Request')</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('radiology-requests.store') }}" method="POST">
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
                                    <label for="provider">Conducted by</label>
                                    <input type="text" id="provider" class="form-control" value="{{ $currentUser->name }}" readonly>
                                    <input type="hidden" name="provider_id" value="{{ $currentUser->id }}">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Examination Requested')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mr-2" type="checkbox" name="examination_type[]" value="xray" @if(is_array(old('examination_type')) && in_array('xray', old('examination_type'))) checked @endif>
                                        <label class="form-check-label">@lang('X-Ray')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mr-2" type="checkbox" name="examination_type[]" value="ultrasound" @if(is_array(old('examination_type')) && in_array('ultrasound', old('examination_type'))) checked @endif>
                                        <label class="form-check-label">@lang('Ultrasound')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mr-2" type="checkbox" name="examination_type[]" value="MRI" @if(is_array(old('examination_type')) && in_array('MRI', old('examination_type'))) checked @endif>
                                        <label class="form-check-label">@lang('MRI')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mr-2" type="checkbox" name="examination_type[]" value="CT" @if(is_array(old('examination_type')) && in_array('CT', old('examination_type'))) checked @endif>
                                        <label class="form-check-label">@lang('CT')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="examination_details">@lang('Examination Details (including body organs to be imaged)')</label>
                                    <textarea name="examination_details" id="examination_details" class="form-control @error('examination_details') is-invalid @enderror" rows="3">{{ old('examination_details') }}</textarea>
                                    @error('examination_details')
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
                                    <label for="relevant_clinical_information">@lang('Relevant Clinical Information')</label>
                                    <textarea name="relevant_clinical_information" id="relevant_clinical_information" class="form-control @error('relevant_clinical_information') is-invalid @enderror" rows="3">{{ old('relevant_clinical_information') }}</textarea>
                                    @error('relevant_clinical_information')
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
                                    <label for="reason_for_investigation">@lang('Reason for Radiological Investigation')</label>
                                    <textarea name="reason_for_investigation" id="reason_for_investigation" class="form-control @error('reason_for_investigation') is-invalid @enderror" rows="3">{{ old('reason_for_investigation') }}</textarea>
                                    @error('reason_for_investigation')
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
                                        <a href="{{ route('radiology-requests.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
@endpush