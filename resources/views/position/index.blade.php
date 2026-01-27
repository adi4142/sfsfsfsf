<h2>Daftar Posisi</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Posisi</th>
            <th>Deskripsi</th>
            <th>
                <a href="{{ route('position.create') }}">Tambah Posisi</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($position as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->name }}</td>
            <td>{{ $v->description }}</td>
            <td>
                <form action="{{ route('position.destroy', $v->position_id) }}" method="POST" style="display:inline;">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('position.edit', $v->position_id) }}">Edit</a>
                    <button type="submit" onclick="return confirm('Kamu serius?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>