<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $currentYear = now()->year;
        $semesters = [];

        for ($i = $currentYear; $i >= 2020; $i--) {
            $semesters[] = ['nama' => "$i Ganjil"];
            $semesters[] = ['nama' => "$i Genap"];
        }

        DB::table('semesters')->insert($semesters);
    }
}

