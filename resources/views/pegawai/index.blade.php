@extends('templates.app', ['title' => 'Manajemen Pegawai'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Manajemen Data Pegawai</h4>
                            <span>Memanajemen data-data pegawai yang terdaftar</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <a class="btn text-white btn-primary" href="{{ route('pegawai.create') }}">
                                Tambah Pegawai
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
                                <h5 class="col">Tabel Pegawai</h5>
                                <div class="col text-right">
                                    <button class="btn btn-outline-primary" id="print">
                                        <img src="{{ asset('icon/print.svg') }}" width="20px" class="mr-1"> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="w-100 table-responsive">
                                    <table id="datatable" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Aksi</th>
                                                <th class="text-center">Foto</th>
                                                <th class="text-center">Identitas</th>
                                                <th class="text-center">Jabatan</th>
                                                <th class="text-center">Pangkat</th>
                                                <th class="text-center">Golongan</th>
                                                <th class="text-center">Role</th>
                                            </tr>
                                        </thead>
                                        <tbody></tfoot>
                                        <tfoot>
                                            <tr>
                                                <th id="no">No</th>
                                                <th id="action">Aksi</th>
                                                <th id="foto">Foto</th>
                                                <th id="nama_nip">Identitas</th>
                                                <th id="jabatan">Jabatan</th>
                                                <th id="pangkat">Pangkat</th>
                                                <th id="golongan">Golongan</th>
                                                <th id="role">Role</th>
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
    <script src="{{ asset('js/pegawai/index.js') }}"></script>
@endsection