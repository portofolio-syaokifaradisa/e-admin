@extends('templates.report', ['title' => 'Laporan Daftar Survey'])

@section('content')
    <table class="border-table">
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Jenis Kelamin</th>
            <th class="text-center">Pendidikan</th>
            @for($i = 1; $i < 10; $i++)
                <th class="text-center">{{ "U".$i }}</th>
            @endfor
        </tr>
        @foreach ($survey as $index => $data)
            <tr>
                <td class="text-center align-middle">{{ $index + 1 }}</td>
                <td class="text-center align-middle">{{ $data->tanggal }} </td>
                <td class="text-center align-middle">{{ $data->jenis_kelamin }} </td>
                <td class="text-center align-middle">{{ $data->pendidikan }} </td>
                @for($i = 1; $i < 10; $i++)
                    <th class="text-center">{{ $data["u".$i] }}</th>
                @endfor
            </tr>
        @endforeach
    </table>
@endsection