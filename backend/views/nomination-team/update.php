<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NominationTeam\BaseNominationTeam */

$this->title = 'Update Base Nomination Team: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Base Nomination Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="base-nomination-team-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
