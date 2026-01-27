<h2>Edit Posisi</h2>
            <form action="{{route('position.update', $editposition->position_id)}}" method="POST">
                {{csrf_field()}}
                @method('PUT')
                <div>
                    <label for="name">Nama : </label>
                    <br>
                    <input type="text" name="name" value="{{$editposition->name}}"required>
                    <br>
                    <label for="description">Deskripsi : </label>
                    <br>
                    <textarea name="description">{{$editposition->description}}</textarea>
                    <br>
                        <button type="submit" class="btn btn-primary">Ganti</button>
                        <a href="{{route('position.index')}}" class="btn btn-danger">Kembali</a>
                </div>
            </form>