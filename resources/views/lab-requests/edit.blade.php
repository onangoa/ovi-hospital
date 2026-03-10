@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('lab-requests.index') }}">@lang('Lab Request')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Lab Request')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit Lab Request')</h3>
                </div>
                <div class="card-body">
                    <form class="form-material form-horizontal" action="{{ route('lab-requests.update', $labRequest) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="clinician_id" value="{{ old('clinician_id', $labRequest->clinician_id) }}">
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="card mb-4 form-card">
                            <div class="card-header"><h3 class="card-title"><h3 class="card-title">@lang('Patient Details')</h3></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="patient_id">@lang('Patient Name') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <select name="patient_id" id="patient_id" class="patient-select form-control custom-width-100 select2 @error('patient_id') is-invalid @enderror" required>
                                                    <option value="">--@lang('Select Patient')--</option>
                                                    @foreach ($patients as $patient)
                                                        <option value="{{ $patient->id }}" @if($patient->id == old('patient_id', $labRequest->patient_id)) selected @endif>{{ $patient->name }}</option>
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="specimen">@lang('Specimen')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-vial"></i></span>
                                                </div>
                                                <textarea name="specimen" id="specimen" class="form-control @error('specimen') is-invalid @enderror" rows="3" placeholder="@lang('Specimen Details')">{{ old('specimen', $labRequest->specimen) }}</textarea>
                                                @error('specimen')
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


                        <div class="card mb-4 form-card">
                            <div class="card-header"><h3 class="card-title"><h3 class="card-title">@lang('Specimen Destination')</h3></div>
                            <div class="card-body">
                                <p class="text-muted">@lang('Tick appropriate box')</p>
                                <div class="row mb-3">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="blood_bank" id="bloodBank" value="1" {{ old('blood_bank', $labRequest->blood_bank) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bloodBank">@lang('Blood Bank')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="histology" id="histology" value="1" {{ old('histology', $labRequest->histology) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="histology">@lang('Histology/Cytology')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="serology" id="serology" value="1" {{ old('serology', $labRequest->serology) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="serology">@lang('Serology')</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="haematology" id="haematology" value="1" {{ old('haematology', $labRequest->haematology) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="haematology">@lang('Haematology')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="bacteriology" id="bacteriology" value="1" {{ old('bacteriology', $labRequest->bacteriology) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bacteriology">@lang('Bacteriology')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="parasitology" id="parasitology" value="1" {{ old('parasitology', $labRequest->parasitology) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="parasitology">@lang('Parasitology')</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="biochemistry" id="biochemistry" value="1" {{ old('biochemistry', $labRequest->biochemistry) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="biochemistry">@lang('Biochemistry')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="other_destination">@lang('Other')</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-ellipsis-h"></i></span>
                                            </div>
                                            <textarea name="other_destination" id="other_destination" class="form-control @error('other_destination') is-invalid @enderror" rows="3" placeholder="@lang('Other')">{{ old('other_destination', $labRequest->other_destination) }}</textarea>
                                            @error('other_destination')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                </div>
                            </div>
                        </div>

                        <div id="vital-signs-container">
                                @if($labRequest->vital_signs)
                                    @include('components.vital-signs', ['vital_signs' => $labRequest->vital_signs, 'form_name' => 'lab_request'])
                                @else
                                    @include('components.vital-signs', ['form_name' => 'lab_request'])
                                @endif
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header"><h3 class="card-title"><h3 class="card-title">@lang('Investigation and Diagnosis')</h3></div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="investigation_requested">@lang('Investigation Requested')</label>
                                    <textarea name="investigation_requested" class="form-control @error('investigation_requested') is-invalid @enderror" id="investigation_requested" rows="3" placeholder="@lang('Investigation Requested')">{{ old('investigation_requested', $labRequest->investigation_requested) }}</textarea>
                                    @error('investigation_requested')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="differential_diagnosis">@lang('Differential Diagnosis')</label>
                                    <textarea name="differential_diagnosis" class="form-control @error('differential_diagnosis') is-invalid @enderror" id="differential_diagnosis" rows="3" placeholder="@lang('Differential Diagnosis')">{{ old('differential_diagnosis', $labRequest->differential_diagnosis) }}</textarea>
                                    @error('differential_diagnosis')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-4 form-card">
                            <div class="card-header"><h3 class="card-title"><h3 class="card-title">@lang('Requesting Clinician')</h3></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clinician_name">@lang('Name')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                                </div>
                                                <input type="text" name="clinician_name" id="clinician_name" class="form-control @error('clinician_name') is-invalid @enderror" placeholder="@lang('Name')" value="{{ old('clinician_name', $labRequest->clinician_name) }}" readonly>
                                                @error('clinician_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="request_date">@lang('Date')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                                </div>
                                                <input type="text" name="request_date" id="request_date" class="form-control @error('request_date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('request_date', $labRequest->request_date ? $labRequest->request_date->format('Y-m-d') : '') }}" readonly>
                                                @error('request_date')
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
                                        <a href="{{ route('lab-requests.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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