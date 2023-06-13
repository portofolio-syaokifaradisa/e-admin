<?php

use App\Models\Desa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKependudukansTable extends Migration
{
    public function up()
    {
        Schema::create('kependudukans', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->foreignIdFor(Desa::class)->constrained();
            $table->double('luas_wilayah');
            $table->integer('total_laki');
            $table->integer('total_perempuan');
            $table->integer('total_kk');
            $table->integer('total_warga');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kependudukans');
    }
}
