@extends('templates.app', ['title' => 'Manajemen Pegawai'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Pegawai</h4>
                            <span>Memanajemen data-data pegawai yang terdaftar</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
        </div>
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Form Penambahan Pegawai</h5> <br>
                            </div>
                            <div class="card-block">
                                <form action="{{ isset($user) ? route('pegawai.update', ['id' => $user->id]) : route('pegawai.store') }}" method="post" enctype='multipart/form-data'>
                                    @csrf
                                    @if(isset($user))
                                        @method("PUT")
                                    @endif

                                    <div class="form-group">
                                        <label class="form-label">Foto</label>
                                        <div>
                                            <input type="file" class="form-control" name="foto">
                                        </div>
                                        @error('foto')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') ?? $user->nama ?? '' }}">
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label class="form-label">NIP</label>
                                            <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip') ?? $user->nip ?? '' }}">
                                            @error('nip')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Jabatan</label>
                                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') ?? $user->jabatan ?? '' }}">
                                            @error('jabatan')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="row col-6">
                                            <div class="form-group col-6">
                                                <label class="form-label">Pangkat</label>
                                                <input type="text" class="form-control @error('pangkat') is-invalid @enderror" name="pangkat" value="{{ old('pangkat') ?? $user->pangkat ?? '' }}">
                                                @error('pangkat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Golongan</label>
                                                <input type="text" class="form-control @error('golongan') is-invalid @enderror" name="golongan" value="{{ old('golongan') ?? $user->golongan ?? '' }}">
                                                @error('golongan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email ?? '' }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="row col-6">
                                            <div class="form-group col-6">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Konfirmasi Password</label>
                                                <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror" name="confirmation_password">
                                                @error('confirmation_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0" style="width: 100%">
                                        <label class="form-label">Role Akun</label>
                                        <select class="form-control select2 category-select @error('role') is-invalid @enderror" name="role">
                                            <option value="" hidden selected>Pilih Role Akun</option>
                                            <option value="Pegawai" @if((old('role') ?? $user->role ?? '') == "Pegawai") selected @endif>Pegawai</option>
                                            <option value="Admin" @if((old('role') ?? $user->role ?? '') == "Admin") selected @endif>Admin</option>
                                        </select>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right mt-3">
                                        Simpan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection