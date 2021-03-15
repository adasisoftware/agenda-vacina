<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaciente extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'SERIAL',				
			],
			'cpf' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],			
			'nome' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],			
			'nome_mae' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],			
			'data_nascimento' => [
				'type' => 'DATE',
			],
			'telefone' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],	
			'date date DEFAULT current_date NOT NULL ',		
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('paciente');
	}

	public function down()
	{
		$this->forge->dropTable('paciente');
	}
}