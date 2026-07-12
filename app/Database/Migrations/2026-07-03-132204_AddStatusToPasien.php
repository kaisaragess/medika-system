<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToPasien extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pasien', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Nonaktif'],
                'default' => 'Aktif',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pasien', 'status');
    }
}
