@extends('templates.app', ['title' => 'Manajemen Data Kependudukan'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Kependudukan</h4>
                            <span>Memanajemen data-data kependudukan desa yang tercatat</span>
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
                                <h5>Form Penambahan Kependudukan</h5> <br>
                            </div>
                            <div class="card-block">
                                <form action="{{ isset($kependudukan) ? route('kependudukan.update', ['id' => $kependudukan->id]) : route('kependudukan.store') }}" method="post">
                                    @csrf
                                    @if(isset($kependudukan))
                                        @method("PUT")
                                    @endif

                                    <div class="form-group">
                                        <label class="form-label">Tahun Pencatatan</label>
                                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ old('tahun') ?? $kependudukan->tahun ?? '' }}">
                                        @error('tahun')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="form-group mb-0 col-6" style="width: 100%">
                                            <label class="form-label">Asal Desa/Kelurahan</label>
                                            <select class="form-control select2 category-select @error('desa') is-invalid @enderror" name="desa">
                                                <option value="" hidden selected>Pilih Desa/Kelurahan</option>
                                                @foreach ($desa as $value)
                                                    <option value="{{ $value->id }}" @if($value->id === ($kependudukan->desa_id ?? '')) selected @endif>
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
                                        <div class="form-group col">
                                            <label class="form-label">Luas Wilayah</label>
                                            <input type="text" class="form-control @error('luas_wilayah') is-invalid @enderror" name="luas_wilayah" value="{{ old('luas_wilayah') ?? $kependudukan->luas_wilayah ?? '' }}">
                                            @error('luas_wilayah')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="row col">
                                            <div class="form-group col-6">
                                                <label class="form-label">Jumlah Laki-laki</label>
                                                <input type="text" class="form-control @error('jumlah_laki') is-invalid @enderror" name="jumlah_laki" value="{{ old('jumlah_laki') ?? $kependudukan->total_laki ?? '' }}">
                                                @error('jumlah_laki')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Jumlah Perempuan</label>
                                                <input type="text" class="form-control @error('jumlah_perempuan') is-invalid @enderror" name="jumlah_perempuan" value="{{ old('jumlah_perempuan') ?? $kependudukan->total_perempuan ?? '' }}">
                                                @error('jumlah_perempuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row col">
                                            <div class="form-group col-6">
                                                <label class="form-label">Jumlah KK</label>
                                                <input type="text" class="form-control @error('jumlah_kk') is-invalid @enderror" name="jumlah_kk" value="{{ old('jumlah_kk') ?? $kependudukan->total_kk ?? '' }}">
                                                @error('jumlah_kk')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Jumlah Warga</label>
                                                <input type="text" class="form-control @error('jumlah_warga') is-invalid @enderror" name="jumlah_warga" value="{{ old('jumlah_warga') ?? $kependudukan->total_warga ?? '' }}">
                                                @error('jumlah_warga')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
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