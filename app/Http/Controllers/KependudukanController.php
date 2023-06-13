<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Desa;
use App\Models\Kependudukan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\KependudukanRequest;

class KependudukanController extends Controller
{
    public function index(){
        return view('kependudukan.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->get();
        return view('kependudukan.create', compact('desa'));
    }

    public function store(KependudukanRequest $request){
        try{
            Kependudukan::create([
                'tahun' => $request->tahun,
                'desa_id' => $request->desa,
                'luas_wilayah' => $request->luas_wilayah,
                'total_laki' => $request->jumlah_laki,
                'total_perempuan' => $request->jumlah_perempuan,
                'total_kk' => $request->jumlah_kk,
                'total_warga' => $request->jumlah_warga
            ]);
            return redirect(route('kependudukan.index'))->with('success', 'Sukses Menambahkan Catatan kependudukan');
        }catch(Exception $e){
            return redirect(route('kependudukan.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('kependudukan.create',[
            'kependudukan' => Kependudukan::find($id),
            'desa' => Desa::all()
        ]);
    }

    public function update(KependudukanRequest $request, $id){
        try{
            Kependudukan::find($id)->update([
                'tahun' => $request->tahun,
                'desa_id' => $request->desa,
                'luas_wilayah' => $request->luas_wilayah,
                'total_laki' => $request->jumlah_laki,
                'total_perempuan' => $request->jumlah_perempuan,
                'total_kk' => $request->jumlah_kk,
                'total_warga' => $request->jumlah_warga
            ]);
            return redirect(route('kependudukan.index'))->with('success', 'Sukses Mengubah Catatan Kependudukan');
        }catch(Exception $e){
            return redirect(route('kependudukan.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }
 
    public function delete($id){
        try{
            Kependudukan::find ($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Catatan Kependudukan'
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
        $tahunSearch = $request->columns[2]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }
        
        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch && $desaSearch != "Semua"){
            $records = $records->where('desa_id', $desaSearch);
        }

        $luasWilayahSearch = $request->columns[4]['search']['value'];
        if($luasWilayahSearch){
            $records = $records->where('luas_wilayah', 'like', "%{$luasWilayahSearch}%");
        }

        $jumlahLakiSearch = $request->columns[5]['search']['value'];
        if($jumlahLakiSearch){
            $records = $records->where('total_laki', 'like', "%{$jumlahLakiSearch}%");
        }

        $jumlahPerempuanSearch = $request->columns[6]['search']['value'];
        if($jumlahPerempuanSearch){
            $records = $records->where('total_perempuan', 'like', "%{$jumlahPerempuanSearch}%");
        }

        $jumlahKKSearch = $request->columns[7]['search']['value'];
        if($jumlahKKSearch){
            $records = $records->where('total_kk', 'like', "%{$jumlahKKSearch}%");
        }

        $jumlahWargaSearch = $request->columns[8]['search']['value'];
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

    public function print(Request $request){
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
}
