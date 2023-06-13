<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\DesaRequest;

class DesaController extends Controller
{
    public function index(){
        return view('desa.index');
    }

    public function create(){
        return view('desa.create');
    }

    public function store(DesaRequest $request){
        try{
            Desa::create([
                'nama_desa' => $request->nama,
                'alamat' => $request->alamat,
            ]);
            return redirect(route('desa.index'))->with('success', 'Sukses Menambahkan Data Desa');
        }catch(Exception $e){
            return redirect(route('desa.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('desa.create',[
            'desa' => Desa::find($id)
        ]);
    }

    public function update(DesaRequest $request, $id){
        try{
            Desa::find($id)->update([
                'nama_desa' => $request->nama,
                'alamat' => $request->alamat,
            ]);
            return redirect(route('desa.index'))->with('success', 'Sukses Mengubah Data Desa');
        }catch(Exception $e){
            return redirect(route('desa.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Desa::find($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Desa'
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
        $records = Desa::query();

        /* ================== [2] Sorting Kolom ================== */
        $sortColumnIndex = $request->order[0]['column'];
        $sortColumnName = $request->columns[$sortColumnIndex]['data'];
        $sortType = $request->order[0]['dir'];
        if($sortColumnName === "no"){
            $records = $records->orderBy('nama_desa', 'ASC');
        }else{
            $records = $records->orderBy($sortColumnName, $sortType);
        }

        /* ================== [3] Individual Search ================== */
        $desaSearch = $request->columns[2]['search']['value'];
        if($desaSearch){
            $records = $records->where('nama_desa', 'like', "%{$desaSearch}%");
        }

        $alamatSearch = $request->columns[3]['search']['value'];
        if($alamatSearch){
            $records = $records->where('alamat', 'like', "%{$alamatSearch}%");
        }

        /* ================== [4] Pengambilan Data ================== */
        $totalRecordswithFilter = $records->count();
        $totalRecord = Desa::count();
        $records = $records->skip($startNumber)->take($rowperpage)->get();

        /* ================== [7] Memformat Data ================== */
        $data_arr = array();
        foreach($records as $index => $record){
            $data_arr[] = array(
                "id" => $record->id,
                "no" => $startNumber + $index + 1,
                "desa" => $record->nama_desa,
                "alamat" => $record->alamat,
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
        $records = Desa::query();

        if($request->nama){
            $records = $records->where('nama_desa', 'like', "%{$request->nama}%");
        }

        if($request->alamat){
            $records = $records->where('alamat', 'like', "%{$request->alamat}%");
        }

        $pdf = Pdf::loadView('desa.report', [
            'desa' => $records->get()
        ]);
        return $pdf->stream('Laporan Daftar Desa.pdf');
    }

    public function json(){
        return response()->json(Desa::orderBy('nama_desa')->get());
    }
}
