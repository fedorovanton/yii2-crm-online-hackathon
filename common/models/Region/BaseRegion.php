<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 21/09/2019
 * Time: 00:07
 */

namespace common\models\Region;


use yii\helpers\ArrayHelper;


/**
 * Class BaseRegion
 * @package common\models\Region
 */
class BaseRegion extends ModelRegion
{
    /**
     * @return array
     */
    public static function getRegionsArray()
    {
        $regions = self::find()->asArray()->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($regions, 'name', 'name');
    }
}