@extends('templates.app', ['title' => 'Laporan Catatan Survey'])

@section('content')
    <div class="page-wrapper">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Laporan Data Catatan Survey</h4>
                            <span>Laporan pencatatan survey yang telah dilakukan</span>
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
                                <h5 class="col">Tabel Survey</h5>
                                <div class="col text-right">
                                    <button class="btn btn-outline-primary" id="evaluation">
                                        <img src="{{ asset('icon/print.svg') }}" width="20px" class="mr-1"> Cetak Penilaian
                                    </button>
                                    <button class="btn btn-outline-primary" id="print">
                                        <img src="{{ asset('icon/print.svg') }}" width="20px" class="mr-1"> Cetak Laporan
                                    </button>
                                    <a class="btn btn-outline-primary" id="chart" href="{{ route('survey.chart') }}" target="_blank">
                                        Perbandingan IKM
                                    </a>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive w-100">
                                    <table id="datatable" class="table table-striped table-bordered w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Pendidikan</th>
                                                @for($i = 1; $i <= 9; $i++)
                                                    <th class="text-center">U{{ $i }}</th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody></tfoot>
                                        <tfoot>
                                            <tr>
                                                <th id="no">No</th>
                                                <th id="tanggal">Tahun</th>
                                                <th id="jenis_kelamin">Jenis Kelamin</th>
                                                <th id="pendidikan">Pendidikan</th>
                                                @for($i = 1; $i <= 9; $i++)
                                                    <th id="u{{ $i }}">U{{ $i }}</th>
                                                @endfor
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
    <script src="{{ asset('js/report/survey.js') }}"></script>
@endsection