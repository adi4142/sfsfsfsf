<h1>Edit User</h1>
<form action="{{ route('user.update', $edituser->user_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $edituser->name }}">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $edituser->email }}">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="{{ $edituser->password }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{route('user.index')}}" class="btn btn-danger">Kembali</a>
</form>
