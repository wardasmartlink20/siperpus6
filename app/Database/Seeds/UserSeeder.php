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
                'deleted_at' => null,
            ],
            [
                'user_name'  => 'Petugas',
                'email'  =>  "petugas@gmail.com",
                'password'  =>  password_hash("petugas", PASSWORD_DEFAULT),
                'address' => 'Malang',
                'role'  => 'petugas',
                'deleted_at' => null,
            ],
            [
                'user_name'  => 'warda',
                'email'  =>  "warda@gmail.com",
                'password'  =>  password_hash("123456", PASSWORD_DEFAULT),
                'address' => 'Malang',
                'role'  => 'user',
                'deleted_at' => null,
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
