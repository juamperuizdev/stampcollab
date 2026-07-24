<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTableStaAdministrator extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'created'  => ['type' => 'DATETIME', 'null' => false, 'default' => new RawSql('current_timestamp()')],
            'updated'  => ['type' => 'DATETIME', 'null' => false, 'default' => new RawSql('current_timestamp() ON UPDATE current_timestamp()')],
            'status'   => ['type' => 'TINYINT', 'null' => false, 'default' => 1],
            'name'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'surname'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'email'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'avatar'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sta_administrator');
    }

    public function down()
    {
        $this->forge->dropTable('sta_administrator');
    }
}
