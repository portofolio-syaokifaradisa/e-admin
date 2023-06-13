@extends('templates.app', ['title' => 'Laporan Absensi Pegawai'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Laporan Absensi Pegawai</h4>
                            <span>Laporan data-data absensi pegawai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header row">
                            <h5 class="col">Laporan Absensi</h5>
                            <div class="col text-right">
                                <button class="btn btn-outline-primary" id="summary">
                                    <img src="{{ asset('icon/print.svg') }}" width="20px" class="mr-1"> Cetak Ringkasan
                                </button>
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
                                            <th class="text-center">Pegawai</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Jam Masuk</th>
                                            <th class="text-center">Jam Keluar</th>
                                            <th class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody></tfoot>
                                    <tfoot>
                                        <tr>
                                            <th id="no">No</th>
                                            <th id="tanggal">Tanggal</th>
                                            <th id="pegawai">Pegawai</th>
                                            <th id="status">Status</th>
                                            <th id="pagi">Jam Masuk</th>
                                            <th id="sore">Jam Keluar</th>
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
@endsection

@section('js-extends')
    <script src="{{ asset('js/report/absensi.js') }}"></script>
@endsection