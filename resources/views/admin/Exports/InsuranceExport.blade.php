<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Fathers Name</th>
        <th>CRT_no</th>
        <th>RegNo</th>
        <th>Company Name</th>
        <th>HP/CC</th>
        <th>Year Of Mgf</th>
        <th>Type Of Body</th>
        <th>fullInsuredValue</th>
        <th>Engine No</th>
        <th>Chassis No</th>
        <th>Passenger</th>
        <th>goods</th>
        <th>Present Address</th>
        <th>Oost Office</th>
        <th>Police Station</th>
        <th>District</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Agent id</th>
        <th>Agent Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach($insurance as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->nameOfInsured }}</td>
            <td>{{ $data->fathersName }}</td>
            <td>{{ $data->CRT_no }}</td>
            <td>{{ $data->RegNo }}</td>
            <td>{{ $data->companyName }}</td>
            <td>{{ $data->hp_cc }}</td>
            <td>{{ $data->yearOfMgf }}</td>
            <td>{{ $data->typeOfBody }}</td>
            <td>{{ $data->fullInsuredValue }}</td>
            <td>{{ $data->engineNo }}</td>
            <td>{{ $data->chassisNo }}</td>
            <td>{{ $data->passenger }}</td>
            <td>{{ $data->goods }}</td>
            <td>{{ $data->presentAddress }}</td>
            <td>{{ $data->postOffice }}</td>
            <td>{{ $data->policeStation }}</td>
            <td>{{ $data->district }}</td>
            <td>{{ $data->email }}</td>
            <td>{{ $data->mobile }}</td>
            <td>{{ prettyDate($data->startDate) }}</td>
            <td>{{ prettyDate($data->endDate) }}</td>
            <td>{{ $data->agent_id }}</td>
            <td>
                @if ($data->agent_id != 0)
                    {{ $data->agentInfo->name }}
                @else
                    Self
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>