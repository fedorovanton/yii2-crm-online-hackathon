<?php

use yii\db\Migration;

/**
 * Class m190923_092411_update_member_jury
 */
class m190923_092411_update_member_jury extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('member_jury', [
            'status' => \common\models\MemberJury\BaseMemberJury::STATUS_JURY,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_092411_update_member_jury cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_092411_update_member_jury cannot be reverted.\n";

        return false;
    }
    */
}
