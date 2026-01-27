<h2>Daftar Divisi</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Divisi</th>
            <th>Deskripsi</th>
            <th>
                <a href="{{ route('division.create') }}">Tambah Divisi</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($division as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->name }}</td>
            <td>{{ $v->description }}</td>
            <td>
                <form action="{{ route('division.destroy', $v->division_id) }}" method="POST" style="display:inline;">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('division.edit', $v->division_id) }}">Edit</a>
                    <button type="submit" onclick="return confirm('Kamu serius?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>