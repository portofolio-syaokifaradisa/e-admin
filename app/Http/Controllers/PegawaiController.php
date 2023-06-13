<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PegawaiRequest;
use App\Http\Requests\EditPegawaiRequest;
use App\Models\Absensi;

class PegawaiController extends Controller
{
    public function index(){
        return view('pegawai.index');
    }

    public function create(){
        return view('pegawai.create');
    }

    public function store(PegawaiRequest $request){
        try{
            $user = User::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'golongan' => $request->golongan,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);

            if($request->file('foto')){
                $file = $request->file('foto');
                $fileName = $user->id.'.png';     
                $file->move(public_path("display_picture"), $fileName);
            }

            return redirect(route('pegawai.index'))->with('success', 'Penambahan Data Pegawai Berhasil');
        }catch(Exception $e){
            return redirect(route('pegawai.create'))->with('error', 'Terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function edit($id){
        $user = User::find($id);
        return view('pegawai.create', compact('user'));
    }

    public function update(EditPegawaiRequest $request, $id){
        try{
            DB::beginTransaction();

            User::find($id)->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'jabatan' => $request->jabatan,
                'pangkat' => $request->pangkat,
                'golongan' => $request->golongan,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            if($request->password){
                User::find($id)->update([
                    'password' => bcrypt($request->password)
                ]);
            }

            if($request->file('foto')){
                $file = $request->file('foto');
                $fileName = $id.'.png';     
                $file->move(public_path("display_picture"), $fileName);
            }

            DB::commit();
            return redirect(route('pegawai.index'))->with('success', 'Perubahan Data Pegawai Berhasil');
        }catch(Exception $e){
            DB::rollBack();
            return redirect(route('pegawai.edit', ['id' => $id]))->with('error', 'Terjadi Kesalahan, Silahkan Coba Lagi!');
        }
    }

    public function delete($id){
        try{
            DB::beginTransaction();
            Absensi::where('user_id', $id)->delete();
            User::find($id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'title' => 'Sukses',
                'message' => 'Sukses Menghapus Akun'
            ]);
        }catch(Exception $e){
            DB::rollBack();
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
        $nama_nip_search = $request->columns[3]['search']['value'];
        if($nama_nip_search){
            $records = $records->where('nama', 'like', "%{$nama_nip_search}%");
            $records = $records->orwhere('nip', 'like', "%{$nama_nip_search}%");
            $records = $records->orwhere('email', 'like', "%{$nama_nip_search}%");
        }

        $jabatanSearch = $request->columns[4]['search']['value'];
        if($jabatanSearch){
            $records = $records->where('jabatan', 'like', "%{$jabatanSearch}%");
        }

        $pangkatSearch = $request->columns[5]['search']['value'];
        if($pangkatSearch){
            $records = $records->where('pangkat', 'like', "%{$pangkatSearch}%");
        }

        $golonganSearch = $request->columns[6]['search']['value'];
        if($golonganSearch){
            $records = $records->where('golongan', 'like', "%{$golonganSearch}%");
        }

        $roleSearch = $request->columns[7]['search']['value'];
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

    public function print(Request $request){
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
}
