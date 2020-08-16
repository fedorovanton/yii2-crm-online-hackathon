<?php

use yii\db\Migration;

/**
 * Class m190920_051627_addColumn
 */
class m190920_051627_addColumn extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member_main', 'doc_file', $this->string(1024)." COMMENT 'Резюме'");
        $this->addColumn('member_universities', 'doc_file', $this->string(1024)." COMMENT 'Справка'");
        $this->addColumn('member_pupils', 'doc_file', $this->string(1024)." COMMENT 'Грамота'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('member_main', 'doc_file');
        $this->dropColumn('member_universities', 'doc_file');
        $this->dropColumn('member_pupils', 'doc_file');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190920_051627_addColumn cannot be reverted.\n";

        return false;
    }
    */
}
