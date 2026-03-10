<table>
    <thead>
        <tr>
            <th>Doctor Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Department</th>
            <th>Specialist</th>
            <th>Designation</th>
            <th>Biography</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctorDetails as $doctorDetail)
            <tr>
                <td>{{ $doctorDetail->user->name }}</td>
                <td>{{ $doctorDetail->user->email }}</td>
                <td>{{ $doctorDetail->user->phone ?? '-' }}</td>
                <td>{{ $doctorDetail->hospitalDepartment->name ?? '-' }}</td>
                <td>{{ $doctorDetail->specialist }}</td>
                <td>{{ $doctorDetail->designation }}</td>
                <td>{{ \Illuminate\Support\Str::limit($doctorDetail->biography, 200) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>