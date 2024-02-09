<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_name'  => 'Administrator',
                'email'  =>  "admin@gmail.com",
                'password'  =>  password_hash("admin", PASSWORD_DEFAULT),
                'address' => 'Jaksel',
                'role'  => 'admin',
            ],
            [
                'user_name'  => 'Petugas',
                'email'  =>  "petugas@gmail.com",
                'password'  =>  password_hash("petugas", PASSWORD_DEFAULT),
                'address' => 'Malang',
                'role'  => 'petugas',
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
