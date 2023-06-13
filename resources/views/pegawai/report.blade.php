@extends('templates.report', ['title' => 'Laporan Daftar Pegawai'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">Pegawai</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Golongan</th>
            <th class="text-center">Role</th>
        </tr>
        @foreach ($pegawai as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="text-center align-middle">
                    @php
                        $foto = 'display_picture/' . $data->id. ".png";
                    @endphp
                    @if(file_exists(public_path($foto)))
                        <img src="{{ asset($foto) }}" style="width:100px; height:120px">
                    @else
                        -
                    @endif
                </td>
                <td class="align-middle">
                    {{ $data->nama }} <br>
                    {{ $data->nip }} <br>
                    {{ $data->email }}
                </td>
                <td class="align-middle text-center">{{ $data->jabatan }}</td>
                <td class="align-middle text-center">
                    {{ $data->golongan }} <br>
                    {{ $data->pangkat }}
                </td>
                <td class="align-middle text-center">
                    {{ $data->role }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection