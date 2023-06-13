@extends('templates.app', ['title' => 'Laporan Catatan Dispensasi Nikah'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Laporan Pencatatan Dispensasi Nikah</h4>
                            <span>Laporan data-data dispensasi nikah yang tercatat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success mb-2">{{ Session::get('success') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header row">
                            <h5 class="col">Laporan Dispensasi Nikah</h5>
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
                                            <th class="text-center">Tahun</th>
                                            <th class="text-center">Asal Desa/Kelurahan</th>
                                            <th class="text-center">Mempelai Perempuan</th>
                                            <th class="text-center">Mempelai Laki-laki</th>
                                            <th class="text-center">Tempat Nikah</th>
                                            <th class="text-center">Tanggal Nikah</th>
                                        </tr>
                                    </thead>
                                    <tbody></tfoot>
                                    <tfoot>
                                        <tr>
                                            <th id="no">No</th>
                                            <th id="tahun">Tahun</th>
                                            <th id="desa">Asal Desa/Kelurahan</th>
                                            <th id="mempelai_perempuan">Mempelai Perempuan</th>
                                            <th id="mempelai_laki">Mempelai Laki-laki</th>
                                            <th id="tempat_nikah">Tempat Nikah</th>
                                            <th id="tanggal_nikah">Tanggal Nikah</th>
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
    <script src="{{ asset('js/report/dispensasi.js') }}"></script>
@endsection