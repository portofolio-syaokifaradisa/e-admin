<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Indeks Kepuasan Masyarakat</title>
    <style>
        *{
            font-size: 10pt;
        }
        .border-table{
            border: 1px solid;
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table style="width: 100%; border:1px solid;">
        <tr>
            <td colspan="2" style="text-align: center; font-weight: 700; padding-top: 10px; font-size: 12pt">
                INDEKS KEPUASAN MASYARAKAT (IKM) <br>
                KECAMATAN KANDANGAN <br>
                KABUPATEN HULU SUNGAI SELATAN <br>
                TAHUN {{ (date('Y', strtotime($data['start_date'])) == date('Y', strtotime($data['end_date']))) ? date('Y', strtotime($data['start_date'])) : date('Y', strtotime($data['start_date'])) . " - " . date('Y', strtotime($data['end_date'])) }}<br>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; padding: 10px">
                <table class="border-table">
                    <tr>
                        <td style="text-align: center; border: 1px solid;">NILAI IKM</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; height: 248px; font-weight: 700; font-size: 90pt">{{ str_replace(".", ",", round($data['ikm'], 2)) }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; padding-left: 10px; padding-top: 10px; padding-bottom: 10px">
                <table class="border-table">
                    <tr>
                        <td style=" border: 1px solid;">
                            NAMA LAYANAN : ADMINISTRASI KECAMATAN
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding-top: 5px">
                            <b>RESPONDEN</b>
                            <br>
                            <br>
                            <table>
                                <tr>
                                    <td style="width: 130px">JUMLAH</td>    
                                    <td>:</td>
                                    <td colspan="3">{{ $data['jumlah'] }} Orang</td>
                                </tr>    
                                <tr>
                                    <td style="vertical-align: top">JENIS KELAMIN</td>    
                                    <td style="vertical-align: top">:</td>
                                    <td>
                                        <table>
                                            @foreach ($data['jenis_kelamin'] as $jenis_kelamin => $jumlah)
                                                <tr>
                                                    <td style="width: 60px">{{ $jenis_kelamin }}</td>
                                                    <td>=</td>
                                                    <td>{{ $jumlah }} Orang</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr> 
                                <tr>
                                    <td style="vertical-align: top; s">PENDIDIKAN</td>    
                                    <td style="vertical-align: top">:</td>
                                    <td>
                                        <table>
                                            @foreach (["SD", "SMP", "SMA", "D1-D3-D4", 'S1', '>S2'] as $pendidikan)
                                                <tr>
                                                    <td style="width: 60px">{{ $pendidikan }}</td>
                                                    <td>=</td>
                                                    <td>{{ $data['pendidikan'][$pendidikan] }} Orang</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>   
                                <tr>
                                    <td>PERIODE SURVEY</td>    
                                    <td>:</td>
                                    <td colspan="3">{{ $data['start_date']. " s/d " . $data['end_date'] }}</td>
                                </tr>  
                            </table> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: 400; font-size: 10pt; padding-top: 20px; padding-bottom: 20px">
                TERIMA KASIH ATAS PENILAIAN YANG TELAH ANDA BERIKAN <br>
                MASUKAN ANDA SANGAT BERMANFAAT UNTUK KEMAJUAN UNIT KAMI AGAR TERUS MEMPERBAIKI <br>
                DAN MENINGKATKAN KUALITAS PELAYANAN BAGI MASYARAKAT
            </td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 40px">
        <tr>
            <td style="width: 60%"></td>
            <td style="text-align: center">
                <b>CAMAT KANDANGAN</b>
                <br><br><br><br><br>
                <b>
                    <u>H.SYAMSURI, SSTP, M.SI</u><br>
                    NIP. 198101112000121002
                </b>
            </td>
        </tr>
    </table>
</body>
</html>