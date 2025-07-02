<h3 style="text-align:center">Data Users</h3>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Dibuat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $i => $user)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table> 