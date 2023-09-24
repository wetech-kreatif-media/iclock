<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttlogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 50,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 50,
                'unsigned' => true,
            ],
            'sn' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'status' => [
                'type' => 'TINYINT',
            ],
            'date' => [
                'type' => 'DATETIME',
            ],
            'upload' => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('attlog');
    }

    public function down()
    {
        $this->forge->dropTable('attlog', true);
    }
}
