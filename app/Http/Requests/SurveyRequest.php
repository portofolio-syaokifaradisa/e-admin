<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->role === "Admin" || Auth::user()->role === "Superadmin";
    }

    public function rules()
    {
        return [
            'tanggal' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan' => 'required',
            'u1' => 'required',
            'u2' => 'required',
            'u3' => 'required',
            'u4' => 'required',
            'u5' => 'required',
            'u6' => 'required',
            'u7' => 'required',
            'u8' => 'required',
            'u9' => 'required',
        ];
    }

    public function messages(){
        return [
            'tanggal.required' => 'Mohon Isikan tanggal Survey Terlebih Dahulu!',
            'jenis_kelamin.required' => 'Mohon Pilih Jenis Kelamin Terlebih Dahulu!',
            'pendidikan.required' => 'Mohon Pilih Pendidikan Terlebih Dahulu!',
            'u1.required' => 'Mohon Pilih Penilaian U1 Terlebih Dahulu!',
            'u2.required' => 'Mohon Pilih Penilaian U2 Terlebih Dahulu!',
            'u3.required' => 'Mohon Pilih Penilaian U3 Terlebih Dahulu!',
            'u4.required' => 'Mohon Pilih Penilaian U4 Terlebih Dahulu!',
            'u5.required' => 'Mohon Pilih Penilaian U5 Terlebih Dahulu!',
            'u6.required' => 'Mohon Pilih Penilaian U6 Terlebih Dahulu!',
            'u7.required' => 'Mohon Pilih Penilaian U7 Terlebih Dahulu!',
            'u8.required' => 'Mohon Pilih Penilaian U8 Terlebih Dahulu!',
            'u9.required' => 'Mohon Pilih Penilaian U9 Terlebih Dahulu!',
        ];
    }
}
