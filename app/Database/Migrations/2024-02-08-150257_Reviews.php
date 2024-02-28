<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Reviews extends Migration
{
    protected $forge;
    public function __construct()
    {
        $this->forge = \Config\Database::forge();
    }

    public function up()
    {
        $this->forge->addField([
            'review_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'review' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rating' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
                'null' => true,
            ],
        ]);

        $this->forge->addKey('review_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'user_id');
        $this->forge->addForeignKey('book_id', 'books', 'book_id');
        $this->forge->createTable('reviews');
    }

    public function down()
    {
        $this->forge->dropTable('reviews');
    }
}
