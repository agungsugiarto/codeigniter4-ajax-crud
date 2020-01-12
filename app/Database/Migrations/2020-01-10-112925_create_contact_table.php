<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true ],
			'title' => [ 'type' => 'VARCHAR', 'constraint' => '100'],
			'author' => [ 'type' =>'VARCHAR', 'constraint' => 100, 'default' => 'King of Town' ],
			'description' => [ 'type' => 'TEXT', 'null' => true ],
			'status' => [ 'type' => 'ENUM', 'constraint' => ['publish', 'pending', 'draft'], 'default' => 'pending' ],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addPrimaryKey('id');
		$this->forge->createTable('books', FALSE, ['ENGINE' => 'InnoDB']);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('books');
	}
}
