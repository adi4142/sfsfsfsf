@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
                         alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->employee->name ?? $user->name }}</h3>

                <p class="text-muted text-center">{{ $user->employee->position->name ?? ($user->role->name ?? 'User') }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item border-top-0">
                        <b>Email</b> <a class="float-right text-primary">{{ $user->email }}</a>
                    </li>
                    @if($user->employee)
                    <li class="list-group-item">
                        <b>NIP</b> <a class="float-right text-primary">{{ $user->employee->nip }}</a>
                    </li>
                    <li class="list-group-item border-bottom-0">
                        <b>No. HP</b> <a class="float-right text-primary">{{ $user->employee->phone }}</a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tentang Saya</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-id-card mr-1"></i> Peran Sistem</strong>
                <p class="text-muted">
                    {{ $user->role->name ?? 'Tidak ada peran' }}
                </p>

                <hr>

                @if($user->employee)
                <strong><i class="fas fa-building mr-1"></i> Departemen & Divisi</strong>
                <p class="text-muted">
                    {{ $user->employee->departement->name ?? '-' }} / {{ $user->employee->division->name ?? '-' }}
                </p>

                <hr>

                <strong><i class="fas fa-calendar-alt mr-1"></i> Tanggal Bergabung</strong>
                <p class="text-muted">
                    {{ $user->employee->created_at ? $user->employee->created_at->format('d M Y') : '-' }}
                </p>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->

    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Informasi Akun</a></li>
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Ganti Password</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="details">
                        <div class="post">
                            <h5 class="text-primary mb-3"><i class="fas fa-info-circle mr-2"></i> Detail Informasi</h5>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3 font-weight-bold">Nama Lengkap</div>
                                <div class="col-sm-9">: {{ $user->employee->name ?? $user->name }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3 font-weight-bold">Email</div>
                                <div class="col-sm-9">: {{ $user->email }}</div>
                            </div>

                            @if($user->employee)
                                <div class="row mb-3">
                                    <div class="col-sm-3 font-weight-bold">NIP</div>
                                    <div class="col-sm-9">: {{ $user->employee->nip }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3 font-weight-bold">Tanggal Lahir</div>
                                    <div class="col-sm-9">: {{ $user->employee->date_of_birth ? date('d M Y', strtotime($user->employee->date_of_birth)) : '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3 font-weight-bold">Jenis Kelamin</div>
                                    <div class="col-sm-9">: {{ $user->employee->gender }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3 font-weight-bold">Nomor HP</div>
                                    <div class="col-sm-9">: {{ $user->employee->phone }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3 font-weight-bold">Alamat</div>
                                    <div class="col-sm-9">: {{ $user->employee->address ?? '-' }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="settings">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="icon fas fa-check"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form class="form-horizontal" action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="current_password" class="col-sm-3 col-form-label">Password Saat Ini</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Saat Ini" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password" class="col-sm-3 col-form-label">Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Password Baru" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi Password Baru" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Perbarui Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
