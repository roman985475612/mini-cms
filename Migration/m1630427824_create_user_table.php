<?php

namespace App\Migration;

use Home\CmsMini\Db\Migration;
use Home\CmsMini\Db\Column;

class m1630427824_create_user_table extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id'        => Column::primary(),
            'username'  => Column::string()->notNull(),
            'email'     => Column::string()->notNull(),
            'password'  => Column::string()->notNull(),
            'token'     => Column::string(),
            'confirm'   => Column::bool(),
            'role'      => Column::string()->notNull(),
            'bio'       => Column::text(),
            'image'     => Column::string(),
            'created_at'=> Column::time()->default(Column::CURRENT_TIME),
            'updated_at'=> Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);
    }
    
    public function down()
    {
        
    }
}