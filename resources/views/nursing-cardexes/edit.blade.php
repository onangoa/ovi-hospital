@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('nursing-cardexes.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('nursing-cardexes.index') }}">@lang('Nursing Cardex List')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Nursing Cardex')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Edit Nursing Cardex')</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('nursing-cardexes.update', $nursingCardex) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_id">@lang('Patient')</label>
                                    <select name="patient_id" id="patient_id" class="patient-select form-control @error('patient_id') is-invalid @enderror">
                                        <option value="">@lang('Select Patient')</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" @if($nursingCardex->patient_id == $patient->id) selected @endif>{{ $patient->name }}</option>
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
                                    <label for="date">@lang('Date')</label>
                                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $nursingCardex->date ? $nursingCardex->date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>

                                    @error('date')
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
                                    <label for="nurse_on_duty_name">@lang('Conducted by')</label>
                                    <input type="text" name="nurse_on_duty_name" id="nurse_on_duty_name" class="form-control @error('nurse_on_duty_name') is-invalid @enderror" value="{{ $currentUser->name }}" readonly>
                                    @error('nurse_on_duty_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="vital-signs-container">
                                    @if($nursingCardex->vital_signs)
                                        {{-- Debug: Show the type and content of vital_signs --}}
                                        {{-- {{ gettype($nursingCardex->vital_signs) }} --}}
                                        {{-- {{ var_dump($nursingCardex->vital_signs) }} --}}
                                        @include('components.vital-signs', ['vital_signs' => $nursingCardex->vital_signs, 'form_name' => 'nursing_cardex'])
                                    @else
                                        @include('components.vital-signs', ['form_name' => 'nursing_cardex'])
                                    @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brief_report">@lang('Brief report')</label>
                                    <textarea name="brief_report" id="brief_report" class="form-control @error('brief_report') is-invalid @enderror" rows="3">{{ old('brief_report', $nursingCardex->brief_report) }}</textarea>
                                    @error('brief_report')
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
                                        <a href="{{ route('nursing-cardexes.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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