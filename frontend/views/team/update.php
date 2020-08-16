<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Team\Team */

$this->title = 'Редактирование команды:  | ' . Yii::$app->name;
//$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
