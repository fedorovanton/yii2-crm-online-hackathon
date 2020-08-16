<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 12:44
 */

namespace common\components;


/**
 * Хелпер для хранения констант с именами RBAC-разрешений.
 *
 * @package common\components
 */
class Permission
{
    /**
     * Разрешение - "администратор".
     * @const ADMINISTRATOR
     */
    const ADMINISTRATOR = 'permission-administrator';

    /**
     * Разрешение - "Участники (основные)".
     * @const MEMBERS_MAIN
     */
    const MEMBERS_MAIN = 'permission-members-main';

    /**
     * Разрешение - "Участники (опорные вузы)".
     * @const MEMBERS_UNIVERSITIES
     */
    const MEMBERS_UNIVERSITIES = 'permission-members-universities';

    /**
     * Разрешение - "Участники (школьники)".
     * @const MEMBERS_PUPILS
     */
    const MEMBERS_PUPILS = 'permission-members-pupils';

    /**
     * Разрешение - "Дирекция и организаторы".
     * @const MANAGEMENT
     */
    const MANAGEMENT = 'permission-management';

    /**
     * Разрешение - "Волонтеры".
     * @const VOLUNTEERS
     */
    const VOLUNTEERS = 'permission-volunteers';

    /**
     * Разрешение - "Жюри и эксперты".
     * @const JURY
     */
    const JURY = 'permission-jury';

    /**
     * Разрешение - "Гости и почетные гости".
     * @const GUESTS
     */
    const GUESTS = 'permission-guests';

    /**
     * Разрешение - "Модераторы".
     * @const MODERATORS
     */
    const MODERATORS = 'permission-moderators';

    /**
     * Разрешение - "Пресса".
     * @const press
     */
    const PRESS = 'permission-press';

    /**
     * Разрешение - "Партнеры".
     * @const PARTNERS
     */
    const PARTNERS = 'permission-partners';

    /**
     * Разрешение - "Служба безопасности".
     * @const SECURITY_SERVICE
     */
    const SECURITY_SERVICE = 'permission-security-service';

    /**
     * Разрешение - "Технический персонал".
     * @const TECHNICAL_STAFF
     */
    const TECHNICAL_STAFF = 'permission-technical-staff';

    /**
     * Разрешение - "Аккредитация".
     * @const ACCREDITATION
     */
    const ACCREDITATION = 'permission-accreditation';
}