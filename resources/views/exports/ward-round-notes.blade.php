<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>MRN</th>
            <th>Attending Clinician</th>
            <th>Main Complaints</th>
            <th>Examination Findings</th>
            <th>Respiratory Status</th>
            <th>Cardiovascular Status</th>
            <th>Neurological Status</th>
            <th>Gastrointestinal Status</th>
            <th>Skin Status</th>
            <th>Medications Changes</th>
            <th>Procedures Interventions</th>
            <th>Pending Tests</th>
            <th>Condition</th>
            <th>Next Steps</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wardRoundNotes as $note)
            <tr>
                <td>{{ is_string($note->date) ? \Carbon\Carbon::parse($note->date)->format('d M, Y') : $note->date->format('d M, Y') }}</td>
                <td>{{ $note->patient->name }}</td>
                <td>{{ $note->mrn }}</td>
                <td>{{ $note->attendingClinician->name ?? $note->clinician_name }}</td>
                <td>{{ \Illuminate\Support\Str::limit($note->main_complaints, 100) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($note->examination_findings, 100) }}</td>
                <td>{{ $note->respiratory_status }}</td>
                <td>{{ $note->cardiovascular_status }}</td>
                <td>{{ $note->neurological_status }}</td>
                <td>{{ $note->gastrointestinal_status }}</td>
                <td>{{ $note->skin_status }}</td>
                <td>{{ \Illuminate\Support\Str::limit($note->medications_changes, 100) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($note->procedures_interventions, 100) }}</td>
                <td>{{ $note->pending_tests }}</td>
                <td>{{ $note->condition }}</td>
                <td>{{ \Illuminate\Support\Str::limit($note->next_steps, 100) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>