<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DecretoMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'document'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'date'       => ['type' => 'DATE'],
            'created_at' => ['type' => 'DATETIME'],
            'update_at'  => ['type' => 'DATETIME'],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('decretos');
    }

    public function down()
    {
        $this->forge->dropTable('decretos');
    }
}
