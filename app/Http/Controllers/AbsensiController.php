<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function index(){
        return view('absensi.index');
    }

    public function datatable(Request $request){
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

    public function print(Request $request){
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

    public function summary(Request $request){
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
}
