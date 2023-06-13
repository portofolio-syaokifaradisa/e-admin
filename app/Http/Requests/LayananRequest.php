<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class LayananRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->role === "Admin" || Auth::user()->role === "Superadmin";
    }

    public function rules()
    {
        return [
            'nama' => 'required'
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Mohon Masukkan Nama Layanan Terlebih Dahulu!'
        ];
    }
}
