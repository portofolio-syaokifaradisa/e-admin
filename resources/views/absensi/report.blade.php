@extends('templates.report', ['title' => $title])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tanggal</th>
            @if(!$is_private)
                <th class="text-center">Pegawai</th>
            @endif
            <th class="text-center">Masuk/Keluar</th>
            <th class="text-center">Status</th>
            <th class="text-center">Keterangan</th>
        </tr>
        @foreach ($absensi as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="text-center align-middle">{{ $data->tanggal }}</td>
                @if(!$is_private)
                    <td class="align-middle">
                        {{ $data->user->nama }} <br>
                        {{ $data->user->nip }}
                    </td>
                @endif
                <td class="text-center align-middle">
                    {{ date("H:i", strtotime($data->pagi)) . "/" . date("H:i", strtotime($data->sore)) }}
                </td>
                <td class="text-center align-middle">
                    {{ $data->status }}
                </td>
                <td class="text-center align-middle">
                    {{ $data->keterangan }}
                </td>
            </tr>
        @endforeach
    </table>
@endsection