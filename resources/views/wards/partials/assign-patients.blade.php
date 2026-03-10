<div class="modal fade" id="assignPatientsModal" tabindex="-1" role="dialog" aria-labelledby="assignPatientsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('wards.assign-patients', $ward) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="assignPatientsModalLabel">@lang('Assign Patients to Ward')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="patient_ids">@lang('Select Patients')</label>
                        <select class="form-control select2" name="patient_ids[]" multiple="multiple" style="width: 100%;">
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                    <button type="submit" class="btn btn-primary">@lang('Assign Patients')</button>
                </div>
            </form>
        </div>
    </div>
</div>