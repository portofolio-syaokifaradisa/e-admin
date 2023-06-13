@extends('templates.report', ['title' => 'Laporan Daftar Layanan Desa'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
        </tr>
        @foreach ($layanan as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="align-middle">
                    {{ $data->nama }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection