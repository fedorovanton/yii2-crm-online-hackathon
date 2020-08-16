<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 12:19
 */

namespace common\components;

/**
 * Хелпер для хранения констант с именами RBAC-ролей.
 *
 * @package common\components
 */
class Role
{
    /**
     * Роль - "администратор".
     * Имеет полный доступ ко всем настройкам панели администратора.
     * @const ADMINISTRATOR
     */
    const ADMINISTRATOR = 'administrator';

    /**
     * Роль - "Участники (основные)".
     * Имеет доступ к разделам, которые нужны для работы Участники (основные)
     * @const MEMBERS_MAIN
     */
    const MEMBERS_MAIN = 'members-main';

    /**
     * Роль - "Участники (опорные вузы)".
     * Имеет доступ к разделам, которые нужны для работы Участники (опорные вузы)
     * @const MEMBERS_UNIVERSITIES
     */
    const MEMBERS_UNIVERSITIES = 'members-universities';

    /**
     * Роль - "Участники (школьники)".
     * Имеет доступ к разделам, которые нужны для работы Участники (школьники)
     * @const MEMBERS_PUPILS
     */
    const MEMBERS_PUPILS = 'members-pupils';

    /**
     * Роль - "Дирекция и организаторы".
     * Имеет доступ к разделам, которые нужны для работы Дирекция и организаторы
     * @const MANAGEMENT
     */
    const MANAGEMENT = 'management';

    /**
     * Роль - "Волонтеры".
     * Имеет доступ к разделам, которые нужны для работы Волонтеры
     * @const VOLUNTEERS
     */
    const VOLUNTEERS = 'volunteers';

    /**
     * Роль - "Жюри и эксперты".
     * Имеет доступ к разделам, которые нужны для работы Жюри и экспертов
     * @const JURY
     */
    const JURY = 'jury';

    /**
     * Роль - "Гости и почетные гости".
     * Имеет доступ к разделам, которые нужны для работы Гости и почетные гости
     * @const GUESTS
     */
    const GUESTS = 'guests';

    /**
     * Роль - "Модераторы".
     * Имеет доступ к разделам, которые нужны для работы Модераторы
     * @const MODERATORS
     */
    const MODERATORS = 'moderators';

    /**
     * Роль - "Пресса".
     * Имеет доступ к разделам, которые нужны для работы Пресса
     * @const press
     */
    const PRESS = 'press';

    /**
     * Роль - "Партнеры".
     * Имеет доступ к разделам, которые нужны для работы Партнеры
     * @const PARTNERS
     */
    const PARTNERS = 'partners';

    /**
     * Роль - "Служба безопасности".
     * Имеет доступ к разделам, которые нужны для работы Служба безопасноти
     * @const SECURITY_SERVICE
     */
    const SECURITY_SERVICE = 'security-service';

    /**
     * Роль - "Технический персонал".
     * Имеет доступ к разделам, которые нужны для работы Технический персонал
     * @const TECHNICAL_STAFF
     */
    const TECHNICAL_STAFF = 'technical-staff';

    /**
     * Роль - "Аккредитация".
     * Имеет доступ к разделам участники (основные, школьники, студенты) на просмотр и изменение статуса выдачи бейджа
     * @const ACCREDITATION
     */
    const ACCREDITATION = 'accreditation';
}