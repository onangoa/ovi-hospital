<table class="table table-bordered">
    <thead class="bg-light">
        <tr>
            <th>@lang('System')</th>
            <th>@lang('Normal/Abnormal')</th>
            <th>@lang('Comments')</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>@lang('Respiratory')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="respiratory_status" id="respiratoryNormal" value="normal" {{ old('respiratory_status', isset($wardRoundNote) ? $wardRoundNote->respiratory_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="respiratoryNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="respiratory_status" id="respiratoryAbnormal" value="abnormal" {{ old('respiratory_status', isset($wardRoundNote) ? $wardRoundNote->respiratory_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="respiratoryAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="respiratory_comments" class="form-control @error('respiratory_comments') is-invalid @enderror" value="{{ old('respiratory_comments', isset($wardRoundNote) ? $wardRoundNote->respiratory_comments : '') }}">
                @error('respiratory_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>@lang('Cardiovascular')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cardiovascular_status" id="cardiovascularNormal" value="normal" {{ old('cardiovascular_status', isset($wardRoundNote) ? $wardRoundNote->cardiovascular_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cardiovascularNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="cardiovascular_status" id="cardiovascularAbnormal" value="abnormal" {{ old('cardiovascular_status', isset($wardRoundNote) ? $wardRoundNote->cardiovascular_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="cardiovascularAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="cardiovascular_comments" class="form-control @error('cardiovascular_comments') is-invalid @enderror" value="{{ old('cardiovascular_comments', isset($wardRoundNote) ? $wardRoundNote->cardiovascular_comments : '') }}">
                @error('cardiovascular_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>@lang('Gastrointestinal')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gastrointestinal_status" id="gastrointestinalNormal" value="normal" {{ old('gastrointestinal_status', isset($wardRoundNote) ? $wardRoundNote->gastrointestinal_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gastrointestinalNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gastrointestinal_status" id="gastrointestinalAbnormal" value="abnormal" {{ old('gastrointestinal_status', isset($wardRoundNote) ? $wardRoundNote->gastrointestinal_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gastrointestinalAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="gastrointestinal_comments" class="form-control @error('gastrointestinal_comments') is-invalid @enderror" value="{{ old('gastrointestinal_comments', isset($wardRoundNote) ? $wardRoundNote->gastrointestinal_comments : '') }}">
                @error('gastrointestinal_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>@lang('Neurological')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="neurological_status" id="neurologicalNormal" value="normal" {{ old('neurological_status', isset($wardRoundNote) ? $wardRoundNote->neurological_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="neurologicalNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="neurological_status" id="neurologicalAbnormal" value="abnormal" {{ old('neurological_status', isset($wardRoundNote) ? $wardRoundNote->neurological_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="neurologicalAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="neurological_comments" class="form-control @error('neurological_comments') is-invalid @enderror" value="{{ old('neurological_comments', isset($wardRoundNote) ? $wardRoundNote->neurological_comments : '') }}">
                @error('neurological_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>@lang('Musculoskeletal')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="musculoskeletal_status" id="musculoskeletalNormal" value="normal" {{ old('musculoskeletal_status', isset($wardRoundNote) ? $wardRoundNote->musculoskeletal_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="musculoskeletalNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="musculoskeletal_status" id="musculoskeletalAbnormal" value="abnormal" {{ old('musculoskeletal_status', isset($wardRoundNote) ? $wardRoundNote->musculoskeletal_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="musculoskeletalAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="musculoskeletal_comments" class="form-control @error('musculoskeletal_comments') is-invalid @enderror" value="{{ old('musculoskeletal_comments', isset($wardRoundNote) ? $wardRoundNote->musculoskeletal_comments : '') }}">
                @error('musculoskeletal_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>@lang('Genitourinary')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="genitourinary_status" id="genitourinaryNormal" value="normal" {{ old('genitourinary_status', isset($wardRoundNote) ? $wardRoundNote->genitourinary_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="genitourinaryNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="genitourinary_status" id="genitourinaryAbnormal" value="abnormal" {{ old('genitourinary_status', isset($wardRoundNote) ? $wardRoundNote->genitourinary_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="genitourinaryAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="genitourinary_comments" class="form-control @error('genitourinary_comments') is-invalid @enderror" value="{{ old('genitourinary_comments', isset($wardRoundNote) ? $wardRoundNote->genitourinary_comments : '') }}">
                @error('genitourinary_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <td>@lang('Integumentary')</td>
            <td>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="integumentary_status" id="integumentaryNormal" value="normal" {{ old('integumentary_status', isset($wardRoundNote) ? $wardRoundNote->integumentary_status : '') == 'normal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="integumentaryNormal">@lang('Normal')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="integumentary_status" id="integumentaryAbnormal" value="abnormal" {{ old('integumentary_status', isset($wardRoundNote) ? $wardRoundNote->integumentary_status : '') == 'abnormal' ? 'checked' : '' }}>
                    <label class="form-check-label" for="integumentaryAbnormal">@lang('Abnormal')</label>
                </div>
            </td>
            <td>
                <input type="text" name="integumentary_comments" class="form-control @error('integumentary_comments') is-invalid @enderror" value="{{ old('integumentary_comments', isset($wardRoundNote) ? $wardRoundNote->integumentary_comments : '') }}">
                @error('integumentary_comments')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </td>
        </tr>
    </tbody>
</table>