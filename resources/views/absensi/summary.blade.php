@extends('templates.report', ['title' => 'Laporan Daftar Absensi Pegawai'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">NIP</th>
            <th class="text-center">Hadir</th>
            <th class="text-center">Izin</th>
            <th class="text-center">Cuti</th>
            <th class="text-center">Dinas<br>Luar</th>
            <th class="text-center">Total</th>
        </tr>
        @foreach ($absensi as $data)
            <tr>
                <td class="text-center align-middle">{{ $loop->index + 1 }}</td>
                <td class="text-center align-middle">{{ $data['nama'] }}</td>
                <td class="text-center align-middle">{{ $data['nip'] }}</td>
                <td class="text-center align-middle">{{ $data['Hadir'] ?? 0 }}</td>
                <td class="text-center align-middle">{{ $data['Izin'] ?? 0 }}</td>
                <td class="text-center align-middle">{{ $data['Cuti'] ?? 0 }}</td>
                <td class="text-center align-middle">{{ $data['Dinas Luar'] ?? 0 }}</td>
                <td class="text-center align-middle">
                    {{ ($data['Hadir'] ?? 0) + ($data['Izin'] ?? 0) + ($data['Cuti'] ?? 0) + ($data['Dinas Luar'] ?? 0) }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection