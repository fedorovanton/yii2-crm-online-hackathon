<?php

use yii\db\Migration;
use \common\components\Rbac;
use \common\components\Permission;
use \common\components\Role;


/**
 * Миграция.
 *
 * @see \common\components\Rbac
 * @see \common\components\Role
 * @see \common\components\Permission
 *
 * Создание всех базовых разрешений.
 */
class m190915_094209_rbac_permission_add extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Одноименные разрешения с ролями, созданы для удобства.
        Rbac::createPermission(Permission::ADMINISTRATOR, 'Администратор');
        Rbac::createPermission(Permission::MEMBERS_MAIN, 'Участники (основные)');
        Rbac::createPermission(Permission::MEMBERS_UNIVERSITIES, 'Участники (опорные вузы)');
        Rbac::createPermission(Permission::MEMBERS_PUPILS, 'Участники (школьники)');
        Rbac::createPermission(Permission::MANAGEMENT, 'Дирекция и организаторы');
        Rbac::createPermission(Permission::VOLUNTEERS, 'Волонтеры');
//        Rbac::createPermission(Permission::EXPERTS, 'Эксперты');
        Rbac::createPermission(Permission::JURY, 'Жюри');
        Rbac::createPermission(Permission::GUESTS, 'Гости и почетные гости');
        Rbac::createPermission(Permission::MODERATORS, 'Модераторы');
        Rbac::createPermission(Permission::PRESS, 'Пресса');
        Rbac::createPermission(Permission::PARTNERS, 'Партнеры');
        Rbac::createPermission(Permission::SECURITY_SERVICE, 'Служба безопасности');
        Rbac::createPermission(Permission::TECHNICAL_STAFF, 'Технический персонал');

        // Связываем все роли пользователей с одноименными разрешениями.
        Rbac::addPermissionChild(Permission::ADMINISTRATOR, Role::ADMINISTRATOR);
        Rbac::addPermissionChild(Permission::MEMBERS_MAIN, Role::MEMBERS_MAIN);
        Rbac::addPermissionChild(Permission::MEMBERS_UNIVERSITIES, Role::MEMBERS_UNIVERSITIES);
        Rbac::addPermissionChild(Permission::MEMBERS_PUPILS, Role::MEMBERS_PUPILS);
        Rbac::addPermissionChild(Permission::MANAGEMENT, Role::MANAGEMENT);
        Rbac::addPermissionChild(Permission::VOLUNTEERS, Role::VOLUNTEERS);
//        Rbac::addPermissionChild(Permission::EXPERTS, Role::EXPERTS);
        Rbac::addPermissionChild(Permission::JURY, Role::JURY);
        Rbac::addPermissionChild(Permission::GUESTS, Role::GUESTS);
        Rbac::addPermissionChild(Permission::MODERATORS, Role::MODERATORS);
        Rbac::addPermissionChild(Permission::PRESS, Role::PRESS);
        Rbac::addPermissionChild(Permission::PARTNERS, Role::PARTNERS);
        Rbac::addPermissionChild(Permission::SECURITY_SERVICE, Role::SECURITY_SERVICE);
        Rbac::addPermissionChild(Permission::TECHNICAL_STAFF, Role::TECHNICAL_STAFF);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Rbac::removePermissionChildFromRole(Permission::ADMINISTRATOR, Role::ADMINISTRATOR);
        Rbac::removePermissionChildFromRole(Permission::MEMBERS_MAIN, Role::MEMBERS_MAIN);
        Rbac::removePermissionChildFromRole(Permission::MEMBERS_UNIVERSITIES, Role::MEMBERS_UNIVERSITIES);
        Rbac::removePermissionChildFromRole(Permission::MEMBERS_PUPILS, Role::MEMBERS_PUPILS);
        Rbac::removePermissionChildFromRole(Permission::MANAGEMENT, Role::MANAGEMENT);
        Rbac::removePermissionChildFromRole(Permission::VOLUNTEERS, Role::VOLUNTEERS);
        Rbac::removePermissionChildFromRole(Permission::EXPERTS, Role::EXPERTS);
        Rbac::removePermissionChildFromRole(Permission::JURY, Role::JURY);
        Rbac::removePermissionChildFromRole(Permission::GUESTS, Role::GUESTS);
        Rbac::removePermissionChildFromRole(Permission::MODERATORS, Role::MODERATORS);
        Rbac::removePermissionChildFromRole(Permission::PRESS, Role::PRESS);
        Rbac::removePermissionChildFromRole(Permission::PARTNERS, Role::PARTNERS);
        Rbac::removePermissionChildFromRole(Permission::SECURITY_SERVICE, Role::SECURITY_SERVICE);
        Rbac::removePermissionChildFromRole(Permission::TECHNICAL_STAFF, Role::TECHNICAL_STAFF);

        Rbac::removePermission(Permission::ADMINISTRATOR);
        Rbac::removePermission(Permission::MEMBERS_MAIN);
        Rbac::removePermission(Permission::MEMBERS_UNIVERSITIES);
        Rbac::removePermission(Permission::MEMBERS_PUPILS);
        Rbac::removePermission(Permission::MANAGEMENT);
        Rbac::removePermission(Permission::VOLUNTEERS);
        Rbac::removePermission(Permission::EXPERTS);
        Rbac::removePermission(Permission::JURY);
        Rbac::removePermission(Permission::GUESTS);
        Rbac::removePermission(Permission::MODERATORS);
        Rbac::removePermission(Permission::PRESS);
        Rbac::removePermission(Permission::PARTNERS);
        Rbac::removePermission(Permission::SECURITY_SERVICE);
        Rbac::removePermission(Permission::TECHNICAL_STAFF);
    }
}
