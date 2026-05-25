<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Utama',      'email' => 'admin@seft.com',         'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'Budi Manajer',     'email' => 'manajer@seft.com',       'password' => Hash::make('password'), 'role' => 'manajer'],
            ['name' => 'Andi Gudang',      'email' => 'gudang@seft.com',        'password' => Hash::make('password'), 'role' => 'petugas_gudang'],
            ['name' => 'PT Supplier Jaya', 'email' => 'supplier@seft.com',      'password' => Hash::make('password'), 'role' => 'supplier'],
            ['name' => 'Rini QC',          'email' => 'qc@seft.com',            'password' => Hash::make('password'), 'role' => 'petugas_qc'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}