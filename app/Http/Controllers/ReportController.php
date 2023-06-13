<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Survey;
use App\Models\Absensi;
use App\Models\Pelayanan;
use App\Models\Kependudukan;
use Illuminate\Http\Request;
use App\Models\DispensasiNikah;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function pegawai(){
        return view('reports.pegawai');
    }

    public function absensi(){
        return view('reports.absensi');
    }

    public function kependudukan(){
        return view('reports.kependudukan');
    }

    public function pelayanan(){
        return view('reports.pelayanan');
    }

    public function dispensasi(){
        return view('reports.dispensasi');
    }

    public function survey(){
        return view('reports.survey');
    }

    public function pegawaiDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = User::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('nama', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $nama_nip_search = $request->columns[2]['search']['value'];
        if($nama_nip_search){
            $records = $records->where('nama', 'like', "%{$nama_nip_search}%");
            $records = $records->orwhere('nip', 'like', "%{$nama_nip_search}%");
            $records = $records->orwhere('email', 'like', "%{$nama_nip_search}%");
        }

        $jabatanSearch = $request->columns[3]['search']['value'];
        if($jabatanSearch){
            $records = $records->where('jabatan', 'like', "%{$jabatanSearch}%");
        }

        $pangkatSearch = $request->columns[4]['search']['value'];
        if($pangkatSearch){
            $records = $records->where('pangkat', 'like', "%{$pangkatSearch}%");
        }

        $golonganSearch = $request->columns[5]['search']['value'];
        if($golonganSearch){
            $records = $records->where('golongan', 'like', "%{$golonganSearch}%");
        }

        $roleSearch = $request->columns[6]['search']['value'];
        if($roleSearch && $roleSearch != "Semua"){
            $records = $records->where('role', $roleSearch);
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->where('role', '!=', 'Superadmin')->count();
        $totalRecord = User::where('role', '!=', 'Superadmin')->count();
        $records = $records->where('role', '!=', 'Superadmin')->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $foto = 'display_picture/' . $record->id. ".png";
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "nama" => $record->nama,
                "nip" => $record->nip,
                "email" => $record->email,
                'jabatan' => $record->jabatan,
                'pangkat' => $record->pangkat,
                'golongan' => $record->golongan,
                'role' => $record->role,
                'foto' => file_exists(public_path($foto)) ? asset($foto) : '-'
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function absensiDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Absensi::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('tanggal', 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tanggalSearch = $request->columns[1]['search']['value'];
        if($tanggalSearch){
            $dates = explode("-", $tanggalSearch);
            $records = $records->whereYear('tanggal', $dates[0]);
            $records = $records->whereMonth('tanggal', $dates[1]);
        }

        $pegawaiSearch = $request->columns[2]['search']['value'];
        if($pegawaiSearch){
            $records = $records->wherehas('user', function($q) use ($pegawaiSearch){
                $q->where('nama', 'like', "%{$pegawaiSearch}%");
                $q->orwhere('nip', 'like', "%{$pegawaiSearch}%");
            });
        }

        $statusSearch = $request->columns[3]['search']['value'];
        if($statusSearch && $statusSearch != "Semua"){
            $records = $records->where('status', $statusSearch);
        }

        $pagiSearch = $request->columns[4]['search']['value'];
        if($pagiSearch){
            $records = $records->where('pagi', $pagiSearch);
        }

        $soreSearch = $request->columns[5]['search']['value'];
        if($soreSearch){
            $records = $records->where('sore', $soreSearch);
        }

        $keteranganSearch = $request->columns[6]['search']['value'];
        if($keteranganSearch){
            $records = $records->where('keterangan', 'like', "%{$keteranganSearch}%");
        } 

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Absensi::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "nama" => $record->user->nama,
                "nip" => $record->user->nip,
                "tanggal" => $record->tanggal,
                "masuk" => $record->pagi ?? '-',
                'keluar' => $record->sore ?? '-',
                'status' => $record->status,
                'keterangan' => $record->keterangan,
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function kependudukanDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Kependudukan::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('id', 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tahunSearch = $request->columns[1]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }
        
        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch && $desaSearch != "Semua"){
            $records = $records->where('desa_id', $desaSearch);
        }

        $luasWilayahSearch = $request->columns[3]['search']['value'];
        if($luasWilayahSearch){
            $records = $records->where('luas_wilayah', 'like', "%{$luasWilayahSearch}%");
        }

        $jumlahLakiSearch = $request->columns[4]['search']['value'];
        if($jumlahLakiSearch){
            $records = $records->where('total_laki', 'like', "%{$jumlahLakiSearch}%");
        }

        $jumlahPerempuanSearch = $request->columns[5]['search']['value'];
        if($jumlahPerempuanSearch){
            $records = $records->where('total_perempuan', 'like', "%{$jumlahPerempuanSearch}%");
        }

        $jumlahKKSearch = $request->columns[6]['search']['value'];
        if($jumlahKKSearch){
            $records = $records->where('total_kk', 'like', "%{$jumlahKKSearch}%");
        }

        $jumlahWargaSearch = $request->columns[7]['search']['value'];
        if($jumlahWargaSearch){
            $records = $records->where('total_warga', 'like', "%{$jumlahWargaSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Kependudukan::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "tahun" => $record->tahun,
                'desa' => $record->desa->nama_desa,
                'luas_wilayah' => $record->luas_wilayah,
                'jumlah_laki' => $record->total_laki,
                'jumlah_perempuan' => $record->total_perempuan,
                'jumlah_kk' => $record->total_kk,
                'jumlah_warga' => $record->total_warga,
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function pelayananDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Pelayanan::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('date', 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $dateSearch = $request->columns[1]['search']['value'];
        if($dateSearch){
            $dates = explode("-", $dateSearch);
            $records = $records->whereYear('date', $dates[0]);
            $records = $records->whereMonth('date', $dates[1]);
        }

        $layananSearch = $request->columns[2]['search']['value'];
        if($layananSearch && $layananSearch != "Semua"){
            $records = $records->where('layanan_id', $layananSearch);
        }

        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch && $desaSearch != "Semua"){
            $records = $records->where('desa_id', $desaSearch);
        }

        $namaSearch = $request->columns[4]['search']['value'];
        if($namaSearch){
            $records = $records->where('nama', 'like', "%{$namaSearch}%");
        }

        $genderSearch = $request->columns[5]['search']['value'];
        if($genderSearch && $genderSearch != "Semua"){
            $records = $records->where('gender', $genderSearch);
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Pelayanan::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "tanggal" => $record->date,
                "desa" => $record->desa->nama_desa,
                "layanan" => $record->layanan->nama,
                "nama" => $record->nama,
                "gender" => $record->gender,
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function dispensasiDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = DispensasiNikah::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('id', 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tahunSearch = $request->columns[1]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }

        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch && $desaSearch != "Semua"){
            $records = $records->where('desa_id', $desaSearch);
        }

        $mempelaiPerempuanSearch = $request->columns[3]['search']['value'];
        if($mempelaiPerempuanSearch){
            $records = $records->where('mempelai_perempuan', 'like', "%{$mempelaiPerempuanSearch}%");
        }

        $memperlaiLakiSearch = $request->columns[4]['search']['value'];
        if($memperlaiLakiSearch){
            $records = $records->where('mempelai_laki', 'like', "%{$memperlaiLakiSearch}%");
        }

        $tempatNikahSearch = $request->columns[5]['search']['value'];
        if($tempatNikahSearch){
            $records = $records->where('tempat_nikah', 'like', "%{$tempatNikahSearch}%");
        }

        $tanggalNikahSearch = $request->columns[6]['search']['value'];
        if($tanggalNikahSearch){
            $dates = explode("-", $tanggalNikahSearch);
            $records = $records->whereYear('created_at', $dates[0]);
            $records = $records->whereMonth('created_at', $dates[1]);
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = DispensasiNikah::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "desa" => $record->desa->nama_desa,
                "tahun" => $record->tahun,
                "mempelai_perempuan" => $record->mempelai_perempuan,
                "mempelai_laki" => $record->mempelai_laki,
                "tanggal_nikah" => $record->tanggal_nikah,
                "tempat_nikah" => $record->tempat_nikah,
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function surveyDatatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Survey::orderBy('tanggal', 'DESC');

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('tanggal', 'DESC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $tanggalSearch = $request->columns[1]['search']['value'];
        if($tanggalSearch){
            $records = $records->where('tanggal', 'like', "%{$tanggalSearch}%");
        }

        $genderSearch = $request->columns[2]['search']['value'];
        if($genderSearch && $genderSearch != "Semua"){
            $records = $records->where('jenis_kelamin', $genderSearch);
        }

        $pendidikanSearch = $request->columns[3]['search']['value'];
        if($pendidikanSearch && $pendidikanSearch != "Semua"){
            $records = $records->where('pendidikan', $pendidikanSearch);
        }

        for($i = 4 ; $i <= 12; $i++){
            if($request->columns[$i]['search']['value'] && $request->columns[$i]['search']['value'] != "Semua"){
                $records = $records->where('u'.($i - 3), $request->columns[$i]['search']['value']);
            }
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Survey::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "tanggal" => $record->tanggal,
                "jenis_kelamin" => $record->jenis_kelamin,
                "pendidikan" => $record->pendidikan,
                "u1" => $record->u1,
                "u2" => $record->u2,
                "u3" => $record->u3,
                "u4" => $record->u4,
                "u5" => $record->u5,
                "u6" => $record->u6,
                "u7" => $record->u7,
                "u8" => $record->u8,
                "u9" => $record->u9,
            );
        }

        /* ================== [8] Mengirim JSON ================== */
        echo json_encode([
            "draw" => intval($request->draw),
            "iTotalRecords" => $totalRecord,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        ]);
    }

    public function pegawaiReport(Request $request){
        $records = User::query();
        
        if($request->nama_nip){
            $records = $records->where('nama', 'like', "%{($request->nama_nip}%");
            $records = $records->orwhere('nip', 'like', "%{($request->nama_nip}%");
            $records = $records->orwhere('email', 'like', "%{($request->nama_nip}%");
        }

        if($request->jabatan){
            $records = $records->where('jabatan', 'like', "%{$request->jabatan}%");
        }

        if($request->pangkat){
            $records = $records->where('pangkat', 'like', "%{$request->pangkat}%");
        }

        if($request->golongan){
            $records = $records->where('golongan', 'like', "%{$request->golongan}%");
        }

        if($request->role && $request->role != "Semua"){
            $records = $records->where('role', $request->role);
        }

        $pdf = Pdf::loadView('pegawai.report', [
            'pegawai' => $records->get()
        ]);
        return $pdf->stream('Laporan Daftar Pegawai.pdf');
    }

    public function absensiReport(Request $request){
        $records = Absensi::with('user')->orderBy('tanggal');

        if($request->tanggal){
            $dates = explode("-", $request->tanggal);
            $records = $records->whereYear('tanggal', $dates[0]);
            $records = $records->whereMonth('tanggal', $dates[1]);
        }

        if($request->pegawai){
            $records = $records->wherehas('user', function($q) use ($request){
                $q->where('nama', 'like', "%{$request->pegawai}%");
                $q->orwhere('nip', 'like', "%{$request->pegawai}%");
            });
        }

        if($request->status && $request->status != "Semua"){
            $records = $records->where('status', $request->status);
        }

        if($request->pagi){
            $records = $records->where('pagi', $request->pagi);
        }

        if($request->sore){
            $records = $records->where('sore', $request->sore);
        }

        if($request->keterangan){
            $records = $records->where('keterangan', 'like', "%{$request->keterangan}%");
        } 

        $pdf = Pdf::loadView('absensi.report', [
            'absensi' => $records->get(),
            'title' => 'Laporan Daftar Absensi Pegawai',
            'is_private' => false
        ]);

        return $pdf->stream('Laporan Daftar Absensi Pegawai.pdf');
    }

    public function absensiSummary(Request $request){
        $records = Absensi::with('user')->orderBy('tanggal');

        if($request->tanggal){
            $dates = explode("-", $request->tanggal);
            $records = $records->whereYear('tanggal', $dates[0]);
            $records = $records->whereMonth('tanggal', $dates[1]);
        }

        $absensi = $records->get();
        $data = [];

        foreach($absensi as $absen){
            if(isset($data[$absen->user_id])){
                if(isset($data[$absen->user_id][$absen->status])){
                    $data[$absen->user_id][$absen->status]++;
                }else{
                    $data[$absen->user_id][$absen->status] = 1;
                }
            }else{
                $data[$absen->user_id] = [
                    $absen->status => 1,
                    'nama' => $absen->user->nama,
                    'nip' => $absen->user->nip,
                ];
            }
        }

        $pdf = Pdf::loadView('absensi.summary', ['absensi' => $data]);
        return $pdf->stream('Laporan Ringkasan Absensi Pegawai.pdf');
    }

    public function kependudukanReport(Request $request){
        $records = Kependudukan::query();
     
        if($request->tahun){
            $records = $records->where('tahun', 'like', "%{$request->tahun}%");
        }

        if($request->desa && $request->desa != "Semua"){
            $records = $records->where('desa_id', $request->desa);
        }

        if($request->alamat){
            $records = $records->wherehas('desa', function($q) use ($request){
                $q->where('alamat', 'like', "%{$request->alamat}%");
            });
        }

        if($request->luas_wilayah){
            $records = $records->where('luas_wilayah', 'like', "%{$request->luas_wilayah}%");
        }

        if($request->jumlah_laki){
            $records = $records->where('total_laki', 'like', "%{$request->jumlah_laki}%");
        }

        if($request->jumlah_perempuan){
            $records = $records->where('total_perempuan', 'like', "%{$request->jumlah_perempuan}%");
        }

        if($request->jumlah_kk){
            $records = $records->where('total_kk', 'like', "%{$request->jumlah_kk}%");
        }

        if($request->jumlah_warga){
            $records = $records->where('jumlah_warga', 'like', "%{$request->jumlah_warga}%");
        }

        $pdf = Pdf::loadView('kependudukan.report', [
            'kependudukan' => $records->get()
        ]);
        
        return $pdf->stream('Laporan Daftar Kependudukan.pdf');
    }

    public function pelayananReport(Request $request){
        $records = Pelayanan::with('layanan', 'desa')->orderBy('date');

        if($request->tanggal){
            $dates = explode("-", $request->tanggal);
            $records = $records->whereYear('created_at', $dates[0]);
            $records = $records->whereMonth('created_at', $dates[1]);
        }

        if($request->layanan && $request->layanan != "Semua"){
            $records = $records->where('layanan_id', $request->layanan);
        }

        if($request->desa && $request->desa != "Semua"){
            $records = $records->where('desa_id', $request->desa);
        }

        if($request->nama){
            $records = $records->where('nama', 'like', "%{$request->nama}%");
        }

        if($request->gender && $request->gender != "Semua"){
            $records = $records->where('gender', $request->gender);
        }

        $pdf = Pdf::loadView('pelayanan.report', [
            'pelayanan' => $records->get()
        ]);
        return $pdf->stream('Laporan Daftar Pelayanan.pdf');
    }

    public function dispensasiReport(Request $request){
        $records = DispensasiNikah::with('desa')->orderBy('id', 'DESC');
        if($request->tahun){
            $records = $records->where('tahun', 'like', "%{$request->tahun}%");
        }

        if($request->desa && $request->desa != "Semua"){
            $records = $records->where('desa_id', $request->desa);
        }

        if($request->mempelai_perempuan){
            $records = $records->where('mempelai_perempuan', 'like', "%{$request->mempelai_perempuan}%");
        }

        if($request->mempelai_laki){
            $records = $records->where('mempelai_laki', 'like', "%{$request->mempelai_laki}%");
        }

        if($request->tempat_nikah){
            $records = $records->where('tempat_nikah', 'like', "%{$request->tempat_nikah}%");
        }

        if($request->tanggal_nikah){
            $dates = explode("-", $request->tanggal_nikah);
            $records = $records->whereYear('created_at', $dates[0]);
            $records = $records->whereMonth('created_at', $dates[1]);
        }

        $pdf = Pdf::loadView('dispensasi_nikah.report', [
            'dispensasi_nikah' => $records->get()
        ]);
        return $pdf->stream('Laporan Daftar Dispensasi Nikah.pdf');
    }

    public function surveyReport(Request $request){
        $records = Survey::orderBy('tanggal', 'DESC');
        
        if($request->tanggal){
            $records = $records->where('tanggal', 'like', "%{$request->tanggal}%");
        }

        if($request->jenis_kelamin && $request->jenis_kelamin != "Semua"){
            $records = $records->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if($request->pendidikan && $request->pendidikan != "Semua"){
            $records = $records->where('pendidikan', $request->pendidikan);
        }

        for($i = 1 ; $i <= 9; $i++){
            if($request->get('u'.$i) && $request->get('u'.$i) != "Semua"){
                $records = $records->where('u'.$i, $request->get('u'.$i));
            }
        }

        $pdf = Pdf::loadView('survey.report', [
            'survey' => $records->get()
        ]);
        return $pdf->stream('Laporan Daftar Survey.pdf');
    }

    public function surveyEvaluation(Request $request){
        $records = Survey::query();
        
        if($request->tanggal){
            $records = $records->where('tanggal', 'like', "%{$request->tanggal}%");
        }

        $records = $records->get();
        $genderCount = [];
        $pendidikanCount = [];
        $evaluation = ["u1" => [],"u2" => [],"u3" => [],"u4" => [],"u5" => [],"u6" => [],"u7" => [],"u8" => [],"u9" => []];
        foreach($records as $record){
            if(isset($genderCount[$record->jenis_kelamin])){
                $genderCount[$record->jenis_kelamin]++;
            }else{
                $genderCount[$record->jenis_kelamin] = 1;
            }

            if(isset($pendidikanCount[$record->pendidikan])){
                $pendidikanCount[$record->pendidikan]++;
            }else{
                $pendidikanCount[$record->pendidikan] = 1;
            }

            for($i = 1; $i < 10; $i++){
                array_push($evaluation["u".$i], $record['u'.$i]);
            }
        }

        $score = 0;
        for($i = 1; $i < 10; $i++){
            $sum = Array_sum($evaluation["u".$i]);
            $mean = $sum/count($evaluation["u".$i]);
            $score = $score + ($mean * 0.111);
        }
        $finalScore = $score * 25;

        $mutu = "";
        if($finalScore >= 88.31){
            $mutu = "Sangat Baik";
        }else if($finalScore >= 76.61){
            $mutu = "Baik";
        }else if($finalScore >= 65){
            $mutu = "Kurang Baik";
        }else{
            $mutu = "Tidak Baik";
        }

        $data = [
            'ikm' => $finalScore,
            'keterangan_ikm' => $mutu,
            'jumlah' => count($records),
            'pendidikan' => $pendidikanCount,
            'jenis_kelamin' => $genderCount,
            'start_date' => $records->min('tanggal'),
            'end_date' => $records->max('tanggal'),
        ];

        $pdf = Pdf::loadView('survey.evaluation', [
            'data' => $data
        ]);
        
        return $pdf->stream('Laporan Daftar Pelayanan.pdf');
    }
}
