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
 * Виджет поиска участника на сайте
 *
 * Class SearchMemberWidget
 * @package common\widgets
 */
class SearchMemberWidget extends Widget
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
        return $this->render('search-member-widget');
    }
}