<?php

namespace backend\controllers;

use backend\components\ExportInFile;
use common\components\Role;
use common\models\MemberTechnicalStaff\BaseMemberTechnicalStaff;
use frontend\models\MemberMain\MemberMain;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;


/**
 * Class ExportController
 * @package backend\controllers
 */
class ExportController extends Controller
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
        if (Yii::$app->request->get('export')) {
            $export = new ExportInFile();
            $export->run();
        }
        if (Yii::$app->request->get('team_nomination')) {
            $export = new ExportInFile();
            $export->runTeamNomination();
        }

        return $this->render('index');
    }
}
