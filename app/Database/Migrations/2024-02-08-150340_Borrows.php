<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Borrows extends Migration
{
    protected $forge;
    public function __construct()
    {
        $this->forge = \Config\Database::forge();
    }

    public function up()
    {
        $this->forge->addField([
            'borrow_id' => [
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
            'confirm_by' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'loan_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'due_date' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
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

        $this->forge->addKey('borrow_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'user_id');
        $this->forge->addForeignKey('book_id', 'books', 'book_id');
        $this->forge->createTable('borrows');
    }

    public function down()
    {
        $this->forge->dropTable('borrows');
    }
}
