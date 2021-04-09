<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdadePaciente extends Migration
{
	public function up()
	{
		$fields = [
			'idade' => [
				'type' => 'INT',
			]
		];

		$this->forge->addColumn('paciente', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('paciente', 'idade');
	}
}
