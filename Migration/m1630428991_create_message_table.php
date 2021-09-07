<?php

namespace App\Migration;

use Home\CmsMini\Db\Migration;
use Home\CmsMini\Db\Column;

class m1630428991_create_message_table extends Migration
{
    public function up()
    {
        $this->createTable('message', [
            'id'        => Column::primary(),
            'firstname' => Column::string()->notNull(),
            'lastname'  => Column::string()->notNull(),
            'email'     => Column::string()->notNull(),
            'phone'     => Column::string()->notNull(),
            'body'      => Column::text(),
            'created_at' => Column::time()->default(Column::CURRENT_TIME),
            'updated_at' => Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);        
    }
    
    public function down()
    {
        $this->dropTable('message');
    }
}