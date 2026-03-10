<table>
    <thead>
        <tr>
            <th>Patient Name</th>
            <th>Referring Doctor</th>
            <th>Reason for Referral</th>
            <th>Chief Complaint</th>
            <th>Patient Brief History</th>
            <th>Lab Investigation Done</th>
            <th>Treatment Done</th>
        </tr>
    </thead>
    <tbody>
        @foreach($medicalReferrals as $referral)
            <tr>
                <td>{{ $referral->patient->name }}</td>
                <td>{{ $referral->referringDoctor->name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($referral->reason_for_referral, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($referral->chief_complaint, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($referral->patient_brief_history, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($referral->lab_investigation_done, 200) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($referral->treatment_done, 200) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>