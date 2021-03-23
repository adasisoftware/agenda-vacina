<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addvagasrestantesagenda extends Migration
{
	public function up()
	{
		$fields = [
			'vagas_restantes' => [
				'type' => 'INT',
				'constraint' => 4,
			]
		];

		$this->forge->addColumn('agenda', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('agenda', $fields);
	}
}
