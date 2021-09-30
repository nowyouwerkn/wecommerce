<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Email</th>
            <th>Órdenes</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->orders->count() }}</td>
            <td>{{ Carbon\Carbon::parse($client->created_at)->format('d M Y, H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>