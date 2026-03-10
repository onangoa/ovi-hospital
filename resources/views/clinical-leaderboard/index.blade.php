@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>@lang('Clinical Leaderboard')</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Clinical Leaderboard')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Clinical Leaderboard')</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->hasAny(['start_date', 'end_date', 'provider_id'])) show @endif">
                        <div class="card-body border">
                            <form method="GET" action="{{ route('clinical-leaderboard.index') }}">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="start_date">@lang('Start Date')</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->get('start_date', now()->subDays(30)->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="end_date">@lang('End Date')</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request()->get('end_date', now()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="provider_id">Conducted by</label>
                                            <select name="provider_id" id="provider_id" class="form-control">
                                                <option value="">@lang('All Providers')</option>
                                                @foreach($providers as $provider)
                                                    <option value="{{ $provider->id }}" {{ request()->get('provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Filter')</button>
                                        @if(request()->hasAny(['start_date', 'end_date', 'provider_id']))
                                            <a href="{{ route('clinical-leaderboard.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Conducted by</th>
                                <th>@lang('Patients Seen')</th>
                                <th>@lang('Appointments Conducted')</th>
                                <th>@lang('Clinical Reports Submitted')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaderboard as $entry)
                                <tr>
                                    <td>{{ $entry->provider_name }}</td>
                                    <td>{{ $entry->patients_seen }}</td>
                                    <td>{{ $entry->appointments_conducted }}</td>
                                    <td>{{ $entry->notes_submitted }}</td>
                                    <td>
                                        <a href="{{ route('clinical-leaderboard.show', ['id' => $entry->provider_id, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> @lang('View Details')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
