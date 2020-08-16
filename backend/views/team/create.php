<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Team\BaseTeam */

$this->title = 'Create Base Team';
$this->params['breadcrumbs'][] = ['label' => 'Base Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-team-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
