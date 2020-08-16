<?php

use yii\db\Migration;

/**
 * Class m190927_125919_addColumn_Member_Info
 */
class m190927_125919_addColumn_Member_Info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member_info', 'badge_issued', $this->tinyInteger()->defaultValue(\common\models\MemberInfo\BaseMemberInfo::BADGE_NOT_ISSUED));
        $this->addCommentOnColumn('member_info', 'badge_issued','Бейдж выдан');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190927_125919_addColumn_Member_Info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_125919_addColumn_Member_Info cannot be reverted.\n";

        return false;
    }
    */
}
