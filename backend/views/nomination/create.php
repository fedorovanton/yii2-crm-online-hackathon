<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Nomination\BaseNomination */

$this->title = 'Create Base Nomination';
$this->params['breadcrumbs'][] = ['label' => 'Base Nominations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-nomination-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
