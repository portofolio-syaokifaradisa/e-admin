@extends('templates.app', ['title' => 'Manajemen Pegawai'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Desa/Kelurahan</h4>
                            <span>Memanajemen data-data desa/kelurahan yang terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Penambahan Desa/Kelurahan</h5> <br>
                        </div>
                        <div class="card-block">
                            <form action="{{ isset($desa) ? route('desa.update', ['id' => $desa->id]) : route('desa.store') }}" method="post">
                                @csrf
                                @if(isset($desa))
                                    @method("PUT")
                                @endif

                                <div class="row">
                                    <div class="form-group col">
                                        <label class="form-label">Nama Desa/Kelurahan</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') ?? $desa->nama_desa ?? '' }}">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') ?? $desa->alamat ?? '' }}">
                                        @error('alamat')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
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
@endsection