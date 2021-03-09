<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsuario extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'SERIAL',				
			],
			'nome' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'senha' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('usuario');
	}

	public function down()
	{
		$this->forge->dropTable('usuario');
	}
}
