<?php

use yii\db\Migration;
use \console\traits\DbTableConfigurator;
use \common\components\Role;

/**
 * Миграция.
 *
 * Создание начальной структуры БД.
 *
 */
class m130524_201442_init extends Migration
{
    use DbTableConfigurator;

    /**
     * Дополнительные параметры таблиц БД.
     *
     * @var $tableOptions string
     */
    private $tableOptions;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->tableOptions = $this->getOptions($this->db->driverName);
    }

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        // Пользователи
        $this->createTable('{{%user}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[username]]'              => $this->string(80)->notNull()." COMMENT 'Логин'",
            '[[status]]'                => $this->smallInteger()->notNull()." COMMENT 'Статус'",
            '[[fio]]'                   => $this->string(255)->notNull()." COMMENT 'ФИО'",
            '[[email]]'                 => $this->string(80)->notNull()->unique()." COMMENT 'E-mail'",
            '[[phone]]'                 => $this->char(11)->defaultValue(null)." COMMENT 'Телефон'",
            '[[password_hash]]'         => $this->char(60)->notNull()." COMMENT 'Хеш-пароля'",
            '[[password_temp]]'         => $this->string(50)." COMMENT 'Пароль без шифрования'",
            '[[auth_key]]'              => $this->string(32)." COMMENT 'Ключ аутентификации'",
            '[[verification_token]]'    => $this->string()->defaultValue(null)." COMMENT 'Токен верификации'",
            '[[role]]'                  => $this->string(100)." COMMENT 'Роль'",
            '[[description]]'           => $this->string(100)." COMMENT 'Описание'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Информация об участниках
        $this->createTable('{{%member_info}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[first_name]]'            => $this->string(80)->notNull()." COMMENT 'Имя'",
            '[[last_name]]'             => $this->string(80)->notNull()." COMMENT 'Фамилия'",
            '[[second_name]]'           => $this->string(80)." COMMENT 'Отчество'",
            '[[phone]]'                 => $this->string(20)." COMMENT 'Телефон'",
            '[[email]]'                 => $this->string(50)." COMMENT 'Email'",
            '[[badge_number]]'          => $this->string(4)." COMMENT 'Номер бейджа'",
            '[[sms_code]]'              => $this->string(6)." COMMENT 'Временный SMS-код'",
            '[[sms_result]]'            => $this->string(255)." COMMENT 'Результат отправки SMS'",
            '[[isValidSmsCode]]'        => $this->boolean()->defaultValue(false)." COMMENT 'Флаг SMS-код проверен'",
            '[[token]]'                 => $this->string(10)." COMMENT 'Токен'",
            '[[user_id]]'               => $this->integer(11)." COMMENT 'ID пользователя представителя'",
            '[[member_form_scenario]]'  => $this->string(255)." COMMENT 'Сценарий формы создания участника'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Команды
        $this->createTable('{{%team}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[name]]'                  => $this->text()->notNull()." COMMENT 'Название'",
            '[[city_regional_stage]]'   => $this->string(255)." COMMENT 'Город проведения регионального этапа'",
            '[[user_id]]'               => $this->integer(11)." COMMENT 'ID пользователя представителя'",
            '[[user_create_role]]'      => $this->string(255)." COMMENT 'Роль пользователя создавший команду'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Номинации
        $this->createTable('{{%nomination}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[name]]'                  => $this->string(255)->notNull()." COMMENT 'Название'",
            '[[role]]'                  => $this->string(255)." COMMENT 'Роль пользователя'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Команды в номинациях
        $this->createTable('{{%nomination_team}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[nomination_id]]'         => $this->integer(11)->notNull()." COMMENT 'ID номинации'",
            '[[team_id]]'               => $this->integer(11)->notNull()." COMMENT 'ID команды'",
            '[[priority]]'              => $this->string(10)." COMMENT 'Приоритет'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Участники (основные)
        $this->createTable('{{%member_main}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[team_id]]'               => $this->integer(11)->defaultValue(null)." COMMENT 'ID основной команды участников'",
            '[[member_position]]'       => $this->integer(1)." COMMENT 'Позиция участника'",
            '[[clothing_size]]'         => $this->string(5)." COMMENT 'Размер одежды'",
            '[[region_residence]]'      => $this->string(255)." COMMENT 'Регион проживания'",
            '[[team_status]]'           => $this->tinyInteger(1)." COMMENT 'Статус в команде'",
            '[[is_plans_live_in_city]]' => $this->string(3)." COMMENT 'Планируете ли проживать в г.Казань'",
            '[[address_live_in_city]]'  => $this->string(255)." COMMENT 'Адрес проживания в г.Казань'",
            '[[qr_code]]'               => $this->string(1024)." COMMENT 'QR-code'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Участники (Опорные вузы)
        $this->createTable('{{%member_universities}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[team_id]]'               => $this->integer(11)->defaultValue(null)." COMMENT 'ID основной команды участников'",
            '[[member_position]]'       => $this->integer(1)." COMMENT 'Позиция участника'",
            '[[clothing_size]]'         => $this->string(5)." COMMENT 'Размер одежды'",
            '[[region_residence]]'      => $this->string(255)." COMMENT 'Регион проживания'",
            '[[team_status]]'           => $this->tinyInteger(1)." COMMENT 'Статус в команде'",
            '[[is_plans_live_in_city]]' => $this->string(3)." COMMENT 'Планируете ли проживать в г.Казань'",
            '[[address_live_in_city]]'  => $this->string(255)." COMMENT 'Адрес проживания в г.Казань'",
            '[[qr_code]]'               => $this->string(1024)." COMMENT 'QR-code'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Участники (Школьники)
        $this->createTable('{{%member_pupils}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[team_id]]'               => $this->integer(11)->defaultValue(null)." COMMENT 'ID основной команды участников'",
            '[[member_position]]'       => $this->integer(1)." COMMENT 'Позиция участника'",
            '[[clothing_size]]'         => $this->string(5)." COMMENT 'Размер одежды'",
            '[[region_residence]]'      => $this->string(255)." COMMENT 'Регион проживания'",
            '[[team_status]]'           => $this->tinyInteger(1)." COMMENT 'Статус в команде'",
            '[[qr_code]]'               => $this->string(1024)." COMMENT 'QR-code'",
            '[[agent_fio]]'             => $this->string(255)." COMMENT 'ФИО ответственного лица'",
            '[[agent_phone]]'           => $this->string(20)." COMMENT 'Номер телефона ответственного лица'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Дирекция и организаторы
        $this->createTable('{{%member_management}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)." COMMENT 'Статус'", // Дирекция или Организатор
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Волонтеры
        $this->createTable('{{%member_volunteers}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::VOLUNTEERS)." COMMENT 'Статус'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Эксперты
        /*$this->createTable('{{%member_experts}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer()->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::EXPERTS)." COMMENT 'Статус'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);*/

        // Жюри
        $this->createTable('{{%member_jury}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::JURY)." COMMENT 'Статус'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Гости и почетные гости
        $this->createTable('{{%member_guests}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)." COMMENT 'Статус'", // Гость или почетный гость
            '[[place_work]]'            => $this->string(255)." COMMENT 'Место работы'",
            '[[position]]'              => $this->string(255)." COMMENT 'Должность'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Модераторы
        $this->createTable('{{%member_moderators}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[nomination_id]]'         => $this->integer(11)->notNull()." COMMENT 'ID номинации'",
            '[[status]]'                => $this->string()->defaultValue(Role::MODERATORS)." COMMENT 'Статус'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Пресса
        $this->createTable('{{%member_press}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::PRESS)." COMMENT 'Статус'",
            '[[name_organization]]'     => $this->string(255)->notNull()." COMMENT 'Название организации'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Партнеры
        $this->createTable('{{%member_partners}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer(11)->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::PARTNERS)." COMMENT 'Статус'",
            '[[name_organization]]'     => $this->string(255)->notNull()." COMMENT 'Название организации'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Служба безопасности
        $this->createTable('{{%member_security_service}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer()->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::SECURITY_SERVICE)." COMMENT 'Статус'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);

        // Технический персонал
        $this->createTable('{{%member_technical_staff}}', [
            '[[id]]'                    => $this->primaryKey()->notNull(),
            '[[member_info_id]]'        => $this->integer()->notNull()." COMMENT 'ID инфо участника'",
            '[[status]]'                => $this->string(30)->defaultValue(Role::TECHNICAL_STAFF)." COMMENT 'Статус'",
            '[[created]]'               => $this->dateTime()." COMMENT 'Дата и время добавления'",
            '[[updated]]'               => $this->dateTime()." COMMENT 'Дата и время обновления'",
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%member_info}}');
        $this->dropTable('{{%team}}');
        $this->dropTable('{{%nomination}}');
        $this->dropTable('{{%nomination_team}}');
        $this->dropTable('{{%member_main}}');
        $this->dropTable('{{%member_universities}}');
        $this->dropTable('{{%member_pupils}}');
    }
}
