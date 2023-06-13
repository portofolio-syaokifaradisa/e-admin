@extends('templates.report', ['title' => 'Laporan Daftar Dispensasi Nikah'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Desa/Kelurahan</th>
            <th class="text-center">Tanggal<br>Nikah</th>
            <th class="text-center">Tempat<br>Nikah</th>
            <th class="text-center">Mempelai<br>Laki-laki</th>
            <th class="text-center">Mempelai<br>Perempuan</th>
        </tr>
        @foreach ($dispensasi_nikah as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="text-center align-middle">{{ $data->tahun }}</td>
                <td class="text-center align-middle">{{ $data->desa->nama_desa }}</td>
                <td class="text-center align-middle">{{ $data->tanggal_nikah }}</td>
                <td class="text-center align-middle">{{ $data->tempat_nikah }}</td>
                <td class="text-center align-middle">{{ $data->mempelai_laki}}</td>
                <td class="text-center align-middle">{{ $data->mempelai_perempuan}}</td>
            </tr>
        @endforeach
    </table>
@endsection