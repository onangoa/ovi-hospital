<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Caregiver Name</th>
            <th>Breakfast</th>
            <th>Lunch</th>
            <th>Dinner</th>
            <th>Mood</th>
            <th>Favorite Activity</th>
            <th>Pain Level</th>
            <th>Concerns</th>
        </tr>
    </thead>
    <tbody>
        @foreach($caregiverDailyReports as $report)
            <tr>
                <td>{{ $report->date }}</td>
                <td>{{ $report->patient->name }}</td>
                <td>{{ $report->caregiver->name }}</td>
                <td>{{ $report->breakfast }}</td>
                <td>{{ $report->lunch }}</td>
                <td>{{ $report->dinner }}</td>
                <td>{{ $report->mood }}</td>
                <td>{{ $report->favorite_activity }}</td>
                <td>{{ $report->pain_level }}</td>
                <td>{{ \Illuminate\Support\Str::limit($report->concerns, 200) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>