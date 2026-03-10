@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('cvi.index') }}">@lang('Child Vitality Index')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Child Vitality Index')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit Child Vitality Index')</h3>
                </div>
                <div class="card-body">
                    <form id="cviForm" class="form-material form-horizontal" action="{{ route('cvi.update', $cvi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_id">@lang('Patient') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <select name="patient_id" id="patient_id" class="patient-select form-control custom-width-100 select2 @error('patient_id') is-invalid @enderror" required>
                                            <option value="">--@lang('Select Patient')--</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}" @if($patient->id == old('patient_id', $cvi->patient_id)) selected @endif>{{ $patient->name }}</option>
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
                                    <label for="date">@lang('Date') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="date" id="date" class="form-control flatpickr @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', $cvi->date) }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Child Vitality Index Questions')</h3></div>
                            <div class="card-body">
                                <p class="text-muted">@lang('Please answer the following questions with "YES" or "NO".')</p>
                                
                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Health & Medical')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child is acutely malnourished, clinically underweight, or displaying symptoms of significant nutritional deficiency?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nutritionalStatus" id="nutritionalStatusYes" value="yes" {{ old('nutritionalStatus', $cvi->nutritionalStatus) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nutritionalStatusYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nutritionalStatus" id="nutritionalStatusNo" value="no" {{ old('nutritionalStatus', $cvi->nutritionalStatus) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nutritionalStatusNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child developmentally delayed?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="developmentallyDelayed" id="devDelayedYes" value="yes" {{ old('developmentallyDelayed', $cvi->developmentallyDelayed) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="devDelayedYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="developmentallyDelayed" id="devDelayedNo" value="no" {{ old('developmentallyDelayed', $cvi->developmentallyDelayed) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="devDelayedNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child living with any chronic or advanced medical conditions?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="chronicConditions" id="chronicConditionsYes" value="yes" {{ old('chronicConditions', $cvi->chronicConditions) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chronicConditionsYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="chronicConditions" id="chronicConditionsNo" value="no" {{ old('chronicConditions', $cvi->chronicConditions) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chronicConditionsNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child facing any behavioral or mental health ailments?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="mentalHealth" id="mentalHealthYes" value="yes" {{ old('mentalHealth', $cvi->mentalHealth) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mentalHealthYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="mentalHealth" id="mentalHealthNo" value="no" {{ old('mentalHealth', $cvi->mentalHealth) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mentalHealthNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child experiencing physical disabilities or mobility difficulties?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="physicalDisabilities" id="physicalDisabilitiesYes" value="yes" {{ old('physicalDisabilities', $cvi->physicalDisabilities) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="physicalDisabilitiesYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="physicalDisabilities" id="physicalDisabilitiesNo" value="no" {{ old('physicalDisabilities', $cvi->physicalDisabilities) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="physicalDisabilitiesNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child limited in age appropriate communication abilities?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="communicationAbilities" id="communicationAbilitiesYes" value="yes" {{ old('communicationAbilities', $cvi->communicationAbilities) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="communicationAbilitiesYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="communicationAbilities" id="communicationAbilitiesNo" value="no" {{ old('communicationAbilities', $cvi->communicationAbilities) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="communicationAbilitiesNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child having an incomplete or undocumented vaccine status?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="vaccineStatus" id="vaccineStatusYes" value="yes" {{ old('vaccineStatus', $cvi->vaccineStatus) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="vaccineStatusYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="vaccineStatus" id="vaccineStatusNo" value="no" {{ old('vaccineStatus', $cvi->vaccineStatus) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="vaccineStatusNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Socioeconomic & Living Conditions')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child subject to any familial instability such as maternal death, parent with mental illness, incarcerated parent or caregiver, single parent, or total orphan under informal community care?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="familialInstability" id="familialInstabilityYes" value="yes" {{ old('familialInstability', $cvi->familialInstability) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="familialInstabilityYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="familialInstability" id="familialInstabilityNo" value="no" {{ old('familialInstability', $cvi->familialInstability) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="familialInstabilityNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child affected by food or monetary poverty?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="poverty" id="povertyYes" value="yes" {{ old('poverty', $cvi->poverty) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="povertyYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="poverty" id="povertyNo" value="no" {{ old('poverty', $cvi->poverty) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="povertyNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child institutionalized in an orphanage or similar communal care facility?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="institutionalized" id="institutionalizedYes" value="yes" {{ old('institutionalized', $cvi->institutionalized) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="institutionalizedYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="institutionalized" id="institutionalizedNo" value="no" {{ old('institutionalized', $cvi->institutionalized) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="institutionalizedNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child housed in an insecure temporary shelter and/or vulnerable to extreme weather or natural disasters?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="insecureShelter" id="insecureShelterYes" value="yes" {{ old('insecureShelter', $cvi->insecureShelter) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="insecureShelterYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="insecureShelter" id="insecureShelterNo" value="no" {{ old('insecureShelter', $cvi->insecureShelter) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="insecureShelterNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Safety & Social Factors')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child having a history of psychological trauma such as parental death, severe injury, child marriage, FGM, suspected or known rape, or physical abuse?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="psychologicalTrauma" id="psychologicalTraumaYes" value="yes" {{ old('psychologicalTrauma', $cvi->psychologicalTrauma) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="psychologicalTraumaYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="psychologicalTrauma" id="psychologicalTraumaNo" value="no" {{ old('psychologicalTrauma', $cvi->psychologicalTrauma) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="psychologicalTraumaNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child bed-ridden, lacking of adult supervision, or experiencing social isolation?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="socialIsolation" id="socialIsolationYes" value="yes" {{ old('socialIsolation', $cvi->socialIsolation) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="socialIsolationYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="socialIsolation" id="socialIsolationNo" value="no" {{ old('socialIsolation', $cvi->socialIsolation) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="socialIsolationNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child facing any gender, ethnic, religious, medical, or cultural discrimination?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="discrimination" id="discriminationYes" value="yes" {{ old('discrimination', $cvi->discrimination) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="discriminationYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="discrimination" id="discriminationNo" value="no" {{ old('discrimination', $cvi->discrimination) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="discriminationNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child residing in an area of active war, oppression, or conflict?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="conflictArea" id="conflictAreaYes" value="yes" {{ old('conflictArea', $cvi->conflictArea) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="conflictAreaYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="conflictArea" id="conflictAreaNo" value="no" {{ old('conflictArea', $cvi->conflictArea) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="conflictAreaNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Environmental & Education')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child lacking access to healthcare either by restraints of proximity or finance?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="healthcareAccess" id="healthcareAccessYes" value="yes" {{ old('healthcareAccess', $cvi->healthcareAccess) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="healthcareAccessYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="healthcareAccess" id="healthcareAccessNo" value="no" {{ old('healthcareAccess', $cvi->healthcareAccess) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="healthcareAccessNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child dependent on an untreated or insufficient water source?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waterSource" id="waterSourceYes" value="yes" {{ old('waterSource', $cvi->waterSource) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="waterSourceYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waterSource" id="waterSourceNo" value="no" {{ old('waterSource', $cvi->waterSource) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="waterSourceNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child living without a sanitary toilet or essential hygiene access?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sanitation" id="sanitationYes" value="yes" {{ old('sanitation', $cvi->sanitation) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sanitationYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sanitation" id="sanitationNo" value="no" {{ old('sanitation', $cvi->sanitation) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sanitationNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child inactive or unenrolled in school?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="schoolStatus" id="schoolStatusYes" value="yes" {{ old('schoolStatus', $cvi->schoolStatus) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="schoolStatusYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="schoolStatus" id="schoolStatusNo" value="no" {{ old('schoolStatus', $cvi->schoolStatus) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="schoolStatusNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1">@lang('Is the child situated in an area of active disease outbreaks affecting region/community?')</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="diseaseOutbreaks" id="diseaseOutbreaksYes" value="yes" {{ old('diseaseOutbreaks', $cvi->diseaseOutbreaks) == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="diseaseOutbreaksYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="diseaseOutbreaks" id="diseaseOutbreaksNo" value="no" {{ old('diseaseOutbreaks', $cvi->diseaseOutbreaks) == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="diseaseOutbreaksNo">@lang('NO')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="score">@lang('Calculated Score')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                                                </div>
                                                <input type="text" id="score_display" class="form-control" value="{{ $cvi->score }}" readonly>
                                                <input type="hidden" name="score" id="score" value="{{ $cvi->score }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="vitality_score">@lang('Vitality Score Interpretation')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-chart-bar"></i></span>
                                                </div>
                                                <input type="text" id="vitality_score_display" class="form-control" value="{{ $cvi->vitality_score }}" readonly>
                                                <input type="hidden" name="vitality_score" id="vitality_score" value="{{ $cvi->vitality_score }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="notes">@lang('Notes')</label>
                                    <div class="input-group mb-3">
                                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4" placeholder="@lang('Enter any additional notes')">{{ old('notes', $cvi->notes) }}</textarea>
                                        @error('notes')
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
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('cvi.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Function to calculate score
        function calculateScore() {
            let score = 0;
            
            // Health & Medical section
            if (document.querySelector('input[name="nutritionalStatus"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="developmentallyDelayed"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="chronicConditions"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="mentalHealth"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="physicalDisabilities"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="communicationAbilities"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="vaccineStatus"]:checked')?.value === 'no') score += 5;
            
            // Socioeconomic & Living Conditions section
            if (document.querySelector('input[name="familialInstability"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="poverty"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="institutionalized"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="insecureShelter"]:checked')?.value === 'no') score += 5;
            
            // Safety & Social Factors section
            if (document.querySelector('input[name="psychologicalTrauma"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="socialIsolation"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="discrimination"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="conflictArea"]:checked')?.value === 'no') score += 5;
            
            // Environmental & Education section
            if (document.querySelector('input[name="healthcareAccess"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="waterSource"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="sanitation"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="schoolStatus"]:checked')?.value === 'no') score += 5;
            if (document.querySelector('input[name="diseaseOutbreaks"]:checked')?.value === 'no') score += 5;
            
            // Update score display and hidden field
            document.getElementById('score_display').value = score;
            document.getElementById('score').value = score;
            
            // Determine vitality score interpretation
            let vitalityScore = '';
            if (score <= 59) {
                vitalityScore = 'Critical Vitality Score';
            } else if (score <= 79) {
                vitalityScore = 'Low Child Vitality Score';
            } else if (score <= 89) {
                vitalityScore = 'Moderate Vitality Score';
            } else {
                vitalityScore = 'High Vitality Score';
            }

            
            // Update vitality score display and hidden field
            document.getElementById('vitality_score_display').value = vitalityScore;
            document.getElementById('vitality_score').value = vitalityScore;
        }
        
        // Add event listeners to all radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', calculateScore);
            });
            
            // Calculate initial score
            calculateScore();
        });
    </script>
@endsection
@push('footer')
        <script src="{{ asset('assets/js/custom/patient-details.js') }}"></script>
@endpush