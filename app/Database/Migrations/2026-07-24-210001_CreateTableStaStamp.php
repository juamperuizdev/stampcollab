<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableStaStamp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'id_journal' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'status'     => ['type' => 'TINYINT', 'unsigned' => true, 'null' => false, 'default' => 1],
            'created'    => ['type' => 'DATETIME', 'null' => false, 'default' => new RawSql('current_timestamp()')],
            'number'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'ip'         => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_journal');
        $this->forge->addForeignKey('id_journal', 'sta_journal', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('sta_stamp');
    }

    public function down()
    {
        $this->forge->dropTable('sta_stamp');
    }
}
