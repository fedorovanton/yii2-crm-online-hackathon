<?php
namespace common\models;

use common\components\Role;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $fio
 * @property string $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property string $password_temp
 * @property string $description
 * @property string $created
 * @property string $updated
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Логин
            ['username', 'string', 'max' => 80],

            // Статус
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            // ФИО
            ['fio', 'string', 'max' => 255],

            // Email
            ['email', 'email'],

            // Телефон
            ['phone', 'string'],

            ['password_hash', 'string', 'max' => 60],

            ['auth_key', 'string', 'max' => 32],

            ['verification_token', 'string', 'max' => 255],

            [['created', 'updated'],'datetime', 'format' => 'php:Y-m-d H:i:s'],

            ['role', 'required', 'message' => 'Необходимо выбрать роль пользователя.'],
            ['role', 'string'],

            ['description', 'string', 'max' => 255],

            ['password_temp', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'status' => 'Статус',
            'fio' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Телефон',
            'password_hash' => 'Хеш пароля',
            'auth_key' => 'Ключ авторизации',
            'verification_token' => 'Токен верификации',
            'created' => 'Дата и время создания записи',
            'updated' => 'Дата и время обновления записи',
            'role' => 'Роль',
            'description' => 'Описание',
            'password_temp' => 'Временный пароль'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Найти пользователя по номеру телефона
     *
     * @param $phone
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function findUserByPhone($phone)
    {
        return self::find()->where(['phone' => $phone])->one();
    }

    /**
     * Сеттер Обновление записи
     */
    public function setUpdated()
    {
        $this->updated = date('Y-m-d H:i:s');
    }

    /**
     * Сеттер Обновление записи
     */
    public function setCreated()
    {
        $this->created = date('Y-m-d H:i:s');
    }

    /**
     * Получить список ролей для пользователя с ролью Аккредитация
     * @return array
     */
    public static function getRolesForAccreditationArray()
    {
        return [
            Role::MEMBERS_MAIN => 'Участники (основные)',
            Role::MEMBERS_UNIVERSITIES => 'Участники (опорные вузы)',
            Role::MEMBERS_PUPILS => 'Участники (школьники)'
        ];
    }

    /**
     * Геттер массив ролей
     */
    public static function getRoleArray()
    {
        return [
            Role::ADMINISTRATOR => 'Администратор',
            Role::MEMBERS_MAIN => 'Участники (основные)',
            Role::MEMBERS_UNIVERSITIES => 'Участники (опорные вузы)',
            Role::MEMBERS_PUPILS => 'Участники (школьники)',
            Role::MANAGEMENT => 'Дирекция и организаторы',
            Role::VOLUNTEERS => 'Волонтеры',
            Role::JURY => 'Жюри и эксперты',
            Role::GUESTS => 'Гости и почетные гости',
            Role::MODERATORS => 'Модераторы',
            Role::PRESS => 'Пресса',
            Role::PARTNERS => 'Партнеры',
            Role::SECURITY_SERVICE => 'Служба безопасности',
            Role::TECHNICAL_STAFF => 'Технический персонал',
            Role::ACCREDITATION => 'Аккредитация',
        ];
    }

    /**
     * Геттер названия роли
     *
     * @param $role
     * @return mixed
     */
    public static function getRoleName($role)
    {
        return ArrayHelper::getValue(self::getRoleArray(), $role);
    }

    /**
     * Получить английское название роли по русском названию
     *
     * @param $role_rus
     * @return mixed
     */
    public static function getRoleNameEngByRoleRus($role_rus)
    {
        $roleArray = array_flip(self::getRoleArray()); // поменять местами ключи и значения
        return ArrayHelper::getValue($roleArray, $role_rus);
    }


    /**
     * Геттер название статуса
     *
     * @param $status
     * @return mixed
     */
    public static function getStatusValue($status)
    {
        return ArrayHelper::getValue(self::getStatusArray(), $status);
    }

    /**
     * Геттер массив статусов
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_DELETED => 'Удален',
            self::STATUS_INACTIVE => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активен',
        ];
    }

    /**
     * Получить название для меню в зависимости от роли пользователя
     *
     * @return mixed|string
     */
    public static function getNameMenuItemByActiveUserRole()
    {
        $role = Yii::$app->user->identity->role;

        switch ($role) {
            case Role::MEMBERS_MAIN:
            case Role::MEMBERS_PUPILS:
            case Role::MEMBERS_UNIVERSITIES:
            case Role::ACCREDITATION:
                return 'Участники';
            default:
                return self::getRoleName($role);
        }
    }

    /**
     * Текущий пользователь может работать с командами?
     *
     * @return mixed|string
     */
    public static function canTeamAccess()
    {
        $role = Yii::$app->user->identity->role;

        switch ($role) {
            case Role::MEMBERS_MAIN:
            case Role::MEMBERS_PUPILS:
            case Role::MEMBERS_UNIVERSITIES:
            case Role::ACCREDITATION:
                return true;
            default:
                return false;
        }
    }

}
