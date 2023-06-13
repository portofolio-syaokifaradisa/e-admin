@extends('templates.app', ['title' => 'Manajemen Layanan'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Absensi Pegawai</h4>
                            <span>Silahkan Absen pada saat pagi dan sore</span>
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
                            <h5>Form Absensi pegawai</h5> <br>
                        </div>
                        <div class="card-block">
                            <form action="{{ route('absensi.store', ['type' => $type]) }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="form-group col">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control @error('mulai') is-invalid @enderror" name="mulai" value="{{ old('mulai') ?? $survey->mulai ?? date('Y-m-d') }}">
                                        @error('mulai')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label class="form-label">Tanggal Selesai</label>
                                        <input type="date" class="form-control @error('selesai') is-invalid @enderror" name="selesai" value="{{ old('selesai') ?? $survey->selesai ?? '' }}">
                                        @error('selesai')
                                            <span class="invalid-feedback" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan Absensi</label>
                                    <input type="text" class="form-control" name="keterangan">
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