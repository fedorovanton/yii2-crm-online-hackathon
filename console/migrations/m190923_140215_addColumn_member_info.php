<?php

use yii\db\Migration;

/**
 * Class m190923_140215_addColumn_member_info
 */
class m190923_140215_addColumn_member_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('member_info', 'check_status', $this->tinyInteger()->after('member_form_scenario'));
        $this->addCommentOnColumn('member_info', 'check_status', 'Статус проверки анкеты');

        $this->update('member_info', [
            'check_status' => \frontend\models\MemberInfo\MemberInfo::CHECK_STATUS_DRAFT
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_140214_addColumn_in_members cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_140214_addColumn_in_members cannot be reverted.\n";

        return false;
    }
    */
}
