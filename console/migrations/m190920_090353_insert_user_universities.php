<?php

use yii\db\Migration;
use \common\models\User;
use \common\components\Role;
use \common\components\Rbac;
/**
 * Class m190920_090353_insert_user_universities
 */
class m190920_090353_insert_user_universities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('user', ['username' => 'temp_nikshinain@mail.ru']);

        // Никишина Ирина Николаевна
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Никишина Ирина Николаевна';
        $user->phone = '89031506151';
        $user->username = $user->email = 'temp_nikshinain@mail.ru';
        $user->description = 'Москвоский политехнический университет';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Чудова Юлия Владимировна
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Чудова Юлия Владимировна';
        $user->phone = '89161716784';
        $user->username = $user->email = 'chudovaYV@mpei.ru';
        $user->description = 'Национальный исследовательский университет "МЭИ"';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Торкунова Юлия Владимировна
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Торкунова Юлия Владимировна';
        $user->phone = '89050224800';
        $user->username = $user->email = 'torkynova@mail.ru';
        $user->description = 'Казанский государственный энергетический университет';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Гераськин Алексей Сергеевич
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Гераськин Алексей Сергеевич';
        $user->phone = '89053816366';
        $user->username = $user->email = 'GeraskinAS@mail.ru';
        $user->description = 'Саратовский государственный университет им. Н.Г. Чернышевского';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Далинина Ольга Николаевна
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Далинина Ольга Николаевна';
        $user->phone = '88452998715';
        $user->username = $user->email = 'olga@sstu.ru';
        $user->description = 'Саратовский государственный технический университет имени Гагарина Ю.А.';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Гущина Оксана Михайловн
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Гущина Оксана Михайловн';
        $user->phone = '89376613145';
        $user->username = $user->email = 'ok_mih@mail.ru';
        $user->description = 'Тольяттинский государственный университет';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Шулежко Олеся Владимировна
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Шулежко Олеся Владимировна';
        $user->phone = '89278098917';
        $user->username = $user->email = 'lesi_uln@mail.ru';
        $user->description = 'Ульяновский государственный педагогический университет им. И.Н. Ульянова';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Миронов Владимир Валерьевич
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Миронов Владимир Валерьевич';
        $user->phone = '89087191111';
        $user->username = $user->email = 'mironov_v@list.ru';
        $user->description = 'Сыктывкарский государственный университет им. Питирима Сорокина';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // NAME
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Щур Семён Юрьевич';
        $user->phone = '89046343039';
        $user->username = $user->email = 'semmyon@yandex.ru';
        $user->description = 'Санкт-Петербургский политехнический университет Петра Великого (СПбПУ)';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Красников Степан Альбертович
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Красников Степан Альбертович';
        $user->phone = '89037198385';
        $user->username = $user->email = 'skrasnikov@gmail.com';
        $user->description = 'Московский государственный университет технологий и управления имени К.Г. Разумовского ';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Тогузов Сергей Александрович
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Тогузов Сергей Александрович';
        $user->phone = '89278577385';
        $user->username = $user->email = 'polytehnik@yandex.ru';
        $user->description = 'Чебоксарский институт (филиал) Московского политехнического университета';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);

        // Галимова Екатерина Валерьевна
        $password = Yii::$app->security->generateRandomString(8);
        $user = new User();
        $user->status = User::STATUS_ACTIVE;
        $user->fio = 'Галимова Екатерина Валерьевна';
        $user->phone = '89992251771';
        $user->username = $user->email = 'katzhukova@gmail.com';
        $user->description = 'Кировское областное государственное профессиональное образовательное бюджетное учреждение “Вятско-Полянский механический техникум”';
        $user->password_temp = $password;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->role = Role::MEMBERS_UNIVERSITIES;
        $user->created = date("Y-m-d H:i:s");
        $user->updated = date("Y-m-d H:i:s");
        $user->insert(false);
        Rbac::bindUserAndRole($user->getId(), Role::MEMBERS_UNIVERSITIES);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190920_090353_insert_user_universities cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190920_090353_insert_user_universities cannot be reverted.\n";

        return false;
    }
    */
}
