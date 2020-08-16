<?php

use yii\db\Migration;

/**
 * Class m190925_063138_dropColumn_in_member_guests
 */
class m190925_063138_dropColumn_in_member_guests extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('member_guests', 'nomination_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190925_063138_dropColumn_in_member_guests cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190925_063138_dropColumn_in_member_guests cannot be reverted.\n";

        return false;
    }
    */
}
