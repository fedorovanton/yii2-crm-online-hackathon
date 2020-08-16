<?php

use yii\db\Migration;

/**
 * Class m190923_052436_update_auth_item
 */
class m190923_052436_update_auth_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('auth_item', [
            'description' => 'Дирекция и организаторы'
        ], [
            'name' => 'management'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190923_052436_update_auth_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190923_052436_update_auth_item cannot be reverted.\n";

        return false;
    }
    */
}
