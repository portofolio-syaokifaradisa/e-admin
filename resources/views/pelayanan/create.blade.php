@extends('templates.app', ['title' => 'Manajemen Catatan Pelayanan'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Catatan Pelayanan</h4>
                            <span>Memanajemen pencatatan pelayanan yang telah dilakukan</span>
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
                                <h5>Form Pencatatan Pelayanan</h5> <br>
                            </div>
                            <div class="card-block">
                                <form action="{{ isset($pelayanan) ? route('pelayanan.update', ['id' => $pelayanan->id]) : route('pelayanan.store') }}" method="post">
                                    @csrf
                                    @if(isset($pelayanan))
                                        @method("PUT")
                                    @endif

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Tanggal Pelayanan</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') ?? $pelayanan->date ?? date('Y-m-d') }}">
                                            @error('tanggal')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-0 col" style="width: 100%">
                                            <label class="form-label">Layanan</label>
                                            <select class="form-control select2 category-select @error('layanan') is-invalid @enderror" name="layanan">
                                                <option value="" hidden selected>Pilih Layanan</option>
                                                @foreach ($layanan as $value)
                                                    <option value="{{ $value->id }}" @if($value->id === ($pelayanan->layanan_id ?? '')) selected @endif>
                                                        {{ $value->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('layanan')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="form-label">Nama Lengkap Peminta Layanan</label>
                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') ?? $pelayanan->nama ?? '' }}">
                                                    @error('nama')
                                                        <span class="invalid-feedback" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-0 col" style="width: 100%">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select class="form-control select2 category-select @error('gender') is-invalid @enderror" name="gender">
                                                        <option value="" hidden selected>Pilih Jenis Kelamin</option>
                                                        <option value="Laki-laki" @if(($pelayanan->gender ?? '') == "Laki-laki") selected @endif>Laki-laki</option>
                                                        <option value="Perempuan" @if(($pelayanan->gender ?? '') == "Perempuan") selected @endif>Perempuan</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">
                                                            <small>{{ $message }}</small>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 col-6" style="width: 100%">
                                            <label class="form-label">Asal Desa/Kelurahan</label>
                                            <select class="form-control select2 category-select @error('desa') is-invalid @enderror" name="desa">
                                                <option value="" hidden selected>Pilih Desa/Kelurahan</option>
                                                @foreach ($desa as $value)
                                                    <option value="{{ $value->id }}" @if($value->id === ($pelayanan->desa_id ?? '')) selected @endif>
                                                        {{ $value->nama_desa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('desa')
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
    </div>
@endsection