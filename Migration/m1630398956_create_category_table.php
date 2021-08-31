<?php

namespace App\Migration;

use Home\CmsMini\Db\Migration;
use Home\CmsMini\Db\Column;

class m1630398956_create_category_table extends Migration
{
    public function up()
    {
        $this->createTable('category', [
            'id' => Column::primary(),
            'title' => Column::string(255)->notNull(),
            'created_at' => Column::time()->default(Column::CURRENT_TIME),
            'updated_at' => Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);
    }
    
    public function down()
    {
        $this->dropTable('category');
    }
}