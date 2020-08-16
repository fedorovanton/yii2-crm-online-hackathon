<?php

use yii\db\Migration;

/**
 * Class m190925_045717_dropColumn_in_member_moderators
 */
class m190925_045717_dropColumn_in_member_moderators extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('member_moderators', 'nomination_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190925_045717_dropColumn_in_member_moderators cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190925_045717_dropColumn_in_member_moderators cannot be reverted.\n";

        return false;
    }
    */
}
