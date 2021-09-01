<?php

namespace App\Migration;

use Home\CmsMini\Db\Migration;
use Home\CmsMini\Db\Column;

class m1630429004_create_subscribe_table extends Migration
{
    public function up()
    {
        $this->createTable('subscribe', [
            'id'        => Column::primary(),
            'name'      => Column::string()->notNull(),
            'email'     => Column::string()->notNull(),
            'created_at' => Column::time()->default(Column::CURRENT_TIME),
            'updated_at' => Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);                
    }
    
    public function down()
    {
        
    }
}