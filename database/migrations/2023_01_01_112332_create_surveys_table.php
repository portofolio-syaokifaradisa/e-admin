<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis_kelamin', [
                'Laki-laki',
                'Perempuan'
            ]);
            $table->enum('pendidikan', [
                'SD',
                'SMP',
                'SMA',
                'D1-D3-D4',
                'S1',
                '>S2'
            ]);
            $table->enum('u1', [1, 2, 3, 4]);
            $table->enum('u2', [1, 2, 3, 4]);
            $table->enum('u3', [1, 2, 3, 4]);
            $table->enum('u4', [1, 2, 3, 4]);
            $table->enum('u5', [1, 2, 3, 4]);
            $table->enum('u6', [1, 2, 3, 4]);
            $table->enum('u7', [1, 2, 3, 4]);
            $table->enum('u8', [1, 2, 3, 4]);
            $table->enum('u9', [1, 2, 3, 4]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
