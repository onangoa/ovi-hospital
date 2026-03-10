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
                        <li class="breadcrumb-item active">@lang('Caregiver Daily Report Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Caregiver Daily Report Info')</h3>
                    @can('caregiver-daily-reports-update')
                        <div class="card-tools">
                            <a href="{{ route('caregiver-daily-reports.edit', $caregiverDailyReport) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('caregiver-daily-reports.show', $caregiverDailyReport) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ $caregiverDailyReport->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $caregiverDailyReport->patient->name ?? 'N/A' }}</h3>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">@lang('Date')</label>
                                        <p>{{ $caregiverDailyReport->date }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="caregiver_name">@lang('Conducted by')</label>
                                        <p>{{ $caregiverDailyReport->caregiver->name ?? 'N/A' }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mb-4 form-card">
                        <div class="card-header"><h3 class="card-title">@lang('Meals')</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>@lang('Meal')</th>
                                            <th>@lang('Consumption')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-start">@lang('Breakfast')</td>
                                            <td>
                                                @if($caregiverDailyReport->breakfast == 'all')
                                                    @lang('All')
                                                @elseif($caregiverDailyReport->breakfast == 'some')
                                                    @lang('Some')
                                                @elseif($caregiverDailyReport->breakfast == 'none')
                                                    @lang('None')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">@lang('Lunch')</td>
                                            <td>
                                                @if($caregiverDailyReport->lunch == 'all')
                                                    @lang('All')
                                                @elseif($caregiverDailyReport->lunch == 'some')
                                                    @lang('Some')
                                                @elseif($caregiverDailyReport->lunch == 'none')
                                                    @lang('None')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">@lang('Dinner')</td>
                                            <td>
                                                @if($caregiverDailyReport->dinner == 'all')
                                                    @lang('All')
                                                @elseif($caregiverDailyReport->dinner == 'some')
                                                    @lang('Some')
                                                @elseif($caregiverDailyReport->dinner == 'none')
                                                    @lang('None')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 form-card">
                        <div class="card-header"><h3 class="card-title">@lang('Mood')</h3>
                        </div>
                        <div class="card-body">
                            <p>
                                @if($caregiverDailyReport->mood == 'happy')
                                    @lang('Happy')
                                @elseif($caregiverDailyReport->mood == 'neutral')
                                    @lang('Neutral')
                                @elseif($caregiverDailyReport->mood == 'upset')
                                    @lang('Upset')
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="card mb-4 form-card">
                        <div class="card-header"><h3 class="card-title">@lang('Activity & Health')</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="favorite_activity" class="form-label">@lang('Favorite activity today')</label>
                                <p>{{ $caregiverDailyReport->favorite_activity ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="pain_level" class="form-label">@lang('Pain Level (0-10)')</label>
                                <p>{{ $caregiverDailyReport->pain_level ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="concerns" class="form-label">@lang('Concerns')</label>
                                <p>{{ $caregiverDailyReport->concerns ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
@endsection
