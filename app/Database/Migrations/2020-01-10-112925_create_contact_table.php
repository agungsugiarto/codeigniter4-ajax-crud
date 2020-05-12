<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('status', false, ['ENGINE' => 'InnoDB']);

        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'status_id'   => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'title'       => ['type' => 'VARCHAR', 'constraint' => '100'],
            'author'      => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'King of Town'],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
            'deleted_at'  => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('status_id');
        $this->forge->addForeignKey('status_id', 'status', 'id', false, 'CASCADE');
        $this->forge->createTable('books', false, ['ENGINE' => 'InnoDB']);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('books');
        $this->forge->dropTable('status');
    }
}
