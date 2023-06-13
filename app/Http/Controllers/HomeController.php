<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $absensi = Absensi::where('user_id', Auth::user()->id)->where('tanggal', date('Y-m-d'))->first();
        return view('home.index', compact('absensi'));
    }

    public function absenPagi(){
        try{
            Absensi::create([
                'user_id' => Auth::user()->id,
                'pagi' => date("H:i"),
                'tanggal' => date('Y-m-d'),
                'status' => 'Hadir'
            ]);
            return redirect(route('home'))->with('success', 'Absen Pagi Sukses');
        }catch(Exception $e){
            return redirect(route('home'))->with('error', 'Terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function absenSore(){
        try{
            Absensi::where('tanggal', date('Y-m-d'))->where('user_id', Auth::user()->id)->update([
                'sore' => date("H:i"),
            ]);
            return redirect(route('home'))->with('success', 'Absen Sore Sukses');
        }catch(Exception $e){
            return redirect(route('home'))->with('error', 'Terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function keterangan($type){
        return view('home.keterangan', compact('type'));
    }

    public function store(Request $request, $type){
        try{
            $date = $request->mulai;
            while($date <= $request->selesai){
                Absensi::create([
                    'user_id' => Auth::user()->id,
                    'tanggal' => $date,
                    'status' => $type,
                    'keterangan' => $request->keterangan,
                ]);
                
                $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            }

            return redirect(route('home'))->with('success', "Absen $type Sukses");
        }catch(Exception $e){
            return redirect(route('home'))->with('error', 'Terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function datatable(Request $request){
        /* ================== [1] Persiapan Pengambilan Data ================== */
        $startNumber = $request->start;
        $rowperpage = $request->length;
        $records = Absensi::where('user_id', Auth::user()->id);

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

        $pagiSearch = $request->columns[2]['search']['value'];
        if($pagiSearch){
            $records = $records->where('pagi', $pagiSearch);
        }

        $soreSearch = $request->columns[3]['search']['value'];
        if($soreSearch){
            $records = $records->where('sore', $soreSearch);
        }

        $statusSearch = $request->columns[4]['search']['value'];
        if($statusSearch){
            $records = $records->where('status', $statusSearch);
        }

        $keteranganSearch = $request->columns[5]['search']['value'];
        if($keteranganSearch){
            $records = $records->where('keterangan', 'like', "%{$keteranganSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Absensi::where('user_id', Auth::user()->id)->count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "tanggal" => $record->tanggal,
                "masuk" => $record->pagi ?? '-',
                'keluar' => $record->sore ?? '-',
                'status' => $record->status,
                "keterangan" => $record->keterangan,
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
        $records = Absensi::where('user_id', Auth::user()->id)->orderBy('tanggal', 'DESC');

        if($request->tanggal){
            $dates = explode("-", $request->tanggal);
            $records = $records->whereYear('tanggal', $dates[0]);
            $records = $records->whereMonth('tanggal', $dates[1]);
        }

        if($request->masuk){
            $records = $records->where('pagi', $request->masuk);
        }

        if($request->sore){
            $records = $records->where('sore', $request->sore);
        }

        if($request->status && $request->status != "SEMUA"){
            $records = $records->where('status', $request->status);
        }

        if($request->keterangan){
            $records = $records->where('keterangan', 'like', "%{$request->keterangan}%");
        }

        $pdf = Pdf::loadView('absensi.report', [
            'absensi' => $records->get(),
            'title' => "Laporan Absensi ". Auth::user()->nama,
            'is_private' => true,
        ]);
        return $pdf->stream("Laporan Absensi ". Auth::user()->nama .".pdf");
    }
}
