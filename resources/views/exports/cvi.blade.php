<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Nutritional Status</th>
            <th>Developmentally Delayed</th>
            <th>Chronic Conditions</th>
            <th>Mental Health</th>
            <th>Physical Disabilities</th>
            <th>Communication Abilities</th>
            <th>Vaccine Status</th>
            <th>Familial Instability</th>
            <th>Poverty</th>
            <th>Institutionalized</th>
            <th>Insecure Shelter</th>
            <th>Psychological Trauma</th>
            <th>Social Isolation</th>
            <th>Discrimination</th>
            <th>Conflict Area</th>
            <th>Healthcare Access</th>
            <th>Water Source</th>
            <th>Sanitation</th>
            <th>School Status</th>
            <th>Disease Outbreaks</th>
            <th>Score</th>
            <th>Vitality Score</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cviScores as $cvi)
            <tr>
                <td>{{ $cvi->date }}</td>
                <td>{{ $cvi->patient->name }}</td>
                <td>{{ $cvi->nutritionalStatus }}</td>
                <td>{{ $cvi->developmentallyDelayed }}</td>
                <td>{{ $cvi->chronicConditions }}</td>
                <td>{{ $cvi->mentalHealth }}</td>
                <td>{{ $cvi->physicalDisabilities }}</td>
                <td>{{ $cvi->communicationAbilities }}</td>
                <td>{{ $cvi->vaccineStatus }}</td>
                <td>{{ $cvi->familialInstability }}</td>
                <td>{{ $cvi->poverty }}</td>
                <td>{{ $cvi->institutionalized }}</td>
                <td>{{ $cvi->insecureShelter }}</td>
                <td>{{ $cvi->psychologicalTrauma }}</td>
                <td>{{ $cvi->socialIsolation }}</td>
                <td>{{ $cvi->discrimination }}</td>
                <td>{{ $cvi->conflictArea }}</td>
                <td>{{ $cvi->healthcareAccess }}</td>
                <td>{{ $cvi->waterSource }}</td>
                <td>{{ $cvi->sanitation }}</td>
                <td>{{ $cvi->schoolStatus }}</td>
                <td>{{ $cvi->diseaseOutbreaks }}</td>
                <td>{{ $cvi->score }}</td>
                <td>{{ $cvi->vitality_score }}</td>
                <td>{{ \Illuminate\Support\Str::limit($cvi->notes, 200) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>