<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use App\Models\Layanan;
use App\Models\Pelayanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\PelayananRequest;

class PelayananController extends Controller
{
    public function index(){
        return view('pelayanan.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->get();
        $layanan = Layanan::orderBy('nama')->get();
        return view('pelayanan.create', compact('desa', 'layanan'));
    }

    public function store(PelayananRequest $request){
        try{
            Pelayanan::create([
                'date' => $request->tanggal,
                'layanan_id' => $request->layanan,
                'desa_id' => $request->desa,
                'nama' => $request->nama,
                'gender' => $request->gender,
            ]);
            return redirect(route('pelayanan.index'))->with('success', 'Sukses Menambahkan Catatan Pelayanan');
        }catch(Exception $e){
            return redirect(route('pelayanan.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        $desa = Desa::orderBy('nama_desa')->get();
        $layanan = Layanan::orderBy('nama')->get();
        return view('pelayanan.create',[
            'pelayanan' => Pelayanan::find($id),
            'desa' => $desa,
            'layanan' => $layanan,
        ]);
    }

    public function update(PelayananRequest $request, $id){
        try{
            Pelayanan::find($id)->update([
                'date' => $request->tanggal,
                'layanan_id' => $request->layanan,
                'desa_id' => $request->desa,
                'nama' => $request->nama,
                'gender' => $request->gender,
            ]);
            return redirect(route('pelayanan.index'))->with('success', 'Sukses Mengubah Catatan Pelayanan');
        }catch(Exception $e){
            return redirect(route('pelayanan.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Pelayanan::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Catatan Pelayanan'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Terjadi Kesalahan, Silahkan Coba Lagi!'
            ]);
        }
    }

    public function datatable(Request $request){
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
        $dateSearch = $request->columns[2]['search']['value'];
        if($dateSearch){
            $dates = explode("-", $dateSearch);
            $records = $records->whereYear('date', $dates[0]);
            $records = $records->whereMonth('date', $dates[1]);
        }

        $layananSearch = $request->columns[3]['search']['value'];
        if($layananSearch && $layananSearch != "Semua"){
            $records = $records->where('layanan_id', $layananSearch);
        }

        $desaSearch = $request->columns[4]['search']['value'];
        if($desaSearch && $desaSearch != "Semua"){
            $records = $records->where('desa_id', $desaSearch);
        }

        $namaSearch = $request->columns[5]['search']['value'];
        if($namaSearch){
            $records = $records->where('nama', 'like', "%{$namaSearch}%");
        }

        $genderSearch = $request->columns[6]['search']['value'];
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

    public function print(Request $request){
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
}
