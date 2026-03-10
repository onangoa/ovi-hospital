@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('care-plans.index') }}">@lang('Care Plan')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Care Plan')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit Care Plan')</h3>
                </div>
                <div class="card-body">
                    <form id="carePlanForm" class="form-material form-horizontal" action="{{ route('care-plans.update', $carePlan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_id">@lang('Patient') <b class="ambitious-crimson">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                        </div>
                                        <select name="patient_id" id="patient_id" class="form-control custom-width-100 select2 @error('patient_id') is-invalid @enderror" required>
                                            <option value="">--@lang('Select Patient')--</option>
                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}" @if($patient->id == old('patient_id', $carePlan->patient_id)) selected @endif>{{ $patient->name }}</option>
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
                                        <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', $carePlan->date->format('Y-m-d')) }}" readonly>
                                        @error('date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                                <h6>@lang('Medications Prescribed')</h6>
                                <div class="table-responsive mb-3">
                                    <table class="table table-bordered" id="medicationsTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('Medication')</th>
                                                <th>@lang('Dosage')</th>
                                                <th>@lang('Frequency')</th>
                                                <th>@lang('Duration')</th>
                                                <th width="50px">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="medicationsTableBody">
                                            @if(isset($carePlan->medications) && is_array($carePlan->medications) && count($carePlan->medications) > 0)
                                                @foreach($carePlan->medications as $index => $medication)
                                                    <tr>
                                                        <td><input type="text" name="medications[{{ $index }}][name]" class="form-control" value="{{ old('medications.'.$index.'.name', $medication['name'] ?? '') }}"></td>
                                                        <td><input type="text" name="medications[{{ $index }}][dosage]" class="form-control" value="{{ old('medications.'.$index.'.dosage', $medication['dosage'] ?? '') }}"></td>
                                                        <td><input type="text" name="medications[{{ $index }}][frequency]" class="form-control" value="{{ old('medications.'.$index.'.frequency', $medication['frequency'] ?? '') }}"></td>
                                                        <td><input type="text" name="medications[{{ $index }}][duration]" class="form-control" value="{{ old('medications.'.$index.'.duration', $medication['duration'] ?? '') }}"></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm remove-medication" @if($loop->first) disabled @endif><i class="fas fa-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td><input type="text" name="medications[0][name]" class="form-control" placeholder="@lang('Medication name')" value="{{ old('medications.0.name') }}"></td>
                                                    <td><input type="text" name="medications[0][dosage]" class="form-control" placeholder="@lang('Dosage')" value="{{ old('medications.0.dosage') }}"></td>
                                                    <td><input type="text" name="medications[0][frequency]" class="form-control" placeholder="@lang('Frequency')" value="{{ old('medications.0.frequency') }}"></td>
                                                    <td><input type="text" name="medications[0][duration]" class="form-control" placeholder="@lang('Duration')" value="{{ old('medications.0.duration') }}"></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm remove-medication" disabled><i class="fas fa-trash"></i></button></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success btn-sm" id="addMedication">
                                        <i class="fas fa-plus"></i> @lang('Add Medication')
                                    </button>
                                </div>
                                
                                <div class="card card-primary mb-4">
                                    <div class="card-header">
                                        <h6 class="card-title">@lang('Special Instructions')</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="dietary_needs" class="form-label">@lang('Dietary Needs')</label>
                                            <textarea name="dietary_needs" class="form-control @error('dietary_needs') is-invalid @enderror" id="dietary_needs" rows="2">{{ old('dietary_needs', $carePlan->dietary_needs) }}</textarea>
                                            @error('dietary_needs')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="activity_restrictions" class="form-label">@lang('Activity Restrictions')</label>
                                            <textarea name="activity_restrictions" class="form-control @error('activity_restrictions') is-invalid @enderror" id="activity_restrictions" rows="2">{{ old('activity_restrictions', $carePlan->activity_restrictions) }}</textarea>
                                            @error('activity_restrictions')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="wound_care" class="form-label">@lang('Wound or Skin Care')</label>
                                            <textarea name="wound_care" class="form-control @error('wound_care') is-invalid @enderror" id="wound_care" rows="2">{{ old('wound_care', $carePlan->wound_care) }}</textarea>
                                            @error('wound_care')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Admission Decision')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="admission_decision" id="outpatient" value="outpatient" {{ old('admission_decision', $carePlan->admission_decision) == 'outpatient' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="outpatient">
                                            @lang('Outpatient Services')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="admission_decision" id="inpatient" value="inpatient" {{ old('admission_decision', $carePlan->admission_decision) == 'inpatient' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inpatient">
                                            @lang('Inpatient Admission')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="admission_decision" id="longTermCare" value="longTermCare" {{ old('admission_decision', $carePlan->admission_decision) == 'longTermCare' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="longTermCare">
                                            @lang('Long-term Care Admission')
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="tests_needed" class="form-label">@lang('Additional Tests or Referrals Needed')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tests_needed" id="testsNeededYes" value="yes" {{ old('tests_needed', $carePlan->tests_needed) == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="testsNeededYes">@lang('Yes')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="tests_needed" id="testsNeededNo" value="no" {{ old('tests_needed', $carePlan->tests_needed) == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="testsNeededNo">@lang('No')</label>
                                    </div>
                                    <textarea name="tests_comments" class="form-control mt-2 @error('tests_comments') is-invalid @enderror" id="tests_comments" rows="2" placeholder="@lang('Comments on additional tests or referrals')">{{ old('tests_comments', $carePlan->tests_comments) }}</textarea>
                                    @error('tests_comments')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="provider_signature" class="form-label">Conducted by</label>
                                            <input type="text" name="provider_signature" class="form-control @error('provider_signature') is-invalid @enderror" id="provider_signature" value="{{ $currentUser->name }}" readonly>
                                            @error('provider_signature')
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
                                        <a href="{{ route('care-plans.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
        document.addEventListener('DOMContentLoaded', function() {
            let medicationIndex = @if(isset($carePlan->medications) && is_array($carePlan->medications)) {{ count($carePlan->medications) }} @else 0 @endif;
            
            // Add medication row
            document.getElementById('addMedication').addEventListener('click', function() {
                const tbody = document.getElementById('medicationsTableBody');
                const newRow = document.createElement('tr');
                
                newRow.innerHTML = `
                    <td><input type="text" name="medications[${medicationIndex}][name]" class="form-control" placeholder="@lang('Medication name')"></td>
                    <td><input type="text" name="medications[${medicationIndex}][dosage]" class="form-control" placeholder="@lang('Dosage')"></td>
                    <td><input type="text" name="medications[${medicationIndex}][frequency]" class="form-control" placeholder="@lang('Frequency')"></td>
                    <td><input type="text" name="medications[${medicationIndex}][duration]" class="form-control" placeholder="@lang('Duration')"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-medication"><i class="fas fa-trash"></i></button></td>
                `;
                
                tbody.appendChild(newRow);
                medicationIndex++;
                updateRemoveButtons();
            });
            
            // Remove medication row
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-medication')) {
                    e.target.closest('tr').remove();
                    updateRemoveButtons();
                }
            });
            
            // Update remove button states
            function updateRemoveButtons() {
                const rows = document.querySelectorAll('#medicationsTableBody tr');
                const removeButtons = document.querySelectorAll('.remove-medication');
                
                removeButtons.forEach(function(button, index) {
                    button.disabled = rows.length <= 1;
                });
            }
            
            // Initial state
            updateRemoveButtons();
        });
    </script>
@endsection
@push('footer')
    <script src="{{ asset('assets/js/custom/patient-details.js') }}"></script>
@endpush