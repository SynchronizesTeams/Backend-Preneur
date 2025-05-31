<?php

namespace Database\Seeders;

use App\Models\StudentProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudentProfile::insert([
            'siswa_id' => uniqid("siswa_"),
            'nama' => "Adly Fahreza",
            'nis' => 232410003
        ]);

        StudentProfile::insert([
            'siswa_id' => uniqid("siswa_"),
            'nama' => "Gheraldy Moses Tarigan",
            'nis' => 232410024
        ]);
    }
}
