@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('care-plans.index') }}">@lang('Care Plan')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Care Plan Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Care Plan Info')</h3>
                    @can('care-plans-update')
                        <div class="card-tools">
                            <a href="{{ route('care-plans.edit', $carePlan) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('care-plans.show', $carePlan) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ $carePlan->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}"
                                 alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $carePlan->patient->name ?? 'N/A' }}</h3>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">@lang('Date')</label>
                                        <p>{{ $carePlan->date->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="provider_signature">Conducted by</label>
                                        <p>{{ $carePlan->provider_signature ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Medications --}}
                    <div class="mb-4">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('Medication')</th>
                                        <th>@lang('Dosage')</th>
                                        <th>@lang('Frequency')</th>
                                        <th>@lang('Duration')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($carePlan->medications ?? [] as $medication)
                                        <tr>
                                            <td>{{ $medication['name'] ?? 'N/A' }}</td>
                                            <td>{{ $medication['dosage'] ?? 'N/A' }}</td>
                                            <td>{{ $medication['frequency'] ?? 'N/A' }}</td>
                                            <td>{{ $medication['duration'] ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">@lang('No medications prescribed.')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Dietary Needs / Instructions --}}
                        <div class="mb-3">
                            <label for="dietary_needs" class="form-label">@lang('Dietary Needs')</label>
                            <p>{{ $carePlan->dietary_needs ?? 'N/A' }}</p>
                        </div>

                        <div class="card card-primary mb-4">
                            <div class="card-header">
                                <h6 class="card-title">@lang('Special Instructions')</h6>
                            </div>
                            <div class="card-body">
                                <p>{{ $carePlan->special_instructions ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="activity_restrictions" class="form-label">@lang('Activity Restrictions')</label>
                            <p>{{ $carePlan->activity_restrictions ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <label for="wound_care" class="form-label">@lang('Wound or Skin Care')</label>
                            <p>{{ $carePlan->wound_care ?? 'N/A' }}</p>
                        </div>

                        {{-- Admission Decision --}}
                        <div class="mb-3">
                            <label class="form-label">@lang('Admission Decision')</label>
                            <p>
                                @if($carePlan->admission_decision == 'outpatient')
                                    @lang('Outpatient Services')
                                @elseif($carePlan->admission_decision == 'inpatient')
                                    @lang('Inpatient Admission')
                                @elseif($carePlan->admission_decision == 'longTermCare')
                                    @lang('Long-term Care Admission')
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>

                        {{-- Tests Needed --}}
                        <div class="mb-3">
                            <label for="tests_needed" class="form-label">@lang('Additional Tests or Referrals Needed')</label>
                            <p>
                                @if($carePlan->tests_needed == 'yes')
                                    @lang('Yes')
                                @elseif($carePlan->tests_needed == 'no')
                                    @lang('No')
                                @else
                                    N/A
                                @endif
                            </p>
                            <p>{{ $carePlan->tests_comments ?? 'N/A' }}</p>
                        </div>

                        {{-- Provider Signature --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provider_signature_detail" class="form-label">Conducted by</label>
                                    <p>{{ $carePlan->provider_signature ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div> {{-- end mb-4 --}}
                </div> {{-- end card-body --}}
            </div> {{-- end card --}}
        </div>
    </div>
@endsection
