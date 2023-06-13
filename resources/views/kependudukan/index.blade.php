@extends('templates.app', ['title' => 'Manajemen Data Kependudukan'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Kependudukan</h4>
                            <span>Memanajemen data-data kependudukan desa/kelurahan yang tercatat</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <a class="btn text-white btn-primary" href="{{ route('kependudukan.create') }}">
                                <i class="fas fa-plus"></i>
                                Tambah Data
                            </a>
                        </ul>
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
                            <h5 class="col">Tabel Kependudukan</h5>
                            <div class="col text-right">
                                <button class="btn btn-outline-primary" id="print">
                                    <img src="{{ asset('icon/print.svg') }}" width="20px" class="mr-1"> Cetak Laporan
                                </button>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive w-100">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Aksi</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="text-center">Desa/Kelurahan</th>
                                            <th class="text-center">Luas Wilayah</th>
                                            <th class="text-center">Jumlah Laki-laki</th>
                                            <th class="text-center">Jumlah Perempuan</th>
                                            <th class="text-center">Jumlah KK</th>
                                            <th class="text-center">Jumlah Warga</th>
                                        </tr>
                                    </thead>
                                    <tbody></tfoot>
                                    <tfoot>
                                        <tr>
                                            <th id="no">No</th>
                                            <th id="action">Aksi</th>
                                            <th id="tahun">Tahun</th>
                                            <th id="desa">Desa/Kelurahan</th>
                                            <th id="luas_wilayah">Luas Wilayah</th>
                                            <th id="jumlah_laki">Jumlah Laki-laki</th>
                                            <th id="jumlah_perempuan">Jumlah Perempuan</th>
                                            <th id="jumlah_kk">Jumlah KK</th>
                                            <th id="jumlah_warga">Jumlah Warga</th>
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
    <script src="{{ asset('js/kependudukan/index.js') }}"></script>
@endsection