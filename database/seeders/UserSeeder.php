<?php
// database/seeders/User Seeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Umum',
            'email' => 'umum@example.com',
            'password' => Hash::make('password'),
            'role' => 'umum',
        ]);
    }
}