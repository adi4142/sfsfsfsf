<h2>Tambah Peran</h2>
<form action="{{ route('role.store') }}" method="POST">
    {{ csrf_field() }}
    <div>
        <label for="name">Nama Role:</label>
        <br>
        <input type="text" name="name" value="{{ old('name') }}">
        @if ($errors->has('name'))
        <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif
    </div>
    <div>
        <label for="description">Deskripsi:</label>
        <br>
        <textarea name="description" value="{{ old('description') }}"></textarea>
    </div>
    <button type="submit">Simpan</button>
    <a href="{{ route('role.index') }}">Kembali</a>
</form>