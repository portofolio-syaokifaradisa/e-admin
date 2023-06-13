<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PelayananRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tanggal' => 'required',
            'layanan' => 'required',
            'nama' => 'required',
            'gender' => 'required',
            'desa' => 'required'
        ];
    }

    public function messages(){
        return [
            'tanggal.required' => 'Mohon Pilih Tanggal Pelayanan!',
            'layanan.required' => 'Mohon Pilih Layanan!',
            'nama.required' => 'Mohon Masukkan Nama Lengkap Peminta Layanan!',
            'gender.required' => 'Mohon Pilih Jenis Kelamin!',
            'desa.required' => 'Mohon Pilih Desa Asal Peminta Layanan!'
        ];
    }
}
