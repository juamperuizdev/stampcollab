<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableStaJournal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'created'     => ['type' => 'DATETIME', 'null' => false, 'default' => new RawSql('current_timestamp()')],
            'updated'     => ['type' => 'DATETIME', 'null' => false, 'default' => new RawSql('current_timestamp() ON UPDATE current_timestamp()')],
            'status'      => ['type' => 'ENUM', 'constraint' => ['HIDDEN', 'STARTED', 'FINISHED', ''], 'null' => false, 'default' => 'HIDDEN'],
            'pages'       => ['type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0],
            'stamps'      => ['type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'description' => ['type' => 'LONGTEXT', 'null' => true],
            'cover'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sta_journal');
    }

    public function down()
    {
        $this->forge->dropTable('sta_journal');
    }
}
