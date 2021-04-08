<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgendamento extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'SERIAL',				
			],
			'agenda_id' => [
				'type' => 'INT',

			],
			'grupo_id' => [
				'type' => 'INT',

			],			
			'paciente_id' => [
				'type' => 'INT',

			],			
			'usuario_id' => [
				'type' => 'INT',

			],			
			'created_at date DEFAULT current_date NOT NULL ',				
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('protocolo');
		$this->forge->addForeignKey('agenda_id','agenda','id','CASCADE','RESTRICT');
		$this->forge->addForeignKey('grupo_id','grupo','id','CASCADE','RESTRICT');
		$this->forge->addForeignKey('paciente_id','paciente','id','CASCADE','RESTRICT');
		$this->forge->addForeignKey('usuario_id','usuario','id','CASCADE','RESTRICT');
		$this->forge->createTable('agendamento');
	}

	public function down()
	{
		$this->forge->dropTable('agendamento');
	}
}
