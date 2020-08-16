<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberInfo\BaseMemberInfo */

$this->title = 'Update Base Member Info: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Base Member Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="base-member-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
