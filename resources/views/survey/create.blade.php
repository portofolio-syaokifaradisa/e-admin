@extends('templates.app', ['title' => 'Manajemen Catatan Survey'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Catatan Survey</h4>
                            <span>Memanajemen pencatatan survey yang telah dilakukan</span>
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
                                <h5>Form Pencatatan Survey</h5> <br>
                            </div>
                            <div class="card-block">
                                <form action="{{ isset($survey) ? route('survey.update', ['id' => $survey->id]) : route('survey.store') }}" method="post">
                                    @csrf
                                    @if(isset($survey))
                                        @method("PUT")
                                    @endif

                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="form-label">Tanggal Survey</label>
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') ?? $survey->tanggal ?? date('Y-m-d') }}">
                                            @error('tanggal')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col" style="width: 100%">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-control select2 category-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin">
                                                <option value="" hidden selected>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki" @if((old("jenis_kelamin") ?? $survey->jenis_kelamin ?? '') == "Laki-laki") selected @endif>Laki-laki</option>
                                                <option value="Perempuan" @if(old("jenis_kelamin") ?? $survey->jenis_kelamin ?? '' == "Perempuan") selected @endif>Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col" style="width: 100%">
                                            <label class="form-label">Pendidikan</label>
                                            <select class="form-control select2 category-select @error('pendidikan') is-invalid @enderror" name="pendidikan">
                                                <option value="" hidden selected>Pilih Pendidikan</option>
                                                <option value="SD" @if((old("pendidikan") ?? $survey->pendidikan ?? '') == "SD") selected @endif>SD</option>
                                                <option value="SMP" @if((old("pendidikan") ?? $survey->pendidikan ?? '') == "SMP") selected @endif>SMP</option>
                                                <option value="SMA" @if((old("pendidikan") ?? $survey->pendidikan ?? '') == "SMA") selected @endif>SMA</option>
                                                <option value="D1-D3-D4" @if((old("pendidikan") ?? $survey->pendidikan ?? '') == "D1-D3-D4") selected @endif>D1-D3-D4</option>
                                                <option value="S1" @if((old("pendidikan") ?? $survey->pendidikan ?? '') == "S1") selected @endif>S1</option>
                                                <option value=">S2" @if((old("pendidikan") ?? $survey->pendidikan ?? '') == "S2") selected @endif>>S2</option>
                                            </select>
                                            @error('pendidikan')
                                                <span class="invalid-feedback" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        @php
                                            $pertanyaan = [
                                                'Kesesuaian Persyaratan',
                                                'Prosedur Pelayanan',
                                                'Kecepatan Pelayanan',
                                                'Kesesuaian/Kewjaran Biaya',
                                                'Kesesuaian Pelayanan',
                                                'Kompetensi Petugas',
                                                'Perilaku Petugas dan Pelayanan',
                                                'Kualitas Sarana dan Prasarana',
                                                'Penanganan Pengaduan'
                                            ];

                                            $options = [
                                                ['Tidak Sesuai', 'Kurang Sesuai', 'Sesuai', 'Sangat Sesuai'],
                                                ['Tidak Mudah', 'Kurang Mudah', 'Mudah', 'Sangat Mudah'],
                                                ['Tidak Cepat', 'Kurang Cepat', 'Cepat', 'Sangat Cepat'],
                                                ['Sangat Mahal', 'Cukup Mahal', 'Murah', 'Gratis'],
                                                ['Tidak Sesuai', 'Kurang Sesuai', 'Sesuai', 'Sangat Sesuai'],
                                                ['Tidak Kompeten', 'Kurang Kompeten', 'Kompeten', 'Sangat Kompeten'],
                                                ['Tidak Sopan dan Ramah', 'Kurang Sopan dan Ramah', 'Sopan dan Ramah', 'Sangat Sopan dan Ramah'],
                                                ['Buruk', 'Cukup', 'Baik', 'Sangat Baik'],
                                                ['Tidak Ada', 'Ada Tetapi Tidak Berfungsi', 'Berfungsi Kurang Maksimal', 'Dikelola dengan Baik']
                                            ];
                                        @endphp
                                        @foreach ($pertanyaan as $index => $value)
                                            @php
                                                $index = $index + 1;
                                            @endphp
                                            <div class="form-group col-4" style="width: 100%">
                                                <label class="form-label">{{ $value . " (U$index)" }}</label>
                                                <select class="form-control select2 category-select @error("u$index") is-invalid @enderror" name="{{ "u$index" }}">
                                                    <option value="" hidden selected>Pilih Penilaian</option>
                                                    @foreach ($options[$index - 1] as $value_index => $option)
                                                        @php
                                                            $isSelected = (old("u$index") ?? isset($survey) ? $survey->toArray()["u$index"] : '') == ($value_index + 1);
                                                        @endphp
                                                        <option value="{{ $value_index + 1 }}" @if($isSelected) selected @endif>
                                                            {{ $option }}
                                                        </option> 
                                                    @endforeach
                                                </select>
                                                @error("u$index")
                                                    <span class="invalid-feedback" role="alert">
                                                        <small>{{ $message }}</small>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endforeach
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