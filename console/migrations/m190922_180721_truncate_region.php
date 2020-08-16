<?php

use yii\db\Migration;

/**
 * Class m190922_180721_truncate_region
 */
class m190922_180721_truncate_region extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->truncateTable('region');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190922_180721_truncate_region cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190922_180721_truncate_region cannot be reverted.\n";

        return false;
    }
    */
}
