<?php

use App\Models\Desa;
use App\Models\Layanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelayanansTable extends Migration
{
    public function up()
    {
        Schema::create('pelayanans', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignIdFor(Desa::class)->constrained();
            $table->foreignIdFor(Layanan::class)->constrained();
            $table->string('nama');
            $table->enum('gender', [
                'Laki-laki',
                'Perempuan'
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelayanans');
    }
}
