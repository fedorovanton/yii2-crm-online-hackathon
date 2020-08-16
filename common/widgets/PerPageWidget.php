<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 25/09/2019
 * Time: 08:16
 */

namespace common\widgets;


use yii\base\Widget;

/**
 * Class PerPageWidget
 * @package app\widgets
 *
 * @property \yii\data\ActiveDataProvider $provider
 * @property array $perPageList
 * @property integer $pageSize
 */
class PerPageWidget extends Widget
{
    public $provider;
    public $perPageList = [5, 10, 25, 50, 100];
    public $pageSize;

    public function init()
    {
        parent::init();

        $this->pageSize = $this->provider->getPagination()->getPageSize();
        $this->pageSize = ($this->pageSize == 20) ? 25 : $this->pageSize;
    }

    public function run()
    {
        return $this->render('per-page-widget', [
            'perPageList' => $this->perPageList,
            'pageSize' => $this->pageSize
        ]);
    }
}