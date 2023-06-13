@extends('templates.report', ['title' => 'Laporan Daftar kependudukan'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Desa/Kelurahan</th>
            <th class="text-center">Luas Wilayah</th>
            <th class="text-center">Total Laki-laki</th>
            <th class="text-center">Total Perempuan</th>
            <th class="text-center">Total KK</th>
            <th class="text-center">Total Warga</th>
        </tr>
        @foreach ($kependudukan as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="text-center align-middle">{{ $data->tahun }}</td>
                <td class="text-center align-middle">{{ $data->desa->nama_desa }}</td>
                <td class="text-center align-middle">{{ $data->luas_wilayah }}</td>
                <td class="text-center align-middle">{{ $data->total_laki }}</td>
                <td class="text-center align-middle">{{ $data->total_perempuan}}</td>
                <td class="text-center align-middle">{{ $data->total_kk}}</td>
                <td class="text-center align-middle">{{ $data->total_warga}}</td>
            </tr>
        @endforeach
    </table>
@endsection