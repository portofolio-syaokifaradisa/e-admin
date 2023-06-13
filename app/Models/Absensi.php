<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'pagi',
        'sore',
        'tanggal',
        'status',
        'keterangan'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
