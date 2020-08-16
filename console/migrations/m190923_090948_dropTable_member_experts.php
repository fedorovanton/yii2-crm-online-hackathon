<?php

use yii\db\Migration;

/**
 * Class m190923_090948_dropTable_member_experts
 */
class m190923_090948_dropTable_member_experts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->dropTable('member_experts');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_090948_dropTable_member_experts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_090948_dropTable_member_experts cannot be reverted.\n";

        return false;
    }
    */
}
