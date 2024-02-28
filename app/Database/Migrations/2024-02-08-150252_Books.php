<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Books extends Migration
{
    protected $forge;
    public function __construct()
    {
        $this->forge = \Config\Database::forge();
    }

    public function up()
    {
        $this->forge->addField([
            'book_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'writer' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'publisher' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'year_publication' => [
                'type' => 'INT',
                'constraint' => 50,
                'null' => true,
            ],
            'synopsis' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'thumbnail' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'stock' => [
                'type' => 'INT',
                'contraint' => true,
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

        $this->forge->addKey('book_id', true);
        $this->forge->addForeignKey('category_id', 'categories', 'category_id');
        $this->forge->createTable('books');
    }

    public function down()
    {
        $this->forge->dropTable('books');
    }
}
