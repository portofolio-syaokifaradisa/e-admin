@extends('templates.report', ['title' => 'Laporan Daftar Desa'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Alamat</th>
        </tr>
        @foreach ($desa as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="align-middle">
                    {{ $data->nama_desa }}
                </td>
                <td class="align-middle">{{ $data->alamat }}</td>
            </tr>
        @endforeach
    </table>
@endsection