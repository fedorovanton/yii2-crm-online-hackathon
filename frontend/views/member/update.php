<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberInfo\ModelMemberInfo */

$this->title = 'Редактирование участника: ' . $model->last_name . ' ' . $model->first_name;
//$this->params['breadcrumbs'][] = ['label' => 'Model Member Infos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
