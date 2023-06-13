<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kependudukan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'tahun',
        'desa_id',
        'luas_wilayah',
        'total_laki',
        'total_perempuan',
        'total_kk',
        'total_warga',
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }
}
