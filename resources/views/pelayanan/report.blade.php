@extends('templates.report', ['title' => 'Laporan Daftar Pelayanan'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Layanan</th>
            <th class="text-center">Desa/Kelurahan</th>
            <th class="text-center">Peminta</th>
            <th class="text-center">Jenis Kelamin</th>
        </tr>
        @foreach ($pelayanan as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="align-middle text-center">{{ $data->date }}</td>
                <td class="align-middle text-center">{{ $data->layanan->nama }}</td>
                <td class="align-middle text-center">{{ $data->desa->nama_desa }} </td>
                <td class="align-middle text-center">{{ $data->nama }}</td>
                <td class="align-middle text-center">{{ $data->gender }}</td>
            </tr>
        @endforeach
    </table>
@endsection