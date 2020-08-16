<?php

use yii\db\Migration;

/**
 * Class m190923_055757_addColumn_member_jury
 */
class m190923_055757_addColumn_member_jury extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member_jury', 'place_work', $this->string(255)->after('status'));
        $this->addCommentOnColumn('member_jury', 'place_work', 'Место работы');

        $this->addColumn('member_jury', 'position', $this->string(255)->after('status'));
        $this->addCommentOnColumn('member_jury', 'position', 'Должность');

        $this->addColumn('member_jury', 'nomination_id', $this->integer(11)->notNull()->after('status'));
        $this->addCommentOnColumn('member_jury', 'nomination_id', 'ID номинации');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_055757_addColumn_member_jury cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_055757_addColumn_member_jury cannot be reverted.\n";

        return false;
    }
    */
}
