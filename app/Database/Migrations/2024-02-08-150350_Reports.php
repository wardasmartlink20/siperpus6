<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reports extends Migration
{
    protected $forge;
    public function __construct()
    {
        $this->forge = \Config\Database::forge();
    }

    public function up()
    {
        $this->forge->addField([
            'report_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'borrow_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('report_id', true);
        $this->forge->addForeignKey('borrow_id', 'borrows', 'borrow_id');
        $this->forge->createTable('reports');
    }

    public function down()
    {
        $this->forge->dropTable('reports');
    }
}
