<h2>Edit Peran</h2>
            <form action="{{route('role.update', $editrole->roles_id)}}" method="POST">
                {{csrf_field()}}
                @method('PUT')
                <div>
                    <label for="name">Nama : </label>
                    <br>
                    <input type="text" name="name" value="{{$editrole->name}}"required>
                    <br>
                    <label for="description">Deskripsi : </label>
                    <br>
                    <textarea name="description">{{$editrole->description}}</textarea>
                    <br>
                        <button type="submit" class="btn btn-primary">Ganti</button>
                        <a href="{{route('role.index')}}" class="btn btn-danger">Kembali</a>
                </div>
            </form>