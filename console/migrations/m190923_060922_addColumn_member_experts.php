<?php

use yii\db\Migration;

/**
 * Class m190923_060922_addColumn_member_experts
 */
class m190923_060922_addColumn_member_experts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*$this->addColumn('member_experts', 'place_work', $this->string(255)->after('status'));
        $this->addCommentOnColumn('member_experts', 'place_work', 'Место работы');
        
        $this->addColumn('member_experts', 'position', $this->string(255)->after('status'));
        $this->addCommentOnColumn('member_experts', 'position', 'Должность');
        
        $this->addColumn('member_experts', 'nomination_id', $this->integer(11)->notNull()->after('status'));
        $this->addCommentOnColumn('member_experts', 'nomination_id', 'ID номинации');*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_060922_addColumn_member_experts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_060922_addColumn_member_experts cannot be reverted.\n";

        return false;
    }
    */
}
