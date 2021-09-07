<?php

namespace App\Migration;

use Home\CmsMini\Db\Migration;
use Home\CmsMini\Db\Column;
use Home\CmsMini\Db\Constrain;

class m1630428094_create_post_table extends Migration
{
    public function up()
    {
        $this->createTable('post', [
            'id'            => Column::primary(),
            'title'         => Column::string()->notNull(),
            'excerpt'       => Column::text(),
            'content'       => Column::text(),
            'category_id'   => Column::foreignKey(),
            'user_id'       => Column::foreignKey(),
            'image'         => Column::string(),
            'created_at'    => Column::time()->default(Column::CURRENT_TIME),
            'updated_at'    => Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);

        $this->addConstrain(
            'post',
            'fk_post_category', 
            Constrain::foreignKey('category_id')
                ->references('category', 'id')
                ->update(Constrain::RESTRICT)
                ->delete(Constrain::CASCADE)
        );

        $this->addConstrain(
            'post',
            'fk_post_user', 
            Constrain::foreignKey('user_id')
                ->references('user', 'id')
                ->update(Constrain::RESTRICT)
                ->delete(Constrain::CASCADE)
        );
    }
    
    public function down()
    {
        $this->dropTable('post');
    }
}