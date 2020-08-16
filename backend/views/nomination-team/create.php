<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NominationTeam\BaseNominationTeam */

$this->title = 'Create Base Nomination Team';
$this->params['breadcrumbs'][] = ['label' => 'Base Nomination Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-nomination-team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
