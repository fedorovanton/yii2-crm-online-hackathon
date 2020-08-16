<?php

/* @var $this yii\web\View */
use \backend\models\User\User;

$this->title = Yii::$app->name;
$identity = Yii::$app->user->identity;

?>

<div class="members right-part">
    <div class="members__breadcrumbs">
        <ul class="breadcrumbs">
            <li class="breadcrumbs__item"><?= User::getRoleName($identity->role) ?></li>
            <li class="breadcrumbs__item"><?= $identity->fio ?></li>
            <li class="breadcrumbs__item"><?= $identity->description ?></li>
        </ul>
    </div>
    <div>
        <h1>Добро пожаловать!</h1>
        <h2 class="text-muted"><?= Yii::$app->name ?></h2>
    </div>
</div>