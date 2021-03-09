<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgenda extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'SERIAL',				
			],
			'data_hora' => [
				'type' => 'TIMESTAMP',			
			],			
			'vagas' => [
				'type' => 'INT',			
			],			
			'grupo_id' => [
				'type' => 'INT',			
			],			
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('grupo_id','grupo','id','CASCADE','RESTRICT');
		$this->forge->createTable('agenda');
	}

	public function down()
	{
		$this->forge->dropTable('agenda');
	}
}