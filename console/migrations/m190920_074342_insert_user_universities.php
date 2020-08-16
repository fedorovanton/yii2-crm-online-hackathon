<?php

use yii\db\Migration;
use \common\models\User;
use \common\components\Role;
use \common\components\Rbac;

/**
 * Class m190920_074342_insert_user_universities
 */
class m190920_074342_insert_user_universities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'description', $this->string(255)." COMMENT 'Описание'");

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

        Rbac::bindUserAndRole($user->getId(), Role::ADMINISTRATOR);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190920_074342_insert_user_universities cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190920_074342_insert_user_universities cannot be reverted.\n";

        return false;
    }
    */
}
