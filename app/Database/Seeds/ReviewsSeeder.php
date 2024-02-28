<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id'  => 2,
                'book_id'  =>  1,
                'review'  =>  "Bagus Banget",
                'rating' => 5,
                'deleted_at' => null,
            ],
            [
                'user_id'  => 1,
                'book_id'  =>  1,
                'review'  =>  "Lumayan",
                'rating' => 3,
                'deleted_at' => null,
            ],
        ];
        $this->db->table('reviews')->insertBatch($data);
    }
}
