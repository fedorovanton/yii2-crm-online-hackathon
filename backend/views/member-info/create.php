<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MemberInfo\BaseMemberInfo */

$this->title = 'Create Base Member Info';
$this->params['breadcrumbs'][] = ['label' => 'Base Member Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-member-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
