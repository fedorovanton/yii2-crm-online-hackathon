<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Team\Team */

$this->title = 'Добавление команды | ' . Yii::$app->name;
//$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
