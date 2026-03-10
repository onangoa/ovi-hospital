@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('caregiver-daily-reports.index') }}">@lang('Caregiver Daily Report')</a></li>
                        <li class="breadcrumb-item active">@lang('Add Caregiver Daily Report')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Add Caregiver Daily Report')</h3>
                </div>
                <div class="card-body">
                    <form id="caregiverReportForm" class="form-material form-horizontal" action="{{ route('caregiver-daily-reports.store') }}" method="POST">
                        @csrf
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Report Details')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">@lang('Date') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                                </div>
                                                <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', now()->format('Y-m-d')) }}" readonly required>
                                                @error('date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patient_id">@lang('Patient Name') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <select name="patient_id" id="patient_id" class="form-control custom-width-100 select2 @error('patient_id') is-invalid @enderror" required>
                                                    <option value="">--@lang('Select Patient')--</option>
                                                    @foreach ($patients as $patient)
                                                        <option value="{{ $patient->id }}" @if($patient->id == old('patient_id')) selected @endif>{{ $patient->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('patient_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="caregiver_name">@lang('Conducted by') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-nurse"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                                <input type="hidden" name="provider_id" id="caregiver_name" value="{{ Auth::id() }}">
                                                @error('caregiver_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Meals')</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>@lang('Meal')</th>
                                                <th>@lang('All')</th>
                                                <th>@lang('Some')</th>
                                                <th>@lang('None')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-start">@lang('Breakfast')</td>
                                                <td><input class="form-check-input" type="radio" name="breakfast" value="all" {{ old('breakfast') == 'all' ? 'checked' : '' }}></td>
                                                <td><input class="form-check-input" type="radio" name="breakfast" value="some" {{ old('breakfast') == 'some' ? 'checked' : '' }}></td>
                                                <td><input class="form-check-input" type="radio" name="breakfast" value="none" {{ old('breakfast') == 'none' ? 'checked' : '' }}></td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">@lang('Lunch')</td>
                                                <td><input class="form-check-input" type="radio" name="lunch" value="all" {{ old('lunch') == 'all' ? 'checked' : '' }}></td>
                                                <td><input class="form-check-input" type="radio" name="lunch" value="some" {{ old('lunch') == 'some' ? 'checked' : '' }}></td>
                                                <td><input class="form-check-input" type="radio" name="lunch" value="none" {{ old('lunch') == 'none' ? 'checked' : '' }}></td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">@lang('Dinner')</td>
                                                <td><input class="form-check-input" type="radio" name="dinner" value="all" {{ old('dinner') == 'all' ? 'checked' : '' }}></td>
                                                <td><input class="form-check-input" type="radio" name="dinner" value="some" {{ old('dinner') == 'some' ? 'checked' : '' }}></td>
                                                <td><input class="form-check-input" type="radio" name="dinner" value="none" {{ old('dinner') == 'none' ? 'checked' : '' }}></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Mood')</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-around">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mood" id="happy" value="happy" {{ old('mood') == 'happy' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="happy">@lang('Happy')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mood" id="neutral" value="neutral" {{ old('mood') == 'neutral' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="neutral">@lang('Neutral')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mood" id="upset" value="upset" {{ old('mood') == 'upset' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="upset">@lang('Upset')</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 form-card">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Activity & Health')</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="favorite_activity" class="form-label">@lang('Favorite activity today')</label>
                                    <input type="text" name="favorite_activity" class="form-control @error('favorite_activity') is-invalid @enderror" id="favorite_activity" value="{{ old('favorite_activity') }}">
                                    @error('favorite_activity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pain_level" class="form-label">@lang('Pain Level (0-10)')</label>
                                    <input type="number" name="pain_level" class="form-control @error('pain_level') is-invalid @enderror" id="pain_level" min="0" max="10" value="{{ old('pain_level') }}">
                                    @error('pain_level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-3">
                                    <label for="concerns" class="form-label">@lang('Concerns')</label>
                                    <textarea name="concerns" class="form-control @error('concerns') is-invalid @enderror" id="concerns" rows="3">{{ old('concerns') }}</textarea>
                                    @error('concerns')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('caregiver-daily-reports.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
