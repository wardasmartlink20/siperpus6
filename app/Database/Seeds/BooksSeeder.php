<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BooksSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'thumbnail' => '/assets/books/1707417890_2fb1411c09799789c8fc.png',
                'title'  => 'Alan',
                'writer'  =>  "Warda",
                'publisher'  =>  "Pacarnya Awa",
                'year_publication' => '2024',
                'synopsis'  => 'Novel ini berkisah tentang Meisya Nata Wijaya yang baper dengan Alan Aileen, cowok idaman SMA Cakrawala yang dingin, ganteng, dan wakil ketua geng DRAX.',
                'category_id'  => 1,
            ],
            [
                'thumbnail' => '/assets/books/1707419848_93a3093cdbffcbe1426b.png',
                'title'  => 'Pelangi Setelah Hujan',
                'writer'  =>  "Galang",
                'publisher'  =>  "Fikri",
                'year_publication' => '2024',
                'synopsis'  => 'Novel ini berkisah tentang pasangan suami istri, Kirana dan Lee, yang mengalami kecelakaan mobil dan masuk jurang. Lee dinyatakan hilang, dan beberapa bulan kemudian Kirana bertemu dengan seorang pemuda yang mirip dengan Lee.',
                'category_id'  => 2,
            ],
        ];
        $this->db->table('books')->insertBatch($data);
    }
}
