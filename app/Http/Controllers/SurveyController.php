<?php

namespace App\Http\Controllers;

use App\Charts\SurveyChart;
use Exception;
use App\Models\Survey;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\SurveyRequest;

class SurveyController extends Controller
{
    public function index(){
        return view('survey.index');
    }

    public function create(){
        return view('survey.create');
    }

    public function store(SurveyRequest $request){
        try{
            Survey::create([
                'tanggal' => $request->tanggal,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan' => $request->pendidikan,
                'u1' => $request->u1,
                'u2' => $request->u2,
                'u3' => $request->u3,
                'u4' => $request->u4,
                'u5' => $request->u5,
                'u6' => $request->u6,
                'u7' => $request->u7,
                'u8' => $request->u8,
                'u9' => $request->u9,
            ]);
            return redirect(route('survey.index'))->with('success', 'Sukses Menambahkan Catatan Survey');
        }catch(Exception $e){
            return redirect(route('survey.create'))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        return view('survey.create',[
            'survey' => Survey::find($id)
        ]);
    }

    public function update(SurveyRequest $request, $id){
        try{
            Survey::find($id)->update([
                'tanggal' => $request->tanggal,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan' => $request->pendidikan,
                'u1' => $request->u1,
                'u2' => $request->u2,
                'u3' => $request->u3,
                'u4' => $request->u4,
                'u5' => $request->u5,
                'u6' => $request->u6,
                'u7' => $request->u7,
                'u8' => $request->u8,
                'u9' => $request->u9,
            ]);
            return redirect(route('survey.index'))->with('success', 'Sukses Mengubah Catatan Survey');
        }catch(Exception $e){
            return redirect(route('survey.edit', ['id' => $id]))->with('error', 'terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            Survey::find ($id)->delete();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Catatan Survey'
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
        $tanggalSearch = $request->columns[2]['search']['value'];
        if($tanggalSearch){
            $records = $records->where('tanggal', 'like', "%{$tanggalSearch}%");
        }

        $genderSearch = $request->columns[3]['search']['value'];
        if($genderSearch && $genderSearch != "Semua"){
            $records = $records->where('jenis_kelamin', $genderSearch);
        }

        $pendidikanSearch = $request->columns[4]['search']['value'];
        if($pendidikanSearch && $pendidikanSearch != "Semua"){
            $records = $records->where('pendidikan', $pendidikanSearch);
        }

        for($i = 5 ; $i <= 13; $i++){
            if($request->columns[$i]['search']['value'] && $request->columns[$i]['search']['value'] != "Semua"){
                $records = $records->where('u'.($i - 4), $request->columns[$i]['search']['value']);
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

    public function print(Request $request){
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

    public function evaluation(Request $request){
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

    public function chart(SurveyChart $chart){
        return view('survey.chart', [
            'chart' => $chart->build()
        ]);
    }
}
