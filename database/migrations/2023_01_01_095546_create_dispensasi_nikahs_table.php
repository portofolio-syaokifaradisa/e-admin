<?php

use App\Models\Desa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispensasiNikahsTable extends Migration
{
    public function up()
    {
        Schema::create('dispensasi_nikahs', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->foreignIdFor(Desa::class)->constrained();
            $table->string('mempelai_perempuan');
            $table->string('tempat_lahir_perempuan');
            $table->string('tanggal_lahir_perempuan');
            $table->enum('agama_perempuan', [
                'Islam',
                'Katolik',
                'Protestan',
                'Hindu',
                'Budha',
                'Konghucu'
            ]);
            $table->string('pekerjaan_perempuan');
            $table->text('alamat_perempuan');
            $table->string('mempelai_laki');
            $table->string('tempat_lahir_laki');
            $table->string('tanggal_lahir_laki');
            $table->enum('agama_laki', [
                'Islam',
                'Katolik',
                'Protestan',
                'Hindu',
                'Budha',
                'Konghucu'
            ]);
            $table->string('pekerjaan_laki');
            $table->text('alamat_laki');
            $table->string('tempat_nikah');
            $table->date('tanggal_nikah');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dispensasi_nikahs');
    }
}
