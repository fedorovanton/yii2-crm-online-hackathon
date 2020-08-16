<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 24/09/2019
 * Time: 09:02
 */

namespace common\widgets;


use yii\base\Widget;

/**
 * Виджет поиска команды на сайте
 *
 * Class SearchTeamWidget
 * @package common\widgets
 */
class SearchTeamWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function run()
    {
        parent::run();
        return $this->render('search-team-widget');
    }
}