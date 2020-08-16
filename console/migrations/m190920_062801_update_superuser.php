<?php

use yii\db\Migration;

/**
 * Class m190920_062801_update_superuser
 */
class m190920_062801_update_superuser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('user', [
            'fio' => 'Кирилл Антонов',
            'email' => 'sum@antonovk.ru',
            'phone' => '89881174413',
            'role' => 'administrator',
        ], ['username' => 'admin']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190920_062801_update_superuser cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190920_062801_update_superuser cannot be reverted.\n";

        return false;
    }
    */
}
