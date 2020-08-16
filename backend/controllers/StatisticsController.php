<?php

namespace backend\controllers;

use common\components\Role;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class StatisticsController
 * @package backend\controllers
 */
class StatisticsController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Role::ADMINISTRATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
