<?php

use yii\db\Migration;
use \common\components\Role;
use \yii\helpers\ArrayHelper;


/**
 * Class m190919_132516_insert_nomination
 */
class m190919_132516_insert_nomination extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Номинации для Участников (основные)
        $arrayMain = [
            'updated' => date('Y-m-d H:i:s'),
            'created' => date('Y-m-d H:i:s'),
            'role' => Role::MEMBERS_MAIN
        ];
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Проверка плагиата программного кода'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'AR/VR решения для промышленности'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Платформа переквалификации'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Организация волонтерских проектов'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Умная навигация деталей на производстве '], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Мониторинг трудоустройства выпускников'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Доставка еды к поезду'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Карта покрытия мобильной сети'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Единый удостоверяющий центр электронных подписей'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Веб-портал поощрения волонтерства'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Оцифровка перепеси населения'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Упрощение заполнения портала государственных и муниципальных услуг Республики Татарстан'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Карта перинатальных центров'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Сервис для общественного обсуждения'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Медицинский мониторинг состояния человека '], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Геоинформационная система переработки отходов'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Валидация документов в офлайне'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Оптимизация обратной связи в ЖКХ'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Мониторинг объектов инженерной инфраструктуры'], $arrayMain));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Дефектоскопия трубопроводов'], $arrayMain));

        // Номинации для Участников (опорные вузы)
        $arrayUniversities = [
            'updated' => date('Y-m-d H:i:s'),
            'created' => date('Y-m-d H:i:s'),
            'role' => Role::MEMBERS_UNIVERSITIES
        ];
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Платформа проектирования умного дома'], $arrayUniversities));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Отслеживание деформации железнодорожных путей'], $arrayUniversities));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Мониторинг системы охраны труда'], $arrayUniversities));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Оптимизация дорожных работ'], $arrayUniversities));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Платформа для краудфандинга'], $arrayUniversities));
        $this->insert('nomination', ArrayHelper::merge(['name' => 'Обучающая игра по налогообложению'], $arrayUniversities));

        // Номинации для Участников (школьники)
        $this->insert('nomination', [
            'name' => 'Школьная номинация',
            'updated' => date('Y-m-d H:i:s'),
            'created' => date('Y-m-d H:i:s'),
            'role' => Role::MEMBERS_PUPILS
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190919_132516_insert_nomination cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190919_132516_insert_nomination cannot be reverted.\n";

        return false;
    }
    */
}
