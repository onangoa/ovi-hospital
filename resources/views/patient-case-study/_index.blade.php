<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Patient')</th>
                <th>@lang('Food Allergy')</th>
                <th>@lang('Heart Disease')</th>
                <th>@lang('High Blood Pressure')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patientCaseStudy as $caseStudy)
                <tr>
                    <td>{{ $caseStudy->user->name }}</td>
                    <td>{{ $caseStudy->food_allergy }}</td>
                    <td>{{ $caseStudy->heart_disease }}</td>
                    <td>{{ $caseStudy->high_blood_pressure }}</td>
                    <td>
                        <a href="{{ route('patient-case-studies.show', $caseStudy) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        <a href="{{ route('patient-case-studies.edit', $caseStudy) }}" class="btn btn-sm btn-warning">@lang('Edit')</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">@lang('No case studies found.')</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
