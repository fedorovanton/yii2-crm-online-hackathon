<?php
namespace backend\controllers;

use common\components\Role;
use common\models\Region\BaseRegion;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use frontend\models\Team\Team;
use moonland\phpexcel\Excel;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['import-members', 'import-regions', 'logout', 'index'],
                        'allow' => true,
                        'roles' => [Role::ADMINISTRATOR],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'auth';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Меняет символы кириллицу на латиницу
     * P.S. была ошибка в размере одежде. Буква М была русской
     * @param $size
     * @return string
     */
    private static function _changeChar($size)
    {

        switch ($size) {
            case 'М': return 'M';
            case '44': return 'XS';
            case '46': return 'S';
            case '48': return 'M';
            case '50': return 'L';
            case '52': return 'XL';
            case '54':
            case '55':
            case '56':
                return 'XXL';
            case '58':
            case '59':
            case '60':
                return 'XXXL';
            case '64': return 'XXXL'; // для этого размера нет размерного ряда
            default:
                return $size;
        }
    }

    /**
     * Поменять название команды на адекватное
     * @param $name_team
     * @return string
     */
    private static function _changeNameTeam($name_team)
    {
        $name_team = (string)$name_team;

        switch ($name_team) {
            case 'NΣW ÇØᗞÎƝǤ ℂÜŁTᙀᖇΞ': return 'NEW CODING CULTURE';
            default: return $name_team;
        }
    }

    /**
     * Импорт import_main_members.xlsx в БД
     *
     * Под администратором запустить: домен/site/import-members
     *
     * @return bool
     */
    public function actionImportMembers()
    {
        return false;
    }

    /**
     * Импорт Список_субъектов_для_региона_проживания.txt в БД
     *
     * Под администратором запустить: домен/site/import-regions
     *
     * @return bool
     */
    public function actionImportRegions()
    {
        die;
        echo 'Запуск импорта регионов<br/>';
        echo 'Начало: ' . date('Y-m-d H:i:s') . '<br/>';
        $file_path = Yii::getAlias('@backend').'/web/import_files/Список_субъектов_для_региона_проживания.txt';
        $handle = @fopen($file_path, "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $region = new BaseRegion();
                $region->name = trim($buffer);
                $region->updated = date('Y-m-d H:i:s');
                $region->created = date('Y-m-d H:i:s');
                $region->save();
            }
            if (!feof($handle)) {
                echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
            }
            fclose($handle);
        }

        echo 'Конец: ' . date('Y-m-d H:i:s') . '<br/>';
    }
}
