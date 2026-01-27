<h2>Edit Divisi</h2>
            <form action="{{route('division.update', $editdivision->division_id)}}" method="POST">
                {{csrf_field()}}
                @method('PUT')
                <div>
                    <label for="name">Nama : </label>
                    <br>
                    <input type="text" name="name" value="{{$editdivision->name}}"required>
                    <br>
                    <label for="description">Deskripsi : </label>
                    <br>
                    <textarea name="description">{{$editdivision->description}}</textarea>
                    <br>
                        <button type="submit" class="btn btn-primary">Ganti</button>
                        <a href="{{route('division.index')}}" class="btn btn-danger">Kembali</a>
                </div>
            </form>