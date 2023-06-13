<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class DesaRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->role === "Admin" || Auth::user()->role === "Superadmin";
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            'alamat' => 'required',
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Mohon Masukkan Nama Desa Terlebih Dahulu!',
            'alamat.required' => 'Mohon Masukkan Alamat Desa Terlebih Dahulu!',
        ];
    }
}
