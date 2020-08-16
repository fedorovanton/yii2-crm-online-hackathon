<?php

use yii\db\Migration;

/**
 * Class m190923_082047_addColumn_member_guests
 */
class m190923_082047_addColumn_member_guests extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member_guests', 'nomination_id', $this->integer(11)->notNull()->after('status'));
        $this->addCommentOnColumn('member_guests', 'nomination_id', 'ID номинации');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_082047_addColumn_member_guests cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_082047_addColumn_member_guests cannot be reverted.\n";

        return false;
    }
    */
}
