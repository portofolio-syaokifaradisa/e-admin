<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'date',
        'desa_id',
        'layanan_id',
        'nama',
        'gender'
    ];

    public function desa(){
        return $this->belongsTo(Desa::class);
    }

    public function layanan(){
        return $this->belongsTo(Layanan::class);
    }
}
