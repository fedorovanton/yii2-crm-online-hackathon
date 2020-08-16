<?php

namespace frontend\controllers;

use common\components\Role;
use common\models\MemberMain\BaseMemberMain;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberUniversities\BaseMemberUniversities;
use frontend\forms\TeamForm;
use frontend\models\MemberInfo\MemberInfo;
use Yii;
use frontend\models\Team\Team;
use frontend\models\Team\TeamSearch;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends Controller
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
                        'allow' => false,
                        'roles' => [Role::ADMINISTRATOR],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Team models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание команды
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // В модель формы передаем роль пользователя, т.к. она соответствует сценариям
        $teamForm = new TeamForm(['scenario' => Yii::$app->user->identity->role]);

        if ($teamForm->load(Yii::$app->request->post())) {
            // Данные из формы были успешно загружены

            // Валидируем
            if ($teamForm->validate()) {

                // Сохраняем данные из формы в моделях
                $teamForm->saveDataInModels();
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $teamForm,
        ]);
    }

    /**
     * Редактирование команды
     *
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var Team $model */
        $model = $this->findModel($id);

        // В модель формы передаем сценарий или роль пользователя (значения идентичны), чтобы понять какую форму надо выводить
        $teamForm = new TeamForm(['scenario' => $model->user_create_role]);

        if ($teamForm->load(Yii::$app->request->post())) {
            // Данные из формы были успешно загружены

            // Валидируем
            if ($teamForm->validate()) {

                // Сохраняем данные из формы в моделях
                $teamForm->saveDataInModels(true);
                return $this->redirect(['index']);
            }
        } else {
            // Заполнить форму данными из моделей
            $teamForm->fillForm($model);
        }

        return $this->render('update', [
            'model' => $teamForm,
        ]);
    }

    /**
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Удаление номинаций у команды
        $nominations_team = $model->nominationsTeam;
        if ($nominations_team) {
            foreach ($nominations_team as $nomination_team) {
                $nomination_team->delete();
            }
        }

        // Открепление участников от команды
        switch ($model->user_create_role) {
            case Role::MEMBERS_MAIN:
                $members = $model->membersMain;
                if ($members) {
                    foreach ($members as $member) {
                        /** @var BaseMemberMain $member */
                        $member->setTeamId(null);
                        $member->setMemberPosition(null);
                        $member->setUpdated();
                        $member->update();
                    }
                }
                break;
            case Role::MEMBERS_UNIVERSITIES:
                $members = $model->membersUniversities;
                if ($members) {
                    foreach ($members as $member) {
                        /** @var BaseMemberUniversities $member */
                        $member->setTeamId(null);
                        $member->setMemberPosition(null);
                        $member->setUpdated();
                        $member->update();
                    }
                }
                break;
            case Role::MEMBERS_PUPILS:
                $members = $model->membersPupils;
                if ($members) {
                    foreach ($members as $member) {
                        /** @var BaseMemberPupils $member */
                        $member->setTeamId(null);
                        $member->setMemberPosition(null);
                        $member->setUpdated();
                        $member->update();
                    }
                }
                break;
        }

        // Удаление самой команды
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Найти
     * @param $id
     * @return array|Team|null
     * @throws ForbiddenHttpException
     */
    protected function findModel($id)
    {
        $user = Yii::$app->user->identity;

        if ($user->role == Role::MEMBERS_MAIN) {

            // Команды основных участников доступны для всех пользователей с ролью Участники (Основные)
            $model = Team::find()
                ->where(['id' => $id])
                ->andWhere(['user_create_role' => $user->role])
                ->one();

        } else {

            // Другие команды участников (школьники или опорные вузы) доступны для пользователей, которые их создали
            $model = Team::find()
                ->where(['id' => $id])
                ->andWhere(['user_id' => $user->getId()])
                ->andWhere(['user_create_role' => $user->role])
                ->one();

        }

        if ($model !== null) {
            return $model;
        }

        //throw new NotFoundHttpException('Доступ к данному участнику запрещен.');
        throw new ForbiddenHttpException('Доступ к данной команде запрещен.');
    }

    /**
     * Поиск через ajax совпадения команд по названию для select2 (поиск в хэдере)
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionTeamList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if (!is_null($q)) {

            $user = Yii::$app->user->identity;

            if ($user->role == Role::MEMBERS_MAIN) {
                // Основные участники доступны для всех пользователей с ролью Участники (Основные)
                $data = Team::find()
                    ->select('id, name')
                    ->andWhere(['like', 'name', $q])
                    ->andWhere(['user_create_role' => $user->role])
                    ->limit(30)
                    ->asArray()
                    ->all();
            } else {
                // Другие участники доступны для пользователей, которые их создали с соответствуйющей ролью
                $data = Team::find()
                    ->select('id, name')
                    ->andWhere(['like', 'name', $q])
                    ->andWhere(['user_create_role' => $user->role])
                    ->andWhere(['user_id' => $user->getId()])
                    ->limit(30)
                    ->asArray()
                    ->all();
            }

            $result = [];
            foreach ($data as $item) {
                $result[] = [
                    'id' => $item['id'],
                    'text' => $item['name']
                ];
            }
            $out['results'] = $result;
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Team::findOne($id)->name];
        }

        return $out;
    }
}
