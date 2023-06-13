<?php

namespace App\Http\Controllers;

use Exception;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\DispensasiNikah;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf;
use App\Http\Requests\DispensasiNikahRequest;
use PhpOffice\PhpWord\IOFactory;

class DispensasiNikahController extends Controller
{
    public function index(){
        return view('dispensasi_nikah.index');
    }

    public function create(){
        $desa = Desa::orderBy('nama_desa')->get();
        return view('dispensasi_nikah.create', compact('desa'));
    }

    public function store(DispensasiNikahRequest $request){
        try{
            DispensasiNikah::create([
                'tahun' => $request->tahun,
                'desa_id' => $request->desa,
                'mempelai_laki' => $request->mempelai_laki,
                'tempat_lahir_laki' => $request->tempat_lahir_laki,
                'tanggal_lahir_laki' => $request->tanggal_lahir_laki,
                'agama_laki' => $request->agama_laki,
                'pekerjaan_laki' => $request->pekerjaan_laki,
                'alamat_laki' => $request->alamat_laki,
                'mempelai_perempuan' => $request->mempelai_perempuan,
                'tempat_lahir_perempuan' => $request->tempat_lahir_perempuan,
                'tanggal_lahir_perempuan' => $request->tanggal_lahir_perempuan,
                'agama_perempuan' => $request->agama_perempuan,
                'pekerjaan_perempuan' => $request->pekerjaan_perempuan,
                'alamat_perempuan' => $request->alamat_perempuan,
                'tempat_nikah' => $request->tempat_nikah,
                'tanggal_nikah' => $request->tanggal_nikah
            ]);
            return redirect(route('dispensasi_nikah.index'))->with('success', 'Sukses Menambahkan Catatan Dispensasi Nikah');
        }catch(Exception $e){
            return redirect(route('dispensasi_nikah.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        $desa = Desa::orderBy('nama_desa')->get();
        return view('dispensasi_nikah.create',[
            'dispensasi_nikah' => DispensasiNikah::find($id),
            'desa' => $desa,
        ]);
    }

    public function update(DispensasiNikahRequest $request, $id){
        try{
            DispensasiNikah::find($id)->update([
                'tahun' => $request->tahun,
                'desa_id' => $request->desa,
                'mempelai_laki' => $request->mempelai_laki,
                'mempelai_perempuan' => $request->mempelai_perempuan,
                'tempat_nikah' => $request->tempat_nikah,
                'tanggal_nikah' => $request->tanggal_nikah
            ]);
            return redirect(route('dispensasi_nikah.index'))->with('success', 'Sukses Mengubah Catatan Dispensasi Nikah');
        }catch(Exception $e){
            return redirect(route('dispensasi_nikah.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            DispensasiNikah::find ($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Catatan Dispensasi Nikah'
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
        $tahunSearch = $request->columns[2]['search']['value'];
        if($tahunSearch){
            $records = $records->where('tahun', 'like', "%{$tahunSearch}%");
        }

        $desaSearch = $request->columns[3]['search']['value'];
        if($desaSearch && $desaSearch != "Semua"){
            $records = $records->where('desa_id', $desaSearch);
        }

        $mempelaiPerempuanSearch = $request->columns[4]['search']['value'];
        if($mempelaiPerempuanSearch){
            $records = $records->where('mempelai_perempuan', 'like', "%{$mempelaiPerempuanSearch}%");
        }

        $memperlaiLakiSearch = $request->columns[5]['search']['value'];
        if($memperlaiLakiSearch){
            $records = $records->where('mempelai_laki', 'like', "%{$memperlaiLakiSearch}%");
        }

        $tempatNikahSearch = $request->columns[6]['search']['value'];
        if($tempatNikahSearch){
            $records = $records->where('tempat_nikah', 'like', "%{$tempatNikahSearch}%");
        }

        $tanggalNikahSearch = $request->columns[7]['search']['value'];
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

    public function print(Request $request){
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

    public function rekomendasi($id){
        $data = DispensasiNikah::find($id);
        $pdf = Pdf::loadView('dispensasi_nikah.surat', [
            'tanggal_sekarang' => $this->toIndonesianDateFormat(date('Y-m-d')),
            'nama_laki' => $data->mempelai_laki,
            'nama_perempuan' => $data->mempelai_perempuan,
            'agama_laki' => $data->agama_laki,
            'agama_perempuan' => $data->agama_perempuan,
            'pekerjaan_laki' => $data->pekerjaan_laki,
            'pekerjaan_perempuan' => $data->pekerjaan_perempuan,
            'alamat_laki' => $data->alamat_laki,
            'alamat_perempuan' => $data->alamat_perempuan,
            'tempat_lahir_laki' => $data->tempat_lahir_laki,
            'tempat_lahir_perempuan' => $data->tempat_lahir_perempuan,
            'tanggal_lahir_laki' => $this->toIndonesianDateFormat($data->tanggal_lahir_laki),
            'tanggal_lahir_perempuan' => $this->toIndonesianDateFormat($data->tanggal_lahir_perempuan),
            'tempat_nikah' => $data->tempat_nikah,
            'tanggal_nikah' => $this->toIndonesianDateFormat($data->tanggal_nikah),
            'hari_nikah' => $this->toIndonesianDay(date('w', strtotime($data->tanggal_nikah))),
        ]);

        return $pdf->stream("Dispensasi Nikah.pdf");
    }

    private function toIndonesianDateFormat($date){
        if(count(explode(' ', $date)) > 1){
            $date = explode(' ', $date)[0];
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $dates = explode('-', $date);
        if(strlen($dates[0]) == 4){
            return $dates[2]. ' ' . $months[(int) $dates[1]] . ' ' . $dates[0];
        }else{
            return $dates[0]. ' ' . $months[(int) $dates[1]] . ' ' . $dates[2];
        }
    }

    private function toIndonesianDay($week){
        foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $index => $day){
            if(($index + 1) == $week){
                return $day;
            }
        }
    }
}
