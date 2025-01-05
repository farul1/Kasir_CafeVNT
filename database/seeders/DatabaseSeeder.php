<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'adminVNT',
            'username' => 'adminVNT',
            'role' => 'Admin',
            'password' => bcrypt('admin123')
        ]);

        User::create([
            'nama' => 'Syafarul Priwantoro',
            'username' => 'Farul',
            'role' => 'Admin',
            'password' => bcrypt('farul123')
        ]);

        User::create([
            'nama' => 'Shafira Daffa',
            'username' => 'Shafira',
            'role' => 'Manager',
            'password' => bcrypt('fira123')
        ]);

        User::create([
            'nama' => 'Angelica',
            'username' => 'angelica',
            'role' => 'Cashier',
            'password' => bcrypt('angelica123')
        ]);

        User::create([
            'nama' => 'Karyawan 1',
            'username' => 'karyawan1',
            'role' => 'Cashier',
            'password' => bcrypt('karyawan123')
        ]);
    }
}
