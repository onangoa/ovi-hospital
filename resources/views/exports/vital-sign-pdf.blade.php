@extends('exports.base-single-pdf')

@section('content')
    <div class="info-section">
        <h3>Basic Information</h3>
        <div class="info-row">
            <div class="info-label">Display Name:</div>
            <div class="info-value">{{ $vitalSign->display_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Field Name:</div>
            <div class="info-value"><code>{{ $vitalSign->field_name }}</code></div>
        </div>
        <div class="info-row">
            <div class="info-label">Field Type:</div>
            <div class="info-value">{{ ucfirst($vitalSign->field_type) }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Unit:</div>
            <div class="info-value">{{ $vitalSign->unit ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Category:</div>
            <div class="info-value">{{ $vitalSign->category }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Display Order:</div>
            <div class="info-value">{{ $vitalSign->display_order ?? 0 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Min Value:</div>
            <div class="info-value">{{ $vitalSign->min_value ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Max Value:</div>
            <div class="info-value">{{ $vitalSign->max_value ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Required:</div>
            <div class="info-value">{{ $vitalSign->is_required ? 'Yes' : 'No' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">{{ $vitalSign->is_active ? 'Active' : 'Inactive' }}</div>
        </div>
    </div>
    
    @if($vitalSign->field_type == 'select' && $vitalSign->field_options)
    <div class="info-section">
        <h3>Field Options</h3>
        <div class="data-section">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Label</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vitalSign->field_options as $value => $label)
                    <tr>
                        <td><code>{{ $value }}</code></td>
                        <td>{{ $label }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection