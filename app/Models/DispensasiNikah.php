<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispensasiNikah extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable= [
        'tahun',
        'desa_id',

        'mempelai_perempuan',
        'tempat_lahir_perempuan',
        'tanggal_lahir_perempuan',
        'agama_perempuan',
        'pekerjaan_perempuan',
        'alamat_perempuan',

        'mempelai_laki',
        'tempat_lahir_laki',
        'tanggal_lahir_laki',
        'agama_laki',
        'pekerjaan_laki',
        'alamat_laki',
        
        'tempat_nikah',
        'tanggal_nikah'
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}