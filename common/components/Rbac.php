<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 12:43
 */

namespace common\components;


use Yii;

/**
 * Обертка для AuthManager.
 *
 * @package common\components
 */
class Rbac
{
    /**
     * Прикрепление пользователя к роли.
     *
     * @param int    $userID   Идентификатор пользователя.
     * @param string $roleName Наименование роли.
     */
    public static function bindUserAndRole($userID, $roleName)
    {
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($roleName);
        $authManager->assign($role, $userID);
    }

    /**
     * Открепление пользователя от роли.
     *
     * @param int    $userID   Идентификатор пользователя.
     * @param string $roleName Наименование роли.
     */
    public static function unbindUserAndRole($userID, $roleName)
    {
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($roleName);
        $authManager->revoke($role, $userID);
    }

    /**
     * Прикрепление пользователя к разрешению.
     *
     * @param int    $userID         Идентификатор пользователя.
     * @param string $permissionName Наименование разрешения.
     */
    public static function bindUserAndPermission($userID, $permissionName)
    {
        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission($permissionName);
        $authManager->assign($permission, $userID);
    }

    /**
     * Открепление пользователя от разрешения.
     *
     * @param int    $userID         Идентификатор пользователя.
     * @param string $permissionName Наименование разрешения.
     */
    public static function unbindUserAndPermission($userID, $permissionName)
    {
        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission($permissionName);
        $authManager->revoke($permission, $userID);
    }

    /**
     * Создание разрешения.
     *
     * @param string $name        Наименование.
     * @param string $description Описание.
     */
    public static function createPermission($name, $description)
    {
        $authManager = Yii::$app->authManager;
        $permission = $authManager->createPermission($name);
        $permission->description = $description;
        $authManager->add($permission);
    }

    /**
     * Удаление разрешения.
     *
     * @param string $permissionName Наименование разрешения.
     */
    public static function removePermission($permissionName)
    {
        $authManager = Yii::$app->authManager;
        $authManager->remove($authManager->getPermission($permissionName));
    }

    /**
     * Добавление дочернего разрешения к роли.
     *
     * @param string $permissionName Наименование разрешения.
     * @param string $roleName       Наименование роли.
     */
    public static function addPermissionChild($permissionName, $roleName)
    {
        $authManager = Yii::$app->authManager;
        $permission = $authManager->getPermission($permissionName);
        $role = $authManager->getRole($roleName);
        $authManager->addChild($role, $permission);
    }

    /**
     * Удаление дочерного разрешение из роли.
     *
     * @param string $permissionName Наименование разрешения.
     * @param string $roleName       Наименование роли.
     */
    public static function removePermissionChildFromRole($permissionName, $roleName)
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeChild($authManager->getRole($roleName), $authManager->getPermission($permissionName));
    }

    /**
     * Удаление всех ролей и разрешений пользователя.
     *
     * @param integer $userID Идентификатор пользователя.
     */
    public static function revokeAll($userID)
    {
        Yii::$app->authManager->revokeAll($userID);
    }
}