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
                        <li class="breadcrumb-item active">@lang('Add Ward Round Note')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Add Ward Round Note')</h3>
                </div>
                <div class="card-body">
                    <form class="form-material form-horizontal" action="{{ route('ward-round-notes.store') }}" method="POST">
                        @csrf
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
                                                        <option value="{{ $patient->id }}" @if($patient->id == old('patient_id')) selected @endif>{{ $patient->name }}</option>
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
                                                <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', now()->format('Y-m-d')) }}" readonly>

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
                                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                                <input type="hidden" name="attending_clinician" id="attending_clinician" value="{{ Auth::id() }}">
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
                                <h5>@lang('Vital Signs')</h5>
                                <div id="vital-signs-container"></div>
                                <div class="table-responsive mb-4"></div>

                                <div class="mb-3">
                                    <label for="main_complaints">@lang('Main Complaints')</label>
                                    <textarea name="main_complaints" class="form-control @error('main_complaints') is-invalid @enderror" id="main_complaints" rows="3" placeholder="@lang('Main Complaints')">{{ old('main_complaints') }}</textarea>
                                    @error('main_complaints')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="examination_findings">@lang('Examination Findings')</label>
                                    <textarea name="examination_findings" class="form-control @error('examination_findings') is-invalid @enderror" id="examination_findings" rows="3" placeholder="@lang('Examination Findings')">{{ old('examination_findings') }}</textarea>
                                    @error('examination_findings')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Systemic Assessment')</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>@lang('System')</th>
                                                <th>@lang('Normal/Abnormal')</th>
                                                <th>@lang('Comments')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>@lang('Respiratory')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="respiratory" id="respiratoryNormal" value="normal" {{ old('respiratory') == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="respiratoryNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="respiratory" id="respiratoryAbnormal" value="abnormal" {{ old('respiratory') == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="respiratoryAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="respiratory_comments" class="form-control" value="{{ old('respiratory_comments') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Cardiovascular')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="cardiovascular" id="cardiovascularNormal" value="normal" {{ old('cardiovascular') == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="cardiovascularNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="cardiovascular" id="cardiovascularAbnormal" value="abnormal" {{ old('cardiovascular') == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="cardiovascularAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="cardiovascular_comments" class="form-control" value="{{ old('cardiovascular_comments') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Neurological')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="neurological" id="neurologicalNormal" value="normal" {{ old('neurological') == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="neurologicalNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="neurological" id="neurologicalAbnormal" value="abnormal" {{ old('neurological') == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="neurologicalAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="neurological_comments" class="form-control" value="{{ old('neurological_comments') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Gastrointestinal')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gastrointestinal" id="gastrointestinalNormal" value="normal" {{ old('gastrointestinal') == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gastrointestinalNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gastrointestinal" id="gastrointestinalAbnormal" value="abnormal" {{ old('gastrointestinal') == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gastrointestinalAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="gastrointestinal_comments" class="form-control" value="{{ old('gastrointestinal_comments') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Musculoskeletal')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="musculoskeletal" id="musculoskeletalNormal" value="normal" {{ old('musculoskeletal') == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="musculoskeletalNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="musculoskeletal" id="musculoskeletalAbnormal" value="abnormal" {{ old('musculoskeletal') == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="musculoskeletalAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="musculoskeletal_comments" class="form-control" value="{{ old('musculoskeletal_comments') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Skin/Wounds')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="skin" id="skinNormal" value="normal" {{ old('skin') == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="skinNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="skin" id="skinAbnormal" value="abnormal" {{ old('skin') == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="skinAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="skin_comments" class="form-control" value="{{ old('skin_comments') }}"></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                    <textarea name="medications_changes" class="form-control @error('medications_changes') is-invalid @enderror" id="medications_changes" rows="3" placeholder="@lang('Medications/Changes')">{{ old('medications_changes') }}</textarea>
                                    @error('medications_changes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="procedures_interventions">@lang('Procedures/Interventions')</label>
                                    <textarea name="procedures_interventions" class="form-control @error('procedures_interventions') is-invalid @enderror" id="procedures_interventions" rows="3" placeholder="@lang('Procedures/Interventions')">{{ old('procedures_interventions') }}</textarea>
                                    @error('procedures_interventions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pending_tests">@lang('Pending Tests')</label>
                                    <textarea name="pending_tests" class="form-control @error('pending_tests') is-invalid @enderror" id="pending_tests" rows="3" placeholder="@lang('Pending Tests')">{{ old('pending_tests') }}</textarea>
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
                                            <input class="form-check-input" type="radio" name="condition" id="stable" value="stable" {{ old('condition') == 'stable' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="stable">@lang('Stable')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition" id="improving" value="improving" {{ old('condition') == 'improving' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="improving">@lang('Improving')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="condition" id="deteriorating" value="deteriorating" {{ old('condition') == 'deteriorating' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="deteriorating">@lang('Deteriorating')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="next_steps">@lang('Next Steps')</label>
                                    <textarea name="next_steps" class="form-control @error('next_steps') is-invalid @enderror" id="next_steps" rows="3" placeholder="@lang('Next Steps')">{{ old('next_steps') }}</textarea>
                                    @error('next_steps')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
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
