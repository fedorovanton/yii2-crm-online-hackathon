<?php

/**
 * Общий шаблон для большинства страинц
 * @var $this \yii\web\View
 * @var $content string
 * */

use yii\helpers\Html;
use \backend\assets\BackendAsset;
use \common\models\User;

BackendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <!--    <meta name="viewport" content="width=1700">-->
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="dark input-file-dark"></div>
<div class="container-fluid members-anketa">
    <div class="row header-top">
        <div class="header-left">
            <div class="header-left__logo">
                <?= Html::img(Yii::getAlias('@backendURL').'/img/main-logo.png', ['alt' => 'main-logo'])?>
            </div>
        </div>
        <div class="searchbar">
            <div class="searchbar__input">
                <div></div>
                <input type="text" placeholder="Поиск по участникам...">
            </div>
        </div>
        <div class="controls">
            <?= Html::a('Выйти', ['site/logout'], ['class' => 'out', 'data' => ['method' => 'post']])?>
        </div>
    </div>
    <div class="row">
        <div class="sidebar">
            <div class="sidebar__menu">

                <?php
                $link_active_delegations = (Yii::$app->controller->id == 'delegation') ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
                            <svg class="svg-placeholder" ersion="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 54.757 54.757" style="enable-background:new 0 0 54.757 54.757;" xml:space="preserve">
                                <path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952
	                            L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M27.557,26c-3.859,0-7-3.141-7-7s3.141-7,7-7s7,3.141,7,7
	                            S31.416,26,27.557,26z"/>
                            </svg>
                        </div>
                        <span class="sidebar__menu-text">Делегации</span>', ['delegation/index'], ['class' => 'sidebar__menu-item '.$link_active_delegations])
                ?>

                <?php
                $link_active_member_info = (Yii::$app->controller->id == 'member-info') ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
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
                        <span class="sidebar__menu-text">Участники</span>', ['member-info/index'], ['class' => 'sidebar__menu-item '.$link_active_member_info])
                ?>

                <?php
                $link_active_member = ((Yii::$app->controller->id == 'team') || (Yii::$app->controller->id == 'nomination-team')) ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
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
                        <span class="sidebar__menu-text">Команды</span>', ['team/index'], ['class' => 'sidebar__menu-item '.$link_active_member])
                ?>

                <?php
                $link_active_member = (Yii::$app->controller->id == 'nomination') ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
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
                        <span class="sidebar__menu-text">Номинации</span>', ['nomination/index'], ['class' => 'sidebar__menu-item '.$link_active_member])
                ?>

                <?php
                $link_active_member = (Yii::$app->controller->id == 'statistics') ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
                            <svg class="svg-statistics" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 483.8 483.8" style="enable-background:new 0 0 483.8 483.8;" xml:space="preserve">
		                        <path d="M123.2,134H15.7C7,134,0,141,0,149.7v310.6C0,469,7,476,15.7,476h107.5c8.7,0,15.7-7,15.7-15.7V149.7
			                    C139,141,131.9,134,123.2,134z M107.5,444.6H31.4V165.4h76.1V444.6z"/>
                                <path d="M468.1,216.4H360.6c-8.7,0-15.7,7-15.7,15.7v228.2c0,8.7,7,15.7,15.7,15.7h107.5c8.7,0,15.7-7,15.7-15.7V232.1
			                    C483.8,223.4,476.8,216.4,468.1,216.4z M376.3,247.8h24.4l-24.4,24.4V247.8z M376.3,297.2l49.3-49.3h24.9l-74.2,74.2L376.3,297.2
			                    L376.3,297.2z M452.4,444.6h-24.5l24.5-24.5V444.6z M452.4,395.2L403,444.6h-24.9l74.2-74.2v24.8H452.4z M452.4,345.5l-76.1,76.1
			                    v-24.9l76.1-76.1V345.5z M452.4,295.7l-76.1,76.1v-24.9l76.1-76.1V295.7z"/>
                                <path d="M295.7,7.8H188.1c-8.7,0-15.7,7-15.7,15.7v436.8c0,8.7,7,15.7,15.7,15.7h107.5c8.7,0,15.7-7,15.7-15.7V23.5
			                    C311.4,14.8,304.4,7.8,295.7,7.8z"/>
                            </svg>
                        </div>
                        <span class="sidebar__menu-text">Статистика</span>', ['statistics/index'], ['class' => 'sidebar__menu-item '.$link_active_member])
                ?>

                <?php
                $link_active_member = (Yii::$app->controller->id == 'export') ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
                            <svg class="svg-export" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
		                        <path d="M507.296,4.704c-3.36-3.36-8.032-5.056-12.768-4.64L370.08,11.392c-6.176,0.576-11.488,4.672-13.6,10.496
			                    s-0.672,12.384,3.712,16.768l33.952,33.952L224.448,242.272c-6.24,6.24-6.24,16.384,0,22.624l22.624,22.624
			                    c6.272,6.272,16.384,6.272,22.656,0.032l169.696-169.696l33.952,33.952c4.384,4.384,10.912,5.824,16.768,3.744
			                    c2.24-0.832,4.224-2.112,5.856-3.744c2.592-2.592,4.288-6.048,4.608-9.888l11.328-124.448
			                    C512.352,12.736,510.656,8.064,507.296,4.704z"/>
                                <g>
                                    <path d="M448,192v256H64V64h256V0H32C14.304,0,0,14.304,0,32v448c0,17.664,14.304,32,32,32h448c17.664,0,32-14.336,32-32V192H448z
			                    "/>
                                </g>
                                </svg>
                        </div>
                        <span class="sidebar__menu-text">Экспорт</span>', ['export/index'], ['class' => 'sidebar__menu-item '.$link_active_member])
                ?>

                <?php
                $link_active_member = (Yii::$app->controller->id == 'user') ? 'active' : '';
                echo Html::a('<div class="sidebar__menu-icon">
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
                        <span class="sidebar__menu-text">Пользователи</span>', ['user/index'], ['class' => 'sidebar__menu-item '.$link_active_member])
                ?>
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
                        <?= Html::img(Yii::getAlias('@backendURL').'/img/antonovk-logo-gray.png', ['alt' => 'antonovk-logo'])?>
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
