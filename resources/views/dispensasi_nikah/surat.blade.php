@extends('templates.report', ['title' => ''])

@section('content')
    <table style="width: 100%">
        <tr>
            <td>

            </td>
            <td style="padding-left: 80px">
                Kandangan, {{ $tanggal_sekarang }}<br> 
                Kepada : <br>
            </td>
        </tr>
        <tr>
            <td>
                <span style="width: 60px; display: inline-block;">
                    Nomor
                </span>
                : 472.21 <br>
                <span style="width: 60px; display: inline-block;">
                    Sifat
                </span>
                : Penting <br>
                <span style="width: 60px; display: inline-block;">
                    Lamp
                </span>
                : - <br>
                <span style="width: 60px; display: inline-block;">
                    Perihal
                </span>
                : Dispensasi Nikah <br>
            </td>
            <td style="padding-left: 30px">
                Yth. Kepala Kantor Urusan Agama
                <div style="padding-left: 50px">
                    Kecamatan Kandangan, <br>
                    di -
                    <div style="padding-left: 30px">
                        <u>Kandangan</u>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div style="padding-left: 70px; text-align: justify; margin-top: 30px">
        Berdasarkan Peraturan Pemerintah RI Nomor 09 Tahun 1975 Tentang Pelaksanaan Undang-Undang Nomor 01 Tahun 1974 Tentang Perkawinan Bab II Pasal 3 Ayat 3 dan Peraturan Menteri Agama ( PMA ) nomor 11 Tahun 2007 Bab IX Pasal 16 Ayat 2 serta surat permohonan yang bersangkutan tanggal {{ $tanggal_sekarang }}. Camat Kandangan atas nama Bupati Hulu Sungai Selatan tidak keberatan dan memberikan Dispensasi kepada :
        <table style="padding-left: 50px">
            <tr>
                <td style="width: 150px">Nama</td>
                <td>: {{ $nama_laki }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Tempat tanggal lahir</td>
                <td>: {{ $tempat_lahir_laki }}, {{ $tanggal_lahir_laki }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Jenis Kelamin</td>
                <td>: Laki-laki</td>
            </tr>
            <tr>
                <td style="width: 150px">Agama</td>
                <td>: {{ $agama_laki }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Pekerjaan</td>
                <td>: {{ $pekerjaan_laki }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Alamat</td>
                <td>: {{ $alamat_laki }}</td>
            </tr>
        </table>
    </div>

    <div style="padding-left: 70px; text-align: justify">
        Melaksanakan Pernikahan pada hari {{ $hari_nikah }} tanggal {{ $tanggal_nikah }} di {{ $tempat_nikah }} dengan seorang Perempuan :
        <table style="padding-left: 50px">
            <tr>
                <td style="width: 150px">Nama</td>
                <td>: {{ $nama_perempuan }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Tempat tanggal lahir</td>
                <td>: {{ $tempat_lahir_perempuan }}, {{ $tanggal_lahir_perempuan }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Jenis Kelamin</td>
                <td>: Perempuan</td>
            </tr>
            <tr>
                <td style="width: 150px">Agama</td>
                <td>: {{ $agama_perempuan }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Pekerjaan</td>
                <td>: {{ $pekerjaan_perempuan }}</td>
            </tr>
            <tr>
                <td style="width: 150px">Alamat</td>
                <td>: {{ $alamat_perempuan }}</td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 10px; padding-left: 70px; text-align: justify">
        Dilakukan kurang dari 10 ( sepuluh ) hari dengan alasan hari dan tanggal pelaksanaan sudah ditentukan. Demikian Dispensasi ini diberikan untuk dapat dipergunakan sebagaimana mestinya.
    </div>
@endsection