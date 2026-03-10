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
                        <li class="breadcrumb-item active">@lang('Add Child Vitality Index')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Add Child Vitality Index')</h3>
                </div>
                <div class="card-body">
                    <form id="cviForm" class="form-material form-horizontal" action="{{ route('cvi.store') }}" method="POST">
                        @csrf
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_id">@lang('Patient') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
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
                                    <label for="date">@lang('Date') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', now()->toDateString()) }}" required readonly>

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
                                        <p class="form-label mb-1 @error('nutritionalStatus') text-danger @enderror">@lang('Is the child is acutely malnourished, clinically underweight, or displaying symptoms of significant nutritional deficiency?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('nutritionalStatus') is-invalid @enderror" type="radio" name="nutritionalStatus" id="nutritionalStatusYes" value="yes" {{ old('nutritionalStatus') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nutritionalStatusYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('nutritionalStatus') is-invalid @enderror" type="radio" name="nutritionalStatus" id="nutritionalStatusNo" value="no" {{ old('nutritionalStatus') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nutritionalStatusNo">@lang('NO')</label>
                                        </div>
                                        @error('nutritionalStatus')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('developmentallyDelayed') text-danger @enderror">@lang('Is the child developmentally delayed?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('developmentallyDelayed') is-invalid @enderror" type="radio" name="developmentallyDelayed" id="devDelayedYes" value="yes" {{ old('developmentallyDelayed') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="devDelayedYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('developmentallyDelayed') is-invalid @enderror" type="radio" name="developmentallyDelayed" id="devDelayedNo" value="no" {{ old('developmentallyDelayed') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="devDelayedNo">@lang('NO')</label>
                                        </div>
                                        @error('developmentallyDelayed')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('chronicConditions') text-danger @enderror">@lang('Is the child living with any chronic or advanced medical conditions?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('chronicConditions') is-invalid @enderror" type="radio" name="chronicConditions" id="chronicConditionsYes" value="yes" {{ old('chronicConditions') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chronicConditionsYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('chronicConditions') is-invalid @enderror" type="radio" name="chronicConditions" id="chronicConditionsNo" value="no" {{ old('chronicConditions') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="chronicConditionsNo">@lang('NO')</label>
                                        </div>
                                        @error('chronicConditions')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('mentalHealth') text-danger @enderror">@lang('Is the child facing any behavioral or mental health ailments?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('mentalHealth') is-invalid @enderror" type="radio" name="mentalHealth" id="mentalHealthYes" value="yes" {{ old('mentalHealth') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mentalHealthYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('mentalHealth') is-invalid @enderror" type="radio" name="mentalHealth" id="mentalHealthNo" value="no" {{ old('mentalHealth') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mentalHealthNo">@lang('NO')</label>
                                        </div>
                                        @error('mentalHealth')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('physicalDisabilities') text-danger @enderror">@lang('Is the child experiencing physical disabilities or mobility difficulties?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('physicalDisabilities') is-invalid @enderror" type="radio" name="physicalDisabilities" id="physicalDisabilitiesYes" value="yes" {{ old('physicalDisabilities') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="physicalDisabilitiesYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('physicalDisabilities') is-invalid @enderror" type="radio" name="physicalDisabilities" id="physicalDisabilitiesNo" value="no" {{ old('physicalDisabilities') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="physicalDisabilitiesNo">@lang('NO')</label>
                                        </div>
                                        @error('physicalDisabilities')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('communicationAbilities') text-danger @enderror">@lang('Is the child limited in age appropriate communication abilities?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('communicationAbilities') is-invalid @enderror" type="radio" name="communicationAbilities" id="communicationAbilitiesYes" value="yes" {{ old('communicationAbilities') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="communicationAbilitiesYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('communicationAbilities') is-invalid @enderror" type="radio" name="communicationAbilities" id="communicationAbilitiesNo" value="no" {{ old('communicationAbilities') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="communicationAbilitiesNo">@lang('NO')</label>
                                        </div>
                                        @error('communicationAbilities')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('vaccineStatus') text-danger @enderror">@lang('Is the child having an incomplete or undocumented vaccine status?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('vaccineStatus') is-invalid @enderror" type="radio" name="vaccineStatus" id="vaccineStatusYes" value="yes" {{ old('vaccineStatus') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="vaccineStatusYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('vaccineStatus') is-invalid @enderror" type="radio" name="vaccineStatus" id="vaccineStatusNo" value="no" {{ old('vaccineStatus') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="vaccineStatusNo">@lang('NO')</label>
                                        </div>
                                        @error('vaccineStatus')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Socioeconomic & Living Conditions')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('familialInstability') text-danger @enderror">@lang('Is the child subject to any familial instability such as maternal death, parent with mental illness, incarcerated parent or caregiver, single parent, or total orphan under informal community care?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('familialInstability') is-invalid @enderror" type="radio" name="familialInstability" id="familialInstabilityYes" value="yes" {{ old('familialInstability') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="familialInstabilityYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('familialInstability') is-invalid @enderror" type="radio" name="familialInstability" id="familialInstabilityNo" value="no" {{ old('familialInstability') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="familialInstabilityNo">@lang('NO')</label>
                                        </div>
                                        @error('familialInstability')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('poverty') text-danger @enderror">@lang('Is the child affected by food or monetary poverty?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('poverty') is-invalid @enderror" type="radio" name="poverty" id="povertyYes" value="yes" {{ old('poverty') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="povertyYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('poverty') is-invalid @enderror" type="radio" name="poverty" id="povertyNo" value="no" {{ old('poverty') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="povertyNo">@lang('NO')</label>
                                        </div>
                                        @error('poverty')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('institutionalized') text-danger @enderror">@lang('Is the child institutionalized in an orphanage or similar communal care facility?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('institutionalized') is-invalid @enderror" type="radio" name="institutionalized" id="institutionalizedYes" value="yes" {{ old('institutionalized') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="institutionalizedYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('institutionalized') is-invalid @enderror" type="radio" name="institutionalized" id="institutionalizedNo" value="no" {{ old('institutionalized') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="institutionalizedNo">@lang('NO')</label>
                                        </div>
                                        @error('institutionalized')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('insecureShelter') text-danger @enderror">@lang('Is the child housed in an insecure temporary shelter and/or vulnerable to extreme weather or natural disasters?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('insecureShelter') is-invalid @enderror" type="radio" name="insecureShelter" id="insecureShelterYes" value="yes" {{ old('insecureShelter') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="insecureShelterYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('insecureShelter') is-invalid @enderror" type="radio" name="insecureShelter" id="insecureShelterNo" value="no" {{ old('insecureShelter') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="insecureShelterNo">@lang('NO')</label>
                                        </div>
                                        @error('insecureShelter')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Safety & Social Factors')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('psychologicalTrauma') text-danger @enderror">@lang('Is the child having a history of psychological trauma such as parental death, severe injury, child marriage, FGM, suspected or known rape, or physical abuse?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('psychologicalTrauma') is-invalid @enderror" type="radio" name="psychologicalTrauma" id="psychologicalTraumaYes" value="yes" {{ old('psychologicalTrauma') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="psychologicalTraumaYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('psychologicalTrauma') is-invalid @enderror" type="radio" name="psychologicalTrauma" id="psychologicalTraumaNo" value="no" {{ old('psychologicalTrauma') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="psychologicalTraumaNo">@lang('NO')</label>
                                        </div>
                                        @error('psychologicalTrauma')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('socialIsolation') text-danger @enderror">@lang('Is the child bed-ridden, lacking of adult supervision, or experiencing social isolation?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('socialIsolation') is-invalid @enderror" type="radio" name="socialIsolation" id="socialIsolationYes" value="yes" {{ old('socialIsolation') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="socialIsolationYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('socialIsolation') is-invalid @enderror" type="radio" name="socialIsolation" id="socialIsolationNo" value="no" {{ old('socialIsolation') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="socialIsolationNo">@lang('NO')</label>
                                        </div>
                                        @error('socialIsolation')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('discrimination') text-danger @enderror">@lang('Is the child facing any gender, ethnic, religious, medical, or cultural discrimination?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('discrimination') is-invalid @enderror" type="radio" name="discrimination" id="discriminationYes" value="yes" {{ old('discrimination') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="discriminationYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('discrimination') is-invalid @enderror" type="radio" name="discrimination" id="discriminationNo" value="no" {{ old('discrimination') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="discriminationNo">@lang('NO')</label>
                                        </div>
                                        @error('discrimination')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('conflictArea') text-danger @enderror">@lang('Is the child residing in an area of active war, oppression, or conflict?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('conflictArea') is-invalid @enderror" type="radio" name="conflictArea" id="conflictAreaYes" value="yes" {{ old('conflictArea') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="conflictAreaYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('conflictArea') is-invalid @enderror" type="radio" name="conflictArea" id="conflictAreaNo" value="no" {{ old('conflictArea') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="conflictAreaNo">@lang('NO')</label>
                                        </div>
                                        @error('conflictArea')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="question-group">
                                    <h5 class="text-primary">@lang('Environmental & Education')</h5>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('healthcareAccess') text-danger @enderror">@lang('Is the child lacking access to healthcare either by restraints of proximity or finance?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('healthcareAccess') is-invalid @enderror" type="radio" name="healthcareAccess" id="healthcareAccessYes" value="yes" {{ old('healthcareAccess') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="healthcareAccessYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('healthcareAccess') is-invalid @enderror" type="radio" name="healthcareAccess" id="healthcareAccessNo" value="no" {{ old('healthcareAccess') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="healthcareAccessNo">@lang('NO')</label>
                                        </div>
                                        @error('healthcareAccess')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('waterSource') text-danger @enderror">@lang('Is the child dependent on an untreated or insufficient water source?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('waterSource') is-invalid @enderror" type="radio" name="waterSource" id="waterSourceYes" value="yes" {{ old('waterSource') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="waterSourceYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('waterSource') is-invalid @enderror" type="radio" name="waterSource" id="waterSourceNo" value="no" {{ old('waterSource') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="waterSourceNo">@lang('NO')</label>
                                        </div>
                                        @error('waterSource')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('sanitation') text-danger @enderror">@lang('Is the child living without a sanitary toilet or essential hygiene access?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('sanitation') is-invalid @enderror" type="radio" name="sanitation" id="sanitationYes" value="yes" {{ old('sanitation') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sanitationYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('sanitation') is-invalid @enderror" type="radio" name="sanitation" id="sanitationNo" value="no" {{ old('sanitation') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sanitationNo">@lang('NO')</label>
                                        </div>
                                        @error('sanitation')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('schoolStatus') text-danger @enderror">@lang('Is the child inactive or unenrolled in school?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('schoolStatus') is-invalid @enderror" type="radio" name="schoolStatus" id="schoolStatusYes" value="yes" {{ old('schoolStatus') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="schoolStatusYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('schoolStatus') is-invalid @enderror" type="radio" name="schoolStatus" id="schoolStatusNo" value="no" {{ old('schoolStatus') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="schoolStatusNo">@lang('NO')</label>
                                        </div>
                                        @error('schoolStatus')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <p class="form-label mb-1 @error('diseaseOutbreaks') text-danger @enderror">@lang('Is the child situated in an area of active disease outbreaks affecting region/community?') <span class="text-danger">*</span></p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('diseaseOutbreaks') is-invalid @enderror" type="radio" name="diseaseOutbreaks" id="diseaseOutbreaksYes" value="yes" {{ old('diseaseOutbreaks') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="diseaseOutbreaksYes">@lang('YES')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input @error('diseaseOutbreaks') is-invalid @enderror" type="radio" name="diseaseOutbreaks" id="diseaseOutbreaksNo" value="no" {{ old('diseaseOutbreaks') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="diseaseOutbreaksNo">@lang('NO')</label>
                                        </div>
                                        @error('diseaseOutbreaks')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                <input type="text" id="score_display" class="form-control" readonly>
                                                <input type="hidden" name="score" id="score">
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
                                                <input type="text" id="vitality_score_display" class="form-control" readonly>
                                                <input type="hidden" name="vitality_score" id="vitality_score">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="notes">@lang('Notes')</label>
                                    <div class="input-group mb-3">
                                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4" placeholder="@lang('Enter any additional notes')">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
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
@endsection
@push('footer')
    <script src="{{ asset('assets/js/custom/patient-details.js') }}"></script>
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
@endpush
