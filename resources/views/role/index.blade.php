<h2>Daftar Role</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Role</th>
            <th>Deskripsi</th>
            <th>
                <a href="{{ route('role.create') }}">Tambah Role</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->name }}</td>
            <td>{{ $v->description }}</td>
            <td>
                <form action="{{ route('role.destroy', $v->roles_id) }}" method="POST" style="display:inline;">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('role.edit', $v->roles_id) }}">Edit</a>
                    <button type="submit" onclick="return confirm('Kamu serius?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>