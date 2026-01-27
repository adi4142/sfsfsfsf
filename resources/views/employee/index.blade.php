<h2>Data Karyawan</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Nama Karyawan</th>
            <th>Nama akun</th>
            <th>Email</th>
            <th>Nomor Telpon</th>
            <th>Departemen</th>
            <th>Posisi</th>
            <th>Divisi</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>
                <a href="{{ route('employee.create') }}">Tambah Karyawan</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($employee as $v)
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