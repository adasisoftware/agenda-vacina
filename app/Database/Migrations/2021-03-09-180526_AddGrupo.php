<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGrupo extends Migration
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
			'idade_min' => [
				'type' => 'INT',
			],			
			'idade_max' => [
				'type' => 'INT',
			],			
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('grupo');
	}

	public function down()
	{
		$this->forge->dropTable('grupo');
	}
}
