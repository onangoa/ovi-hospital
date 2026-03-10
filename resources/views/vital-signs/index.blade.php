@extends('layouts.layout')

@section('title', __('Vital Signs Configuration'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Vital Signs Configuration') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Vital Signs Configuration') }}</li>
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
                            <h3 class="card-title">{{ __('Vital Signs Management') }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('vital-signs.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> {{ __('Add Vital Sign') }}
                                </a>
                                <a href="{{ route('vital-signs.clinical-forms') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-hospital"></i> {{ __('Clinical Forms') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Display Name') }}</th>
                                            <th>{{ __('Field Name') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th>{{ __('Required') }}</th>
                                            <th>{{ __('Active') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($vitalSigns as $vitalSign)
                                            <tr>
                                                <td>{{ $vitalSign->display_name }}</td>
                                                <td><code>{{ $vitalSign->field_name }}</code></td>
                                                <td>
                                                    <span class="badge badge-{{ $vitalSign->field_type == 'number' ? 'primary' : ($vitalSign->field_type == 'select' ? 'info' : 'secondary') }}">
                                                        {{ ucfirst($vitalSign->field_type) }}
                                                    </span>
                                                </td>
                                                <td>{{ $vitalSign->unit ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $vitalSign->category }}</span>
                                                </td>
                                                <td>
                                                    @if($vitalSign->is_required)
                                                        <span class="badge badge-warning">{{ __('Yes') }}</span>
                                                    @else
                                                        <span class="badge badge-light">{{ __('No') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($vitalSign->is_active)
                                                        <span class="badge badge-success">{{ __('Active') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('vital-signs.edit', $vitalSign) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('vital-signs.destroy', $vitalSign) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">{{ __('No vital signs found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection