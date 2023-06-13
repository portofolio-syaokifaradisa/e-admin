<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class DispensasiNikahRequest extends FormRequest
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
            'mempelai_laki' => 'required',
            'tempat_lahir_laki' => 'required',
            'tanggal_lahir_laki' => 'required',
            'agama_laki' => 'required',
            'pekerjaan_laki' => 'required',
            'alamat_laki' => 'required',
            'mempelai_perempuan' => 'required',
            'tempat_lahir_perempuan' => 'required',
            'tanggal_lahir_perempuan' => 'required',
            'agama_perempuan' => 'required',
            'pekerjaan_perempuan' => 'required',
            'alamat_perempuan' => 'required',
            'tempat_nikah' => 'required',
            'tanggal_nikah' => 'required'
        ];
    }

    public function messages(){
        return [
            'tahun.required' => 'Mohon Masukkan Tahun Pencatatan!',
            'tahun.digits' => 'Mohon Masukkan tahun Pencatatan Sebanyak 4 Digit!',
            'desa.required' => 'Mohon Pilih Asal Desa Peminta Dispensasi Nikah!',

            'mempelai_laki.required' => 'Mohon Isikan Nama Lengkap Mempelai Laki-laki!',
            'tempat_lahir_laki.required' => 'Mohon Isikan Tempat lahir Mempelai Laki-laki!',
            'tanggal_lahir_laki.required' => 'Mohon Pilih Tanggal Lahir Mempelai Laki-laki!',
            'agama_laki.required' => 'Mohon Pilih Agama Mempelai Laki-laki!',
            'pekerjaan_laki.required' => 'Mohon Isikan Pekerjaan Mempelai Laki-laki!',
            'alamat_laki.required' => 'Mohon Isikan Alamat Mempelai Laki-laki!',

            'mempelai_perempuan.required' => 'Mohon Isikan Nama Lengkap Mempelai Perempuan!',
            'mempelai_perempuan.required' => 'Mohon Isikan Nama Lengkap Mempelai Perempuan!',
            'tempat_lahir_perempuan.required' => 'Mohon Isikan Tempat lahir Mempelai Perempuan!',
            'tanggal_lahir_perempuan.required' => 'Mohon Pilih Tanggal Lahir Mempelai Perempuan!',
            'agama_perempuan.required' => 'Mohon Pilih Agama Mempelai Perempuan!',
            'pekerjaan_perempuan.required' => 'Mohon Isikan Pekerjaan Mempelai Perempuan!',
            'alamat_perempuan.required' => 'Mohon Isikan Alamat Mempelai Perempuan!',

            'tempat_nikah.required' => 'Mohon Isikan Tempat Nikah!',
            'tanggal_nikah.required' => 'Mohon Pilih Tanggal Nikah!'
        ];
    }
}
