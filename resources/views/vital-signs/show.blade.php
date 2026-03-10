@extends('layouts.layout')

@section('title', __('Vital Sign Details'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Vital Sign Details') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vital-signs.index') }}">{{ __('Vital Signs Configuration') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Vital Sign Details') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Vital Sign Details') }}: {{ $vitalSign->display_name }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('vital-signs.edit', $vitalSign) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                            </a>
                            <a href="{{ route('vital-signs.show', $vitalSign) }}?export_pdf=1" class="btn btn-danger btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i> {{ __('PDF Export') }}
                            </a>
                            <a href="{{ route('vital-signs.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Display Name') }}</label>
                                    <p>{{ $vitalSign->display_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Field Name') }}</label>
                                    <p><code>{{ $vitalSign->field_name }}</code></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Field Type') }}</label>
                                    <p>
                                        <span class="badge badge-{{ $vitalSign->field_type == 'number' ? 'primary' : ($vitalSign->field_type == 'select' ? 'info' : 'secondary') }}">
                                            {{ ucfirst($vitalSign->field_type) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Unit') }}</label>
                                    <p>{{ $vitalSign->unit ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Category') }}</label>
                                    <p>
                                        <span class="badge badge-secondary">{{ $vitalSign->category }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Display Order') }}</label>
                                    <p>{{ $vitalSign->display_order ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Min Value') }}</label>
                                    <p>{{ $vitalSign->min_value ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Max Value') }}</label>
                                    <p>{{ $vitalSign->max_value ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @if($vitalSign->field_type == 'select' && $vitalSign->field_options)
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Field Options') }}</label>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Value') }}</th>
                                                    <th>{{ __('Label') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($vitalSign->field_options as $value => $label)
                                                <tr>
                                                    <td><code>{{ $value }}</code></td>
                                                    <td>{{ $label }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Required') }}</label>
                                    <p>
                                        @if($vitalSign->is_required)
                                            <span class="badge badge-warning">{{ __('Yes') }}</span>
                                        @else
                                            <span class="badge badge-light">{{ __('No') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Status') }}</label>
                                    <p>
                                        @if($vitalSign->is_active)
                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection