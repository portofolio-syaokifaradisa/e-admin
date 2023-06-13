<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nama_desa',
        'alamat'
    ];
}
