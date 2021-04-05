<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addidadegrupo extends Migration
{
	public function up()
	{
		$fields = [
			'idade_min' => [
				'type' => 'INT',
			],			
			'idade_max' => [
				'type' => 'INT',
			]
		];

		$this->forge->addColumn('grupo', $fields);
	}
	

	public function down()
	{
		$this->forge->dropColumn('grupo', $fields);
	}
}
