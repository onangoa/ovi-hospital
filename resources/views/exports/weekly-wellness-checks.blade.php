<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Conducted By</th>
            <th>Full Meals</th>
            <th>Partial Meals</th>
            <th>Minimal Meals</th>
            <th>Skin Wounds</th>
            <th>Mobility</th>
            <th>Mobility Notes</th>
            <th>Sleep</th>
            <th>Mood</th>
            <th>Engagement</th>
            <th>Behavior Changes</th>
            <th>With Caregivers</th>
            <th>With Peers</th>
            <th>Communication</th>
            <th>Pain Indicators</th>
            <th>Comfort</th>
            <th>Medication</th>
            <th>Signs of Illness</th>
            <th>Hydration</th>
            <th>Environment</th>
            <th>Progress</th>
            <th>Next Steps</th>
        </tr>
    </thead>
    <tbody>
        @foreach($weeklyWellnessChecks as $check)
            <tr>
                <td>{{ $check->date }}</td>
                <td>{{ $check->patient->name }}</td>
                <td>{{ $check->conductedBy->name }}</td>
                <td>{{ $check->full_meals ? 'Yes' : 'No' }}</td>
                <td>{{ $check->partial_meals ? 'Yes' : 'No' }}</td>
                <td>{{ $check->minimal_meals ? 'Yes' : 'No' }}</td>
                <td>{{ $check->skin_wounds }}</td>
                <td>{{ $check->mobility }}</td>
                <td>{{ $check->mobility_notes }}</td>
                <td>{{ $check->sleep }}</td>
                <td>{{ $check->mood }}</td>
                <td>{{ $check->engagement }}</td>
                <td>{{ $check->behavior_changes }}</td>
                <td>{{ $check->with_caregivers }}</td>
                <td>{{ $check->with_peers }}</td>
                <td>{{ $check->communication }}</td>
                <td>{{ $check->pain_indicators }}</td>
                <td>{{ $check->comfort }}</td>
                <td>{{ $check->medication }}</td>
                <td>{{ $check->signs_of_illness }}</td>
                <td>{{ $check->hydration }}</td>
                <td>{{ $check->environment }}</td>
                <td>{{ $check->progress }}</td>
                <td>{{ $check->next_steps }}</td>
            </tr>
        @endforeach
    </tbody>
</table>