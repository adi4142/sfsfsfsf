<h2>Daftar Pengguna</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Pengguna</th>
            <th>email</th>
            <th>Role</th>
            <th>
                <a href="{{ route('user.create') }}">Tambah Pengguna</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->name }}</td>
            <td>{{ $v->email }}</td>
            <td>{{ $v->role->name ?? '_'}}</td>
            <td>
                <form action="{{ route('user.destroy', $v->user_id) }}" method="POST" style="display:inline;">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('user.edit', $v->user_id) }}">Edit</a>
                    <button type="submit" onclick="return confirm('Kamu serius?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>