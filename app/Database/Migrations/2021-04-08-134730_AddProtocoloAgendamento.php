<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProtocoloAgendamento extends Migration
{
	public function up()
	{
		$fields = [
			'protocolo' => [
				'type' => 'VARCHAR',
				'constraint' => '10',
			],
		];

		$this->forge->addColumn('agendamento', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('agendamento', $fields);
	}
}
