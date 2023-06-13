<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Superadmin',
            'jabatan' => 'Superadmin',
            'nip' => '123456789012345678',
            'pangkat' => 'Pembina',
            'golongan' => 'IV/a',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt("123"),
            'role' => 'Superadmin'
        ]);

        User::create([
            'nama' => 'Admin',
            'jabatan' => 'Admin',
            'nip' => '876543219876543211',
            'pangkat' => 'Pembina',
            'golongan' => 'IV/a',
            'email' => 'admin@gmail.com',
            'password' => bcrypt("123"),
            'role' => 'Admin'
        ]);

        foreach([1, 2] as $userId){
            for($i = 1; $i < ($userId == 1 ? 40 : 30); $i++){
                Absensi::create([
                    "tanggal" => date('Y-m-d', strtotime(date('Y-m-d'). " - $i days")),
                    'user_id' => $userId,
                    'status' => $i % 7 == 0 ? "Izin" : ($i % 10 == 0 ? "Dinas Luar" : "Hadir"),
                    'pagi' => $i % 7 == 0 ? "" : ($i % 10 == 0 ? "" : "08:00"),
                    'sore' => $i % 7 == 0 ? "" : ($i % 10 == 0 ? "" : "16:00"),
                ]);
            }
        }

        $genders = ["Laki-laki", 'Perempuan'];
        $pendidikan = ['SD','SMP','SMA','D1-D3-D4','S1','>S2'];
        foreach([2021, 2022, 2023] as $tahun){
            for($i = 0; $i < 250; $i++){
                $dateRandom = $tahun."-".rand(1,12)."-".rand(1,25);
                $surveyCount = Survey::where('tanggal', $dateRandom)->count();
                if($surveyCount == 0){
                    Survey::create([
                        'tanggal' => $dateRandom,
                        'jenis_kelamin' => $genders[rand(0,1)],
                        'pendidikan' => $pendidikan[rand(0,5)],
                        'u1' => rand(3,4),
                        'u2' => rand(3,4),
                        'u3' => rand(3,4),
                        'u4' => rand(3,4),
                        'u5' => rand(3,4),
                        'u6' => rand(3,4),
                        'u7' => rand(3,4),
                        'u8' => rand(3,4),
                        'u9' => rand(3,4),
                    ]);
                }
            }
        }
    }
}
