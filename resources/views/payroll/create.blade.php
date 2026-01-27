<h2>Tambah Periode</h2>
<form action="{{ route('payroll.store') }}" method="POST">
    {{ csrf_field() }}
    <div>
        <label for="period_month">Periode Bulan :</label>
        <br>
        <input type="number" name="period_month" value="{{ old('period_month') }}">
        @if ($errors->has('period_month'))
        <span class="text-danger">{{ $errors->first('period_month') }}</span>
        @endif
    </div>
    <div>
        <label for="period_year">Periode Tahun :</label>
        <br>
        <input type="number" name="period_year" value="{{ old('period_year') }}">
        @if ($errors->has('period_year'))
        <span class="text-danger">{{ $errors->first('period_year') }}</span>
        @endif
    </div>
    <div>
        <label for="status">Status : </label>
        <br>
        <select name="status" class="form-control">
            <option value="" selected>--Pilih status penggajian--</option>
            <option value="calculated">sedang dihitung</option>
            <option value="paid">sudah dibayar</option>
            <option value="approved">disetujui</option>
        </select>
    </div>
    <button type="submit">Simpan</button>
    <a href="{{ route('payroll.index') }}">Kembali</a>
</form>