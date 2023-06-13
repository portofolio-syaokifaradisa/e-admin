<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\LayananRequest;

class LayananController extends Controller
{
    public function index(){
        return view('layanan.index');
    }

    public function create(){
        return view('layanan.create');
    }

    public function store(LayananRequest $request){
        try{
            Layanan::create(['nama' => $request->nama]);
            return redirect(route('service.index'))->with('success', 'Sukses Menambahkan Data Layanan');
        }catch(Exception $e){
            return redirect(route('service.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('layanan.create',[
            'layanan' => Layanan::find($id)
        ]);
    }

    public function update(LayananRequest $request, $id){
        try{
            Layanan::find($id)->update([
                'nama' => $request->nama
            ]);
            return redirect(route('service.index'))->with('success', 'Sukses Mengubah Data Layanan');
        }catch(Exception $e){
            return redirect(route('service.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Layanan::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Layanan'
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
        $records = Layanan::query();

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
        $layananSearch = $request->columns[2]['search']['value'];
        if($layananSearch){
            $records = $records->where('nama', 'like', "%{$layananSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Layanan::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "nama" => $record->nama,
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
        $records = Layanan::query();
        if($request->nama){
            $records = $records->where('nama', 'like', "%{$request->nama}%");
        }

        $pdf = Pdf::loadView('layanan.report', [
            'layanan' => $records->get()
        ]);
        return $pdf->stream('Laporan Daftar Layanan Desa.pdf');
    }

    public function json(){
        return response()->json(Layanan::orderBy('nama')->get());
    }
}
