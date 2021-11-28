<table>
    <thead>
    <tr>
        <th>Starting point of travel</th>
        <th>Product</th>
        <th>Destination</th>
        <th>Community Leader</th>
        <th>Date of Travel</th>
        <th>Type of Vehicle</th>
    </tr>
    </thead>
    <tbody>
    @foreach($row as $data)
        <tr>
            <td>{{$data->from}}</td>
            <td>{{$data->product}} - {{$data->quantity}}{{$data->unit_of_measure}}</td>
            <td>{{$data->destination}}</td>
            <td>{{$data->community_leader->name}}</td>
            <td>{{$data->date_of_travel}}</td>
            <td>{{$data->type_of_vehicle}}</td>
        </tr>
    @endforeach
    </tbody>
</table>