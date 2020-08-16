<?php

use yii\db\Migration;
use \common\models\User;
use \common\components\Role;
use \common\components\Rbac;

/**
 * Создание администратора
 *
 * Class m190915_095130_create_superuser
 */
class m190915_095130_create_superuser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $superAdministrator = new User();
        $superAdministrator->username = 'admin';
        $superAdministrator->status = User::STATUS_ACTIVE;
        $superAdministrator->fio = 'Федоров Антон';
        $superAdministrator->phone = '89997007003';
        $superAdministrator->email = 'fedorovau2012@gmail.ru';
        $superAdministrator->password_hash = Yii::$app->security->generatePasswordHash('adminadmin');
        $superAdministrator->created = date("Y-m-d H:i:s");
        $superAdministrator->updated = date("Y-m-d H:i:s");
        $superAdministrator->insert(false);

        Rbac::bindUserAndRole($superAdministrator->getId(), Role::ADMINISTRATOR);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $superAdministrator = User::findOne(['username' => 'admin']);
        Rbac::unbindUserAndRole($superAdministrator->getId(), Role::ADMINISTRATOR);
        $superAdministrator->delete();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190915_095130_create_superuser cannot be reverted.\n";

        return false;
    }
    */
}
