@extends('layouts.layout')

@section('title', __('Configure Clinical Form'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Configure Clinical Form') }}: {{ $clinicalForm->form_display_name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vital-signs.index') }}">{{ __('Vital Signs Configuration') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vital-signs.clinical-forms') }}">{{ __('Clinical Forms') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Configure Form') }}</li>
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
                            <h3 class="card-title">{{ __('Configure Vital Signs for') }}: {{ $clinicalForm->form_display_name }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('vital-signs.clinical-forms') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to Forms') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('vital-signs.update-clinical-form', $clinicalForm) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="40">{{ __('Include') }}</th>
                                                <th>{{ __('Vital Sign') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Unit') }}</th>
                                                <th>{{ __('Category') }}</th>
                                                <th width="80">{{ __('Required') }}</th>
                                                <th width="80">{{ __('Display Order') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($availableVitalSigns as $vitalSign)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="hidden" name="vital_signs[{{ $loop->index }}][vital_sign_config_id]" value="">
                                                            <input type="checkbox" class="form-check-input vital-sign-checkbox"
                                                                   name="vital_signs[{{ $loop->index }}][vital_sign_config_id]"
                                                                   value="{{ $vitalSign->id }}"
                                                                   {{ $clinicalForm->vitalSigns->contains($vitalSign->id) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $vitalSign->display_name }}</strong>
                                                        <br>
                                                        <small class="text-muted"><code>{{ $vitalSign->field_name }}</code></small>
                                                    </td>
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
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" 
                                                                   name="vital_signs[{{ $loop->index }}][is_required]" 
                                                                   value="1"
                                                                   {{ $clinicalForm->vitalSigns->where('id', $vitalSign->id)->first()?->pivot->is_required ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm" 
                                                               name="vital_signs[{{ $loop->index }}][display_order]" 
                                                               value="{{ $clinicalForm->vitalSigns->where('id', $vitalSign->id)->first()?->pivot->display_order ?? $loop->index + 1 }}" 
                                                               min="0" style="width: 80px;">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> {{ __('Save Configuration') }}
                                    </button>
                                    <a href="{{ route('vital-signs.clinical-forms') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> {{ __('Cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection

@push('footer')
<script>
$(document).ready(function() {
    // Add select all functionality
    $('<div class="form-group mb-3">' +
        '<label class="form-check-label">' +
        '<input type="checkbox" id="selectAll"> ' + '{{ __('Select All Vital Signs') }}' +
        '</label>' +
        '</div>').insertBefore('table');

    $('#selectAll').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('tbody input[type="checkbox"].vital-sign-checkbox').prop('checked', isChecked);
    });

    // Update select all checkbox when individual checkboxes change
    $('tbody input[type="checkbox"].vital-sign-checkbox').on('change', function() {
        var allChecked = $('tbody input[type="checkbox"].vital-sign-checkbox').length ===
                          $('tbody input[type="checkbox"].vital-sign-checkbox:checked').length;
        $('#selectAll').prop('checked', allChecked);
    });
    
    // Handle form submission to clean up empty values
    $('form').on('submit', function() {
        // Remove empty vital_sign_config_id values before submission
        $('input[name*="vital_sign_config_id"][value=""]').remove();
    });
});
</script>
@endpush