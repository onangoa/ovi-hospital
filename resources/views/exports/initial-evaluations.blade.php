<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Provider Name</th>
            <th>Reason for Treatment</th>
            <th>Social Background</th>
            <th>Skin Condition</th>
            <th>Primary Diagnosis</th>
            <th>Secondary Diagnosis</th>
            <th>Chronic Conditions</th>
            <th>Current Medications</th>
            <th>Allergies</th>
            <th>Bathing</th>
            <th>Dressing</th>
            <th>Eating</th>
            <th>Mobility</th>
            <th>Toileting</th>
            <th>Physical Therapy</th>
            <th>Psychiatric Support</th>
            <th>Virtual Therapy</th>
            <th>Other Therapy</th>
            <th>Emotional State</th>
            <th>Engagement</th>
            <th>Peer Interaction</th>
        </tr>
    </thead>
    <tbody>
        @foreach($initialEvaluations as $evaluation)
            <tr>
                <td>{{ $evaluation->date }}</td>
                <td>{{ $evaluation->patient->name }}</td>
                <td>{{ $evaluation->provider->name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($evaluation->reason_for_treatment, 100) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($evaluation->social_background, 100) }}</td>
                <td>{{ $evaluation->skin_condition }}</td>
                <td>{{ $evaluation->primary_diagnosis }}</td>
                <td>{{ $evaluation->secondary_diagnosis }}</td>
                <td>{{ \Illuminate\Support\Str::limit($evaluation->chronic_conditions, 100) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($evaluation->current_medications, 100) }}</td>
                <td>{{ $evaluation->allergies }}</td>
                <td>{{ $evaluation->bathing }}</td>
                <td>{{ $evaluation->dressing }}</td>
                <td>{{ $evaluation->eating }}</td>
                <td>{{ $evaluation->mobility_transfers }}</td>
                <td>{{ $evaluation->toileting }}</td>
                <td>{{ $evaluation->physical_therapy }}</td>
                <td>{{ $evaluation->psychiatric_support }}</td>
                <td>{{ $evaluation->virtual_therapy }}</td>
                <td>{{ $evaluation->other_therapy }}</td>
                <td>{{ $evaluation->emotional_state }}</td>
                <td>{{ $evaluation->engagement }}</td>
                <td>{{ $evaluation->peer_interaction }}</td>
            </tr>
        @endforeach
    </tbody>
</table>