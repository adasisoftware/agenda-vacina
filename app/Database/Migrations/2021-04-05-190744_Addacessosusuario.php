<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addacessosusuario extends Migration
{
	public function up()
	{
		$fields = [
			'dt_ultimo_acesso' => [
				'type' => 'TIMESTAMP',
			],			
			'ip_ultimo_acesso' => [
				'type' => 'varchar',
				'constraint' => '100'
			]
		];

		$this->forge->addColumn('usuario', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('usuario', $fields);
	}
}
