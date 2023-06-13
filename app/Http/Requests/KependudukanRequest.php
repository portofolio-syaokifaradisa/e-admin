<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class KependudukanRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->role === "Admin" || Auth::user()->role === "Superadmin";
    }

    public function rules()
    {
        return [
            'tahun' => 'required|digits:4',
            'desa' => 'required',
            'luas_wilayah' => 'required|numeric',
            'jumlah_laki' => 'required|numeric',
            'jumlah_perempuan' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'tahun.required' => 'Mohon Masukkan Tahun Pencatatan!',
            'tahun.digits' => 'Mohon Masukkan tahun Pencatatan Sebanyak 4 Digit!',
            'desa.required' => 'Mohon Pilih Desa!',
            'luas_wilayah.required' => 'Mohon Masukkan Luas Wilayah!',
            'luas_wilayah.numeric' => 'Mohon Masukkan Luas Wilayah Berupa Angka!',
            'jumlah_laki.required' => 'Mohon Masukkan Jumlah Laki-laki!',
            'jumlah_laki.numeric' => 'Mohon Masukkan Jumlah Laki-laki Berupa Angka!',
            'jumlah_perempuan.required' => 'Mohon Masukkan Jumlah Perempuan!',
            'jumlah_perempuan.numeric' => 'Mohon Masukkan Jumlah Perempuan Berupa Angka!',
        ];
    }
}
