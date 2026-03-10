<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Patient Name</th>
            <th>Provider Name</th>
            <th>Medications</th>
            <th>Dietary Needs</th>
            <th>Activity Restrictions</th>
            <th>Wound Care</th>
            <th>Admission Decision</th>
            <th>Tests Needed</th>
            <th>Tests Comments</th>
            <th>Signature Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($carePlans as $carePlan)
            <tr>
                <td>{{ is_string($carePlan->date) ? \Carbon\Carbon::parse($carePlan->date)->format('d M, Y') : $carePlan->date->format('d M, Y') }}</td>
                <td>{{ $carePlan->patient->name }}</td>
                <td>{{ $carePlan->provider->name }}</td>
                <td>
                    @if($carePlan->medications)
                        @php
                            $medications = $carePlan->medications;
                            if($medications && count($medications) > 0) {
                                foreach($medications as $medication) {
                                    if(is_array($medication)) {
                                        echo ($medication['name'] ?? '') .
                                             (isset($medication['dosage']) ? ' - ' . $medication['dosage'] : '') .
                                             (isset($medication['frequency']) ? ' - ' . $medication['frequency'] : '') .
                                             (isset($medication['duration']) ? ' - ' . $medication['duration'] : '') . "\n";
                                    } else {
                                        echo $medication . "\n";
                                    }
                                }
                            }
                        @endphp
                    @endif
                </td>
                <td>{{ $carePlan->dietary_needs }}</td>
                <td>{{ $carePlan->activity_restrictions }}</td>
                <td>{{ $carePlan->wound_care }}</td>
                <td>{{ $carePlan->admission_decision }}</td>
                <td>{{ $carePlan->tests_needed }}</td>
                <td>{{ $carePlan->tests_comments }}</td>
                <td>{{ is_string($carePlan->signature_date) ? \Carbon\Carbon::parse($carePlan->signature_date)->format('d M, Y') : ($carePlan->signature_date ? $carePlan->signature_date->format('d M, Y') : '') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>