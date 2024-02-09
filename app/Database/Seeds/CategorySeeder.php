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
            ],
            [
                'category_name'  => 'Art & Music',
            ],
            [
                'category_name'  => 'Horror',
            ],
            [
                'category_name'  => 'Business',
            ],
            [
                'category_name'  => 'Comics',
            ],
            [
                'category_name'  => 'History',
            ],
        ];
        $this->db->table('categories')->insertBatch($data);
    }
}
