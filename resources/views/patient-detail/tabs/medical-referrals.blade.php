<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Referring Doctor')</th>
                <th>@lang('Reason for Referral')</th>
                <th>@lang('Chief Complaint')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @if($medicalReferrals->count() > 0)
                @foreach($medicalReferrals as $referral)
                    <tr>
                        <td>{{ $referral->created_at->format('d M, Y') }}</td>
                        <td>{{ $referral->referringDoctor->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($referral->reason_for_referral, 50) ?? 'N/A' }}</td>
                        <td>{{ Str::limit($referral->chief_complaint, 50) ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('medical-referrals.show', $referral) }}" class="btn btn-sm btn-info">@lang('View')</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">@lang('No medical referrals found')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>