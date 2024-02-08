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
                'password'  =>  password_hash("123", PASSWORD_DEFAULT),
                'address' => 'Jaksel',
                'role'  => 'admin',
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
