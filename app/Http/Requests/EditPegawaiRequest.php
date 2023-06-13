<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class EditPegawaiRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->role === "Superadmin";
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            'nip' => "nullable|unique:users,nip,$this->id,id|digits:18",
            'role' => 'required',
            'email' => "required|email|unique:users,email,$this->id,id",
            'password' => 'nullable',
            'confirmation_password' => 'required_with:password|same:password'
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Mohon Masukkan Nama Terlebih Dahulu!',
            'nip.unique' => 'NIP Sudah Terdaftar!',
            'nip.digits' => 'NIP Mempunyai 18 Digit, Silahkan Cek Kembali!',
            'email.required' => 'Mohon Masukkan Email Terlebih Dahulu!',
            'email.email' => 'Mohon Masukkan Format Email yang Valid!',
            'email.unique' => 'Email Sudah Terdaftar!',
            'confirmation_password.required_with' => 'Mohon Masukkan Konfirmasi Password Terlebih Dahulu!',
            'confirmation_password.same' => 'Konfirmasi Password Tidak Sama Dengan Password!',
            'role.required' => 'Mohon Pilih Role Akun Terlebih Dahulu!'
        ];
    }
}
