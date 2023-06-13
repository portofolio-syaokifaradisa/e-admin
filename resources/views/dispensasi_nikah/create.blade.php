@extends('templates.app', ['title' => 'Manajemen Catatan Dispensasi Nikah'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Pencatatan Dispensasi Nikah</h4>
                            <span>Memanajemen data-data dispensasi nikah yang tercatat</span>
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
                                <h5>Form Pencatatan Dispensasi Nikah</h5> <br>
                            </div>
                            <div class="card-block">
                                <form action="{{ isset($dispensasi_nikah) ? route('dispensasi_nikah.update', ['id' => $dispensasi_nikah->id]) : route('dispensasi_nikah.store') }}" method="post">
                                    @csrf
                                    @if(isset($dispensasi_nikah))
                                        @method("PUT")
                                    @endif

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Tahun Pencatatan</label>
                                            <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun" value="{{ old('tahun') ?? $dispensasi_nikah->tahun ?? '' }}">
                                            @error('tahun')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col" style="width: 100%">
                                            <label class="form-label">Asal Desa/Kelurahan</label>
                                            <select class="form-control select2 category-select @error('desa') is-invalid @enderror" name="desa">
                                                <option value="" hidden selected>Pilih Desa/Kelurahan</option>
                                                @foreach ($desa as $value)
                                                    <option value="{{ $value->id }}" @if($value->id == (old('desa') ?? $dispensasi_nikah->desa_id ?? '')) selected @endif>
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
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Mempelai Laki-laki</label>
                                            <input type="text" class="form-control @error('mempelai_laki') is-invalid @enderror" name="mempelai_laki" value="{{ old('mempelai_laki') ?? $dispensasi_nikah->mempelai_laki ?? '' }}">
                                            @error('mempelai_laki')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label">Mempelai Perempuan</label>
                                            <input type="text" class="form-control @error('mempelai_perempuan') is-invalid @enderror" name="mempelai_perempuan" value="{{ old('mempelai_perempuan') ?? $dispensasi_nikah->mempelai_perempuan ?? '' }}">
                                            @error('mempelai_perempuan')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col row">
                                            <div class="form-group col-6">
                                                <label class="form-label">Tempat Lahir Laki-laki</label>
                                                <input type="text" class="form-control @error('tempat_lahir_laki') is-invalid @enderror" name="tempat_lahir_laki" value="{{ old('tempat_lahir_laki') ?? $dispensasi_nikah->tempat_lahir_laki ?? '' }}">
                                                @error('tempat_lahir_laki')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Tanggal Lahir Laki-laki</label>
                                                <input type="date" class="form-control @error('tanggal_lahir_laki') is-invalid @enderror" name="tanggal_lahir_laki" value="{{ old('tanggal_lahir_laki') ?? $dispensasi_nikah->tanggal_lahir_laki ?? '' }}">
                                                @error('tanggal_lahir_laki')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row col">
                                            <div class="form-group col-6">
                                                <label class="form-label">Tempat Lahir Perempuan</label>
                                                <input type="text" class="form-control @error('tempat_lahir_perempuan') is-invalid @enderror" name="tempat_lahir_perempuan" value="{{ old('tempat_lahir_perempuan') ?? $dispensasi_nikah->tempat_lahir_perempuan ?? '' }}">
                                                @error('tempat_lahir_perempuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Tanggal Lahir Perempuan</label>
                                                <input type="date" class="form-control @error('tanggal_lahir_perempuan') is-invalid @enderror" name="tanggal_lahir_perempuan" value="{{ old('tanggal_lahir_perempuan') ?? $dispensasi_nikah->tanggal_lahir_perempuan ?? '' }}">
                                                @error('tanggal_lahir_perempuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col row">
                                            <div class="form-group col-6" style="width: 100%">
                                                <label class="form-label">Agama Laki-laki</label>
                                                <select class="form-control select2 category-select @error('agama_laki') is-invalid @enderror" name="agama_laki">
                                                    <option value="" hidden selected>Pilih Agama</option>
                                                    @foreach (['Islam', 'Katolik', 'Protestan', 'Hindu', 'Budha', 'Konghucu'] as $value)
                                                        <option value="{{ $value }}" @if($value === (old('agama_laki') ?? $dispensasi_nikah->agama_laki ?? '')) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agama_laki')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Pekerjaan Laki-laki</label>
                                                <input type="text" class="form-control @error('pekerjaan_laki') is-invalid @enderror" name="pekerjaan_laki" value="{{ old('pekerjaan_laki') ?? $dispensasi_nikah->pekerjaan_laki ?? '' }}">
                                                @error('pekerjaan_laki')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col row">
                                            <div class="form-group col-6" style="width: 100%">
                                                <label class="form-label">Agama Perempuan</label>
                                                <select class="form-control select2 category-select @error('agama_perempuan') is-invalid @enderror" name="agama_perempuan">
                                                    <option value="" hidden selected>Pilih Agama</option>
                                                    @foreach (['Islam', 'Katolik', 'Protestan', 'Hindu', 'Budha', 'Konghucu'] as $value)
                                                        <option value="{{ $value }}" @if($value === (old('agama_perempuan') ?? $dispensasi_nikah->agama_perempuan ?? '')) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agama_perempuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Pekerjaan Perempuan</label>
                                                <input type="text" class="form-control @error('pekerjaan_perempuan') is-invalid @enderror" name="pekerjaan_perempuan" value="{{ old('pekerjaan_perempuan') ?? $dispensasi_nikah->pekerjaan_perempuan ?? '' }}">
                                                @error('pekerjaan_perempuan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Alamat Laki-laki</label>
                                            <input type="text" class="form-control @error('alamat_laki') is-invalid @enderror" name="alamat_laki" value="{{ old('alamat_laki') ?? $dispensasi_nikah->alamat_laki ?? '' }}">
                                            @error('alamat_laki')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label">Alamat Perempuan</label>
                                            <input type="text" class="form-control @error('alamat_perempuan') is-invalid @enderror" name="alamat_perempuan" value="{{ old('alamat_perempuan') ?? $dispensasi_nikah->alamat_perempuan ?? '' }}">
                                            @error('alamat_perempuan')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label class="form-label">Tempat Nikah</label>
                                            <input type="text" class="form-control @error('tempat_nikah') is-invalid @enderror" name="tempat_nikah" value="{{ old('tempat_nikah') ?? $dispensasi_nikah->tempat_nikah ?? '' }}">
                                            @error('tempat_nikah')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label class="form-label">Tanggal Nikah</label>
                                            <input type="date" class="form-control @error('tanggal_nikah') is-invalid @enderror" name="tanggal_nikah" value="{{ old('tanggal_nikah') ?? $dispensasi_nikah->tanggal_nikah ?? '' }}">
                                            @error('tanggal_nikah')
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