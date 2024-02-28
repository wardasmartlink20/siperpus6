<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_name'  => 'Romance',
                'deleted_at' => null,
            ],
            [
                'category_name'  => 'Art & Music',
                'deleted_at' => null,
            ],
            [
                'category_name'  => 'Horror',
                'deleted_at' => null,
            ],
            [
                'category_name'  => 'Business',
                'deleted_at' => null,
            ],
            [
                'category_name'  => 'Comics',
                'deleted_at' => null,
            ],
            [
                'category_name'  => 'History',
                'deleted_at' => null,
            ],
        ];
        $this->db->table('categories')->insertBatch($data);
    }
}
