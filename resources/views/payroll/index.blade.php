<h2>Penggajian</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>periode bulan</th>
            <th>periode tahun</th>
            <th>Status</th>
            <th>
                <a href="{{ route('payroll.create') }}">Tambah periode</a>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($payrolls as $v)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $v->period_month }}</td>
            <td>{{ $v->period_year }}</td>
            @php
                $statusLabel = [
                    'calculated' => 'Sudah Dihitung',
                    'approved'   => 'Disetujui',
                    'paid'       => 'Sudah Dibayar',
                ];
            @endphp
            <td>{{ $statusLabel[$v->status] ?? '-' }}</td>

            <td>
                <form action="{{ route('payroll.destroy', $v->payroll_id) }}" method="POST" style="display:inline;">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('payroll.edit', $v->payroll_id) }}">Edit</a>
                    <button type="submit" onclick="return confirm('Kamu serius?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>