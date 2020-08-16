<?php

use yii\db\Migration;
use \common\components\Role;

/**
 * Class m190915_091916_rbac_roles_add
 */
class m190915_091916_rbac_roles_add extends Migration
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
     * Удаление роли из RBAC.
     *
     * @param string $name Наименование.
     */
    private function _deleteRole($name)
    {
        $this->authManager->remove($this->authManager->getRole($name));
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->_createRole(Role::ADMINISTRATOR, 'Администратор');
        $this->_createRole(Role::MEMBERS_MAIN, 'Участники (основные)');
        $this->_createRole(Role::MEMBERS_UNIVERSITIES, 'Участники (опорные вузы)');
        $this->_createRole(Role::MEMBERS_PUPILS, 'Участники (школьники)');
        $this->_createRole(Role::MANAGEMENT, 'Дирекция и организаторы');
        $this->_createRole(Role::VOLUNTEERS, 'Волонтеры');
//        $this->_createRole(Role::EXPERTS, 'Эксперты');
        $this->_createRole(Role::JURY, 'Жюри');
        $this->_createRole(Role::GUESTS, 'Гости и почетные гости');
        $this->_createRole(Role::MODERATORS, 'Модераторы');
        $this->_createRole(Role::PRESS, 'Пресса');
        $this->_createRole(Role::PARTNERS, 'Партнеры');
        $this->_createRole(Role::SECURITY_SERVICE, 'Служба безопасности');
        $this->_createRole(Role::TECHNICAL_STAFF, 'Технический персонал');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->_deleteRole(Role::ADMINISTRATOR);
        $this->_deleteRole(Role::MEMBERS_MAIN);
        $this->_deleteRole(Role::MEMBERS_UNIVERSITIES);
        $this->_deleteRole(Role::MEMBERS_PUPILS);
        $this->_deleteRole(Role::MANAGEMENT);
        $this->_deleteRole(Role::VOLUNTEERS);
//        $this->_deleteRole(Role::EXPERTS);
        $this->_deleteRole(Role::JURY);
        $this->_deleteRole(Role::GUESTS);
        $this->_deleteRole(Role::MODERATORS);
        $this->_deleteRole(Role::PRESS);
        $this->_deleteRole(Role::PARTNERS);
        $this->_deleteRole(Role::SECURITY_SERVICE);
        $this->_deleteRole(Role::TECHNICAL_STAFF);
    }
}
