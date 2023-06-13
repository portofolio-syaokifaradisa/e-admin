@extends('templates.app', ['title' => 'Manajemen Layanan'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Layanan</h4>
                            <span>Memanajemen data-data layanan yang terdaftar</span>
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
                            <h5>Form Penambahan Layanan</h5> <br>
                        </div>
                        <div class="card-block">
                            <form action="{{ isset($layanan) ? route('service.update', ['id' => $layanan->id]) : route('service.store') }}" method="post">
                                @csrf
                                @if(isset($layanan))
                                    @method("PUT")
                                @endif

                                <div class="form-group col">
                                    <label class="form-label">Nama Layanan</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') ?? $layanan->nama ?? '' }}">
                                    @error('nama')
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
@endsection