<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;

$model->rememberMe = true;
?>

<div class="container-fluid">
    <div class="row authorization">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 authorization__left">
            <div class="authorization__left-inner">
                <h1 class="authorization__title">Добро пожаловать!</h1>
                <div class="authorization__wrapper">
                    <div class="authorization__support-block">
                        <div class="support__title">Техническая поддержка</div>
                        <div class="support__row">
                            <div class="support__icon  support__icon--phone">
                                <?= Html::img(Yii::getAlias('@frontendURL').'/img/icons/support-phone.png', ['alt' => 'support-phone'])?>
                            </div>
                            <a href="tel:+1234567890" class="support__text">+7 988 117 44 13</a>
                        </div>
                        <div class="support__row">
                            <div class="support__icon  support__icon--mail">
                                <?= Html::img(Yii::getAlias('@frontendURL').'/img/icons/support-mail.png', ['alt' => 'support-mail'])?>
                            </div>
                            <a class="support__text" href="mailto:email@email.com">sum@antonovk.ru</a>
                        </div>
                        <div class="support__row">
                            <div class="support__icon  support__icon--tg">
                                <?= Html::img(Yii::getAlias('@frontendURL').'/img/icons/support-tg.png', ['alt' => 'support-tg'])?>
                            </div>
                            <div class="support__text">@antonov_k</div>
                        </div>
                        <div class="support__row">
                            <div class="support__icon  support__icon--vk">
                                <?= Html::img(Yii::getAlias('@frontendURL').'/img/icons/support-vk.png', ['alt' => 'support-vk'])?>
                            </div>
                            <a href="https://vk.com/antonov_k" class="support__text">antonov_k</a>
                        </div>
                    </div>

                    <div class="authorization__description">
                        <div class="authorization__description-text">
                            "АИС "Делегация". <br/>
                            Система управления мероприятием. <br/>
                            Разработка Кирилл Антонов
                        </div>
                        <div class="authorization__description-logo">
                            <a href="#">
                                <?= Html::img(Yii::getAlias('@frontendURL').'/img/antonovk-logo.png', ['alt' => 'antonovk-logo'])?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 authorization__right">
            <div class="authorization__right-inner">
                <div class="authorization__form">
                    <div class="authorization__form-logo">
                        <?= Html::img(Yii::getAlias('@frontendURL').'/img/logo-new.png', ['alt' => 'authorization-logo'])?>
                    </div>
                    <div class="authorization__form-title">Вход для организаторов</div>
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <div class="input input__login input__icon">
                            <?= $form->field($model, 'username')->textInput(['class' => '', 'autofocus' => true, 'placeholder' => 'Введите ваш логин'])->label(false) ?>
                        </div>
                        <div class="input input__pass input__icon">
                            <?= $form->field($model, 'password')->passwordInput(['class' => '', 'placeholder' => 'Введите ваш пароль'])->label(false) ?>
                        </div>
                        <?= Html::submitButton('Войти', ['class' => 'authorization__form-button', 'name' => 'login-button']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
