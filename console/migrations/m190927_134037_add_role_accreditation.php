<?php

use yii\db\Migration;

/**
 * Class m190927_134037_add_role_accreditation
 */
class m190927_134037_add_role_accreditation extends Migration
{
    /**
     * Rbac-менеджер.
     *
     * @var $authManager \yii\rbac\ManagerInterface
     */
    private $authManager;

    public function init()
    {
        parent::init();

        $this->authManager = Yii::$app->authManager;
    }

    /**
     * Добавление роли в RBAC.
     *
     * @param string $name        Наименование.
     * @param string $description Описание.
     */
    private function _createRole($name, $description)
    {
        $role = $this->authManager->createRole($name);
        $role->description = $description;
        $this->authManager->add($role);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->_createRole(\common\components\Role::ACCREDITATION, 'Аккредитация');
        \common\components\Rbac::createPermission(\common\components\Permission::ACCREDITATION, 'Аккредитация');
        \common\components\Rbac::addPermissionChild(\common\components\Permission::ACCREDITATION, \common\components\Role::ACCREDITATION);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190927_134037_add_role_accreditation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_134037_add_role_accreditation cannot be reverted.\n";

        return false;
    }
    */
}
