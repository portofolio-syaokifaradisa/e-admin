@extends('templates.app', ['title' => 'Halaman Home'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-6">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Absensi Pegawai</h4>
                            <span>Silahkan Absen pada saat pagi dan sore</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            @if(!$absensi)
                                <a class="btn text-white @if($absensi->pagi ?? false) btn-disabled disabled @else btn-primary @endif" href="{{ route('absensi.pagi') }}">
                                    <i class="fas fa-pen-nib"></i>
                                    Absen Pagi
                                </a>
                                <a class="btn text-white btn-primary" href="{{ route('absensi.keterangan', ['type' => 'Izin']) }}">
                                    <i class="fas fa-pen-nib"></i>
                                    Izin
                                </a>
                                <a class="btn text-white btn-primary" href="{{ route('absensi.keterangan', ['type' => 'Cuti']) }}">
                                    <i class="fas fa-pen-nib"></i>
                                    Cuti
                                </a>
                                <a class="btn text-white btn-primary" href="{{ route('absensi.keterangan', ['type' => 'Dinas Luar']) }}">
                                    <i class="fas fa-pen-nib"></i>
                                    Dinas Luar
                                </a>
                            @endif
                            @if(($absensi->pagi ?? false) && !($absensi->sore ?? false))
                                <a class="btn text-white @if($absensi->sore || !$absensi->pagi) btn-disabled disabled @else btn-primary @endif" href="{{ route('absensi.sore') }}">
                                    @if(!$absensi->sore || !$absensi->pagi) <i class="fas fa-pen-nib"></i> @endif
                                    Absen Sore
                                </a>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header row">
                                <h5 class="col">Histori Absensi</h5>
                                <div class="col text-right">
                                    <button class="btn btn-outline-primary" id="print">
                                        <img src="{{ asset('icon/print.svg') }}" width="20px" class="mr-1"> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive w-100">
                                    <table id="datatable" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Masuk</th>
                                                <th class="text-center">Keluar</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody></tfoot>
                                        <tfoot>
                                            <tr>
                                                <th id="no">No</th>
                                                <th id="tanggal">Tanggal</th>
                                                <th id="masuk">Masuk</th>
                                                <th id="keluar">Keluar</th>
                                                <th id="status"></th>
                                                <th id="keterangan">Keterangan</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-extends')
    <script src="{{ asset('js/home/index.js') }}"></script>
@endsection