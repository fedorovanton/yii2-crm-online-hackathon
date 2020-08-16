<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MemberInfo\BaseMemberInfo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Base Member Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="base-member-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'photo',
            'first_name',
            'last_name',
            'second_name',
            'phone',
            'email:email',
            'badge_number',
            'sms_code',
            'sms_result',
            'isValidSmsCode',
            'token',
            'user_id',
            'member_form_scenario',
            'created',
            'updated',
        ],
    ]) ?>

</div>
