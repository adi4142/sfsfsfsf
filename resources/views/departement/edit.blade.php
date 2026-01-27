<h2>Edit Departement</h2>
            <form action="{{route('departement.update', $editdepartement->departement_id)}}" method="POST">
                {{csrf_field()}}
                @method('PUT')
                <div>
                    <label for="name">Nama : </label>
                    <br>
                    <input type="text" name="name" value="{{$editdepartement->name}}"required>
                    <br>
                    <label for="description">Deskripsi : </label>
                    <br>
                    <textarea name="description">{{$editdepartement->description}}</textarea>
                    <br>
                        <button type="submit" class="btn btn-primary">Ganti</button>
                        <a href="{{route('departement.index')}}" class="btn btn-danger">Kembali</a>
                </div>
            </form>