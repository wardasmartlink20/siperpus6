<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 2,
                'book_id'  => 2,
                'loan_date'  =>  "2024-02-05 00:00:00",
                'due_date'  =>  "2024-02-07 00:00:00",
                'status' => 'process_borrowing',
                'updated_at'  => '2024-02-07 00:00:00',
                'deleted_at' => null,
            ],
            [
                'user_id' => 2,
                'book_id'  => 1,
                'loan_date'  =>  "2024-02-05 00:00:00",
                'due_date'  =>  "2024-02-07 00:00:00",
                'status' => 'borrowed',
                'updated_at'  => '2024-02-07 00:00:00',
                'deleted_at' => null,
            ],
        ];
        $this->db->table('borrows')->insertBatch($data);
    }
}
