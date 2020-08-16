<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 17/09/2019
 * Time: 16:06
 */

namespace common\models\Nomination;


use yii\helpers\ArrayHelper;

/**
 * Class BaseNomination
 * @package common\models\Nomination
 */
class BaseNomination extends ModelNomination
{
    /**
     * Геттер массив номинаций
     *
     * @param null $role
     * @return array
     */
    public static function getNominationArray($role = null)
    {
        if (empty($role)) {
            $nominations = self::find()->all();
        } else {
            $nominations = self::find()->where(['role' => $role])->all();
        }

        return ArrayHelper::map($nominations, 'id', 'name');
    }

    public function getNominationValue()
    {

    }
}