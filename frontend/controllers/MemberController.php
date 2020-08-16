<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 12:11
 */

namespace frontend\controllers;


use common\components\Role;
use common\models\MemberInfo\ModelMemberInfo;
use common\models\NominationTeam\BaseNominationTeam;
use common\models\User;
use frontend\forms\MemberForm;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberInfoSearch;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Контроллер для работы с участниками
 *
 * Class MemberController
 * @package frontend\controllers
 */
class MemberController extends Controller
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
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => 'deny',
                        'roles' => [Role::ADMINISTRATOR],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * Список участников
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MemberInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Форма заполнения анкеты любых участников
     *
     * @return mixed
     */
    public function actionCreate()
    {
        // В модель формы передаем роль пользователя, т.к. она соответствует сценариям
        $memberForm = new MemberForm(['scenario' => Yii::$app->user->identity->role]);

        if ($memberForm->load(Yii::$app->request->post())) {
            // Данные из формы были успешно загружены

            // Загружаем документ
            $memberForm->docFile = UploadedFile::getInstance($memberForm, 'docFile');

            // Валидируем
            if ($memberForm->validate()) {

                // Сохраняем данные из формы в моделях
                $memberForm->saveDataInModels();
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $memberForm,
        ]);
    }

    /**
     * Форма редактирования участника
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        /** @var MemberInfo $model */
        $model = $this->findModel($id);

        // В модель формы передаем сценарий или роль пользователя (значения идентичны), чтобы понять какую форму надо выводить
        $memberForm = new MemberForm(['scenario' => $model->member_form_scenario]);

        if ($memberForm->load(Yii::$app->request->post())) {
            // Данные из формы были успешно загружены

            // Загружаем документ
            $memberForm->docFile = UploadedFile::getInstance($memberForm, 'docFile');

            // Валидируем
            if ($memberForm->validate()) {

                // Сохраняем данные из формы в моделях
                $memberForm->saveDataInModels(true);
                return $this->redirect(['index']);
            }
        } else {
            // Заполнить форму данными из моделей
            $memberForm->fillForm($model);
        }

        return $this->render('update', [
            'model' => $memberForm,
        ]);
    }

    /**
     * Удаление участника
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        /** @var MemberInfo $model */
        $model = $this->findModel($id);
        $relation = MemberInfo::findRelationByMemberFormScenario($model->member_form_scenario);

        if ($relation) {
            // Если связь определена с нужной сущность, то удаляем запись из другой таблицы с которой связана
            $model->unlinkAll($relation, true); // Удалить связанные записи из указанной сущности с участниками

            // Удаляется инфа об участнике
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Поиск участника
     *
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws ForbiddenHttpException
     */
    protected function findModel($id)
    {
        $user = Yii::$app->user->identity;

        if ($user->role == Role::MEMBERS_MAIN) {
            // Основные участники доступны для всех пользователей с ролью Участники (Основные)
            $model = MemberInfo::find()
                ->where(['id' => $id])
                ->andWhere(['member_form_scenario' => $user->role])
                ->one();
        } elseif ($user->role == Role::ACCREDITATION) {
            // Все участники доступны для пользователей с ролью Аккредитация
            $model = MemberInfo::find()
                ->where(['id' => $id])
                ->one();
        } else {
            // Другие участники доступны для пользователей, которые их создали с соответствуйющей ролью
            $model = MemberInfo::find()
                ->where(['id' => $id])
                ->andWhere(['user_id' => $user->getId()])
                ->andWhere(['member_form_scenario' => $user->role])
                ->one();
        }

        if ($model !== null) {
            return $model;
        }

//        throw new NotFoundHttpException('Доступ к данному участнику запрещен.');
        throw new ForbiddenHttpException('Доступ к данному участнику запрещен.');
    }

    /**
     * Поиск через ajax совпадения участников по ФИО для select2 (поиск в хэдере)
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionMemberList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {

            $user = Yii::$app->user->identity;

            if ($user->role == Role::MEMBERS_MAIN) {
                // Основные участники доступны для всех пользователей с ролью Участники (Основные)
                $data = MemberInfo::find()
                    ->select('id, last_name, first_name, second_name')
                    ->where(['like', 'last_name', $q])
                    ->andWhere(['member_form_scenario' => $user->role])
                    ->limit(30)
                    ->asArray()
                    ->all();
            } else {
                // Другие участники доступны для пользователей, которые их создали с соответствуйющей ролью
                $data = MemberInfo::find()
                    ->select('id, last_name, first_name, second_name')
                    ->where(['like', 'last_name', $q])
                    ->andWhere(['member_form_scenario' => $user->role])
                    ->andWhere(['user_id' => $user->getId()])
                    ->limit(30)
                    ->asArray()
                    ->all();
            }

            $result = [];
            foreach ($data as $item) {
                $result[] = [
                    'id' => $item['id'],
                    'text' => $item['last_name']. ' ' . $item['first_name'] . ' ' . $item['second_name']
                ];
            }
            $out['results'] = $result;
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => MemberInfo::findOne($id)->last_name];
        }

        return $out;
    }

    /**
     * Экшен выдачи бейджа
     *
     * @param $issued
     * @param $id
     * @return Response
     */
    public function actionBadge($issued, $id)
    {
        /** @var MemberInfo $model */
        $model = $this->findModel($id);
        if ($model) {
            $model->setBadgeIssued($issued);
            $model->setUpdated();
            $model->update();
        }
        return $this->redirect(['index']);
    }
}