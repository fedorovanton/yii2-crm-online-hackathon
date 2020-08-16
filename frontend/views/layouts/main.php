<?php

/**
 * Общий шаблон для большинства страинц
 * @var $this \yii\web\View
 * @var $content string
 * */

use yii\helpers\Html;
use \frontend\assets\FrontendAsset;
use \common\models\User;

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=1700">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="dark input-file-dark"></div>
<div class="container-fluid <?= (Yii::$app->controller->action->id == 'index') ? '' : 'members-anketa' ?>">
    <div class="row header-top">
        <div class="header-left">
            <div class="header-left__logo">
                <?= Html::img(Yii::getAlias('@frontendURL').'/img/main-logo.png', ['alt' => 'main-logo'])?>
            </div>
        </div>

        <?php if (Yii::$app->controller->id == 'member'): ?>
            <?= \common\widgets\SearchMemberWidget::widget() ?>
        <?php endif; ?>

        <?php if (Yii::$app->controller->id == 'team'): ?>
            <?= \common\widgets\SearchTeamWidget::widget() ?>
        <?php endif; ?>

        <div class="controls">
            <?= Html::a('Выйти', ['site/logout'], ['class' => 'out'])?>
        </div>
    </div>
    <div class="row">
        <div class="sidebar">
            <div class="sidebar__menu">

                <?php
                $link_active_member = (Yii::$app->controller->id == 'member') ? 'active' : '';
                echo Html::a('
                    <div class="sidebar__menu-icon">
                        <svg class="svg-users" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 80.13 80.13" style="enable-background:new 0 0 80.13 80.13;" xml:space="preserve">
                                <g>
                                    <path d="M48.355,17.922c3.705,2.323,6.303,6.254,6.776,10.817c1.511,0.706,3.188,1.112,4.966,1.112
                                c6.491,0,11.752-5.261,11.752-11.751c0-6.491-5.261-11.752-11.752-11.752C53.668,6.35,48.453,11.517,48.355,17.922z M40.656,41.984
                                c6.491,0,11.752-5.262,11.752-11.752s-5.262-11.751-11.752-11.751c-6.49,0-11.754,5.262-11.754,11.752S34.166,41.984,40.656,41.984
                                z M45.641,42.785h-9.972c-8.297,0-15.047,6.751-15.047,15.048v12.195l0.031,0.191l0.84,0.263
                                c7.918,2.474,14.797,3.299,20.459,3.299c11.059,0,17.469-3.153,17.864-3.354l0.785-0.397h0.084V57.833
                                C60.688,49.536,53.938,42.785,45.641,42.785z M65.084,30.653h-9.895c-0.107,3.959-1.797,7.524-4.47,10.088
                                c7.375,2.193,12.771,9.032,12.771,17.11v3.758c9.77-0.358,15.4-3.127,15.771-3.313l0.785-0.398h0.084V45.699
                                C80.13,37.403,73.38,30.653,65.084,30.653z M20.035,29.853c2.299,0,4.438-0.671,6.25-1.814c0.576-3.757,2.59-7.04,5.467-9.276
                                c0.012-0.22,0.033-0.438,0.033-0.66c0-6.491-5.262-11.752-11.75-11.752c-6.492,0-11.752,5.261-11.752,11.752
                                C8.283,24.591,13.543,29.853,20.035,29.853z M30.589,40.741c-2.66-2.551-4.344-6.097-4.467-10.032
                                c-0.367-0.027-0.73-0.056-1.104-0.056h-9.971C6.75,30.653,0,37.403,0,45.699v12.197l0.031,0.188l0.84,0.265
                                c6.352,1.983,12.021,2.897,16.945,3.185v-3.683C17.818,49.773,23.212,42.936,30.589,40.741z"/>
                                </g>
                                </svg>
                    </div>
                    <span class="sidebar__menu-text">'.User::getNameMenuItemByActiveUserRole().'</span>', ['member/index'], ['class' => 'sidebar__menu-item '.$link_active_member])?>

                <?php if (User::canTeamAccess()): ?>

                <?php
                $link_active_team = (Yii::$app->controller->id == 'team') ? 'active' : '';
                echo Html::a('
                    <div class="sidebar__menu-icon">
                        <svg class="svg-list" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 24 24">
                            <g>
                                <path d="M3,2H1C0.4,2,0,2.4,0,3v2c0,0.6,0.4,1,1,1h2c0.6,0,1-0.4,1-1V3C4,2.4,3.6,2,3,2z"/>
                                <path d="m3,10h-2c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h2c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                                <path d="m3,18h-2c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h2c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                                <path d="M23,2H9C8.4,2,8,2.4,8,3v2c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V3C24,2.4,23.6,2,23,2z"/>
                                <path d="m23,10h-14c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h14c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                                <path d="m23,18h-14c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h14c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar__menu-text">Команды</span>', ['team/index'], ['class' => 'sidebar__menu-item '.$link_active_team])?>
                <?php endif; ?>
            </div>

            <?= $this->render('_sibebar-menu-support') ?>

            <div class="authorization__description">
                <div class="authorization__description-text">
                    "АИС "Делегация". <br/>
                    Система управления мероприятием. <br/>
                    Разработка Кирилл Антонов
                </div>
                <div class="authorization__description-logo">
                    <a href="#">
                        <?= Html::img(Yii::getAlias('@frontendURL').'/img/antonovk-logo-gray.png', ['alt' => 'antonovk-logo'])?>
                    </a>
                </div>
            </div>

        </div>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
