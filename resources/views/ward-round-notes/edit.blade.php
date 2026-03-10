@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('ward-round-notes.index') }}">@lang('Ward Round Notes')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Ward Round Note')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit Ward Round Note')</h3>
                </div>
                <div class="card-body">
                    <form class="form-material form-horizontal" action="{{ route('ward-round-notes.update', $wardRoundNote) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Patient Details')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patient_id">@lang('Patient Name') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <select name="patient_id" id="patient_id" class="patient-select form-control custom-width-100 select2 @error('patient_id') is-invalid @enderror" required>
                                                    <option value="">--@lang('Select Patient')--</option>
                                                    @foreach ($patients as $patient)
                                                        <option value="{{ $patient->id }}" @if($patient->id == old('patient_id', $wardRoundNote->patient_id)) selected @endif>{{ $patient->name }}</option>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">@lang('Date')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                                </div>
                                                <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', $wardRoundNote->date ? $wardRoundNote->date->format('Y-m-d') : '') }}" readonly>
                                                @error('date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="attending_clinician">@lang('Conducted by')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $wardRoundNote->attendingClinician->name ?? '' }}" readonly>
                                                <input type="hidden" name="attending_clinician" value="{{ $wardRoundNote->attending_clinician }}">
                                                @error('attending_clinician')
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
                            <div class="card-header">
                                <h3 class="card-title">@lang('Current Status')</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="main_complaints">@lang('Main Complaints')</label>
                                    <textarea name="main_complaints" class="form-control @error('main_complaints') is-invalid @enderror" id="main_complaints" rows="3" placeholder="@lang('Main Complaints')">{{ old('main_complaints', $wardRoundNote->main_complaints) }}</textarea>
                                    @error('main_complaints')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="examination_findings">@lang('Examination Findings')</label>
                                    <textarea name="examination_findings" class="form-control @error('examination_findings') is-invalid @enderror" id="examination_findings" rows="3" placeholder="@lang('Examination Findings')">{{ old('examination_findings', $wardRoundNote->examination_findings) }}</textarea>
                                    @error('examination_findings')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 form-card" >
                                    @if($wardRoundNote->vital_signs)
                                        @include('components.vital-signs', ['vital_signs' => $wardRoundNote->vital_signs, 'form_name' => 'ward_round_note'])
                                    @else
                                        @include('components.vital-signs', ['form_name' => 'ward_round_note'])
                                    @endif
                        </div>
                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Systemic Assessment')</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    {{-- table stays the same --}}
                                    @include('partials.systemic-assessment')
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Plan and Updates')</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="medications_changes">@lang('Medications/Changes')</label>
                                    <textarea name="medications_changes" class="form-control @error('medications_changes') is-invalid @enderror" id="medications_changes" rows="3" placeholder="@lang('Medications/Changes')">{{ old('medications_changes', $wardRoundNote->medications_changes) }}</textarea>
                                    @error('medications_changes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="procedures_interventions">@lang('Procedures/Interventions')</label>
                                    <textarea name="procedures_interventions" class="form-control @error('procedures_interventions') is-invalid @enderror" id="procedures_interventions" rows="3" placeholder="@lang('Procedures/Interventions')">{{ old('procedures_interventions', $wardRoundNote->procedures_interventions) }}</textarea>
                                    @error('procedures_interventions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pending_tests">@lang('Pending Tests')</label>
                                    <textarea name="pending_tests" class="form-control @error('pending_tests') is-invalid @enderror" id="pending_tests" rows="3" placeholder="@lang('Pending Tests')">{{ old('pending_tests', $wardRoundNote->pending_tests) }}</textarea>
                                    @error('pending_tests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Progress and Next Steps')</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">@lang('Condition')</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition" id="stable" value="stable" {{ old('condition', $wardRoundNote->condition) == 'stable' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="stable">@lang('Stable')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition" id="improving" value="improving" {{ old('condition', $wardRoundNote->condition) == 'improving' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="improving">@lang('Improving')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition" id="deteriorating" value="deteriorating" {{ old('condition', $wardRoundNote->condition) == 'deteriorating' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="deteriorating">@lang('Deteriorating')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="next_steps">@lang('Next Steps')</label>
                                    <textarea name="next_steps" class="form-control @error('next_steps') is-invalid @enderror" id="next_steps" rows="3" placeholder="@lang('Next Steps')">{{ old('next_steps', $wardRoundNote->next_steps) }}</textarea>
                                    @error('next_steps')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('ward-round-notes.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
