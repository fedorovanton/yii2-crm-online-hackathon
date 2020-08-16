<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:29
 */

namespace frontend\controllers;


use common\components\Role;
use common\models\MemberPupils\BaseMemberPupils;
use common\models\MemberUniversities\BaseMemberUniversities;
use frontend\forms\MemberMainPublicForm;
use frontend\forms\SetNominationForm;
use frontend\models\MemberInfo\MemberInfo;
use frontend\models\MemberMain\MemberMain;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\UploadedFile;

/**
 * Контроллер для работы с публичными анкетами
 *
 * Class ProfileController
 * @package frontend\controllers
 */
class ProfileController extends Controller
{
    public $layout = 'profile';


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
     * Авторизация участника
     * @return string
     */
    public function actionSignIn()
    {
        return $this->redirect('/profile/sign-in-captain');

        $request = Yii::$app->request;

        if ($request->isPost) {

            $phone = $request->post('phone');

            if ($phone) {

                /** @var MemberInfo $member */
                $member = MemberInfo::findMemberByPhone($phone);

                $code = $request->post('code');

                if ($code) {
                    // Форма проверки кода

                    if ($member->checkValidSmsCode($code)) {
                        // Сравнить отправленный SMS код на телефон и введенный в форме
                        return $this->redirect('/profile/form-public?phone='.$phone.'&token='.$member->getToken());
                    } else {
                        Yii::$app->session->setFlash('alert-danger','Вы ввели не правильный код!');
                        // Возвращаем на страницу ввода телефона, если проверка не прошла успешно
                        return $this->redirect('/profile/sign-in');
                    }

                } else {
                    // Форма ввода номера и получения кода проверки

                    if ($member->isValidSmsCode) {
                        // Если уже такой номер телефона проходил авторизацию по коду, то сразу отправляем на анкету
                        return $this->redirect('/profile/form-public?phone='.$phone.'&token='.$member->getToken());
                    } else {
                        // Генерация SMS кода через SMSRU и отправка на номер телефона
                        $member->sendSmsCode();
                        return $this->render('enter-code', [
                            'action' => '/profile/sign-in',
                            'phone' => $phone
                        ]);
                    }

                }
            }
        }

        return $this->render('enter-phone', [
            'action' => '/profile/sign-in'
        ]);
    }

    /**
     * Авторизация для капитана
     * @return string
     */
    public function actionSignInCaptain()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {

            $phone = $request->post('phone');

            if ($phone) {

                /** @var MemberInfo $member */
                $member = MemberInfo::findMemberByPhone($phone);

                if (empty($member)) {
                    Yii::$app->session->setFlash('alert-danger','Участник с указанным номером телефона в списках капитанов команд не найден!');
                    return $this->redirect('/profile/sign-in-captain');
                }

                $isCaptain = false; // флаг Авторизовался капитан

                switch ($member->member_form_scenario) {
                    case Role::MEMBERS_MAIN:
                        if ($member->memberMain->team_status == MemberMain::TEAM_STATUS_CAPTAIN) {
                            $isCaptain = true;
                        }
                        break;
                }

                if (!$isCaptain) {
                    // Возвращаем на страницу ввода телефона, если проверка не прошла успешно
                    Yii::$app->session->setFlash('alert-danger','Вы не являетесь капитаном команды!');
                    return $this->redirect('/profile/sign-in-captain');
                }

                if (!empty($member->memberMain->team->nominationsTeam)) {
                    // Если номинации уже установлены у команды, то возвращаем обртано
                    Yii::$app->session->setFlash('alert-danger','Вы уже указали номинации вашей команде!');
                    return $this->redirect('/profile/sign-in-captain');
                }

                $code = $request->post('code');

                if ($code) {
                    // Форма проверки кода

                    if ($member->checkValidSmsCode($code)) {
                        // Сравнить отправленный SMS код на телефон и введенный в форме
                        return $this->redirect('/profile/set-nomination-captain?phone='.$phone.'&token='.$member->getToken());
                    } else {
                        // Возвращаем на страницу ввода телефона, если проверка не прошла успешно
                        Yii::$app->session->setFlash('alert-danger','Вы ввели не правильный код!');
                        return $this->redirect('/profile/sign-in-captain');
                    }

                } else {
                    // Форма ввода номера телефона для получения кода проверки

                    // Генерация SMS кода через SMSRU и отправка на номер телефона
                    $member->sendSmsCode();

                    return $this->render('enter-code', [
                        'action' => '/profile/sign-in-captain',
                        'phone' => $phone
                    ]);
                }
            }
        }

        return $this->render('enter-phone', [
            'action' => '/profile/sign-in-captain'
        ]);
    }


    /**
     * Заполнение публичной анкеты
     *
     * @return string|\yii\web\Response
     */
    public function actionFormPublic()
    {
        return $this->redirect('/profile/sign-in-captain');

        $request = Yii::$app->request;

        $model = new MemberMainPublicForm();

        if ($request->isGet) {
            $phone = $request->get('phone');
            $token = $request->get('token');

            if (!empty($phone) && !empty($token)) {

                /** @var $member MemberInfo */
                if ($member = MemberInfo::findMemberByPhone($phone)) {
                    $model->fillForm($member);

                    if ($member->validToken($token)) {
                        return $this->render('form-member-public', [
                            'model' => $model
                        ]);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert-danger','Проверка не была пройдена для допуска к анкете!');
            }
        }

        if ($request->isPost) {
            if ($model->load(Yii::$app->request->post())) {

                $model->docFile = UploadedFile::getInstance($model,'docFile');

                if ($model->validate()) {
                    // Сохранение данных по моделям

                    $model->updateDataInModels();
                    return $this->redirect(['success']);

                } else {
                    Yii::$app->session->setFlash('alert-danger','Полученные данные с анкеты содержат ошибки!');
                }
            }
        }

        return $this->redirect('/profile/sign-in');
    }

    /**
     * Форма выбор номинаций капитаном
     *
     * @return string|\yii\web\Response
     */
    public function actionSetNominationCaptain()
    {
        return $this->redirect('/profile/sign-in-captain');

        $request = Yii::$app->request;

        $model = new SetNominationForm();

        if ($request->isGet) {
            $phone = $request->get('phone');
            $token = $request->get('token');

            if (!empty($phone) && !empty($token)) {

                /** @var $member MemberInfo */
                if ($member = MemberInfo::findMemberByPhone($phone)) {
                    if ($member->validToken($token)) {
                        $model->member_info_id = $member->id;
                        return $this->render('form-nomination-public', [
                            'model' => $model,
                        ]);
                    } else {
                        Yii::$app->session->setFlash('alert-danger','Токен не прошел проверку!');
                    }
                } else {
                    Yii::$app->session->setFlash('alert-danger','С данным номером телефона не существует участник!');
                }
            } else {
                Yii::$app->session->setFlash('alert-danger','Проверка не была пройдена для допуска к анкете!');
            }
        }

        if ($request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    // Сохранение данных по моделям
                    if ($model->saveForm()) {
                        return $this->redirect(['success-captain']);
                    } else {
                        // Если номинации уже установлены у команды, то возвращаем обртано
                        Yii::$app->session->setFlash('alert-danger','Вы уже указали номинации вашей команде!');
                        return $this->redirect('/profile/sign-in-captain');
                    }
                } else {
                    Yii::$app->session->setFlash('alert-danger','Содержится ошибка в данных с формы!');
                }
            }
        }

        return $this->redirect('/profile/sign-in-captain');
    }

    /**
     * Успешное заполнение публичной анкеты
     * @return string
     */
    public function actionSuccess()
    {
        return $this->redirect('/profile/sign-in-captain');

        return $this->render('success');
    }

    /**
     * Успешный выбор номинаций капитаном
     * @return string
     */
    public function actionSuccessCaptain()
    {
        return $this->redirect('/profile/sign-in-captain');

        return $this->render('success-captain');
    }
}