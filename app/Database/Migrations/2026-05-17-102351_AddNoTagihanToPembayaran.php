<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNoTagihanToPembayaran extends Migration
{
    public function up()
    {
        $fields = [
            'no_tagihan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'id_pendaftaran'
            ],
        ];
        $this->forge->addColumn('pembayaran', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pembayaran', 'no_tagihan');
    }
}
