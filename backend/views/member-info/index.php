<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\widgets\PerPageWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberInfo\MemberInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Участники | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="members right-part">
    <div class="members__controls">
        <?= Html::a('<div class="control__text">Добавить участника</div>', ['member-info/create'], ['class' => 'members__control-link members__control--add'])?>
    </div>
    <div class="members__table">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout'=>'
                    <div class="row mb-3">
                        <div class="col-md-7">'.PerPageWidget::widget(['provider' => $dataProvider]).'</div>
                        <div class="col-md-5 text-right">{summary}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">{items}</div>
                    </div>
                ',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'badge_number',
                    //'id',
                    'first_name',
                    'last_name',
                    //'second_name',
                    'phone',
                    //'email:email',
                    //'sms_code',
                    //'sms_result',
                    //'isValidSmsCode',
                    //'token',
                    'user_id',
                    'member_form_scenario',
                    //'created',
                    //'updated',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{dropdown}',
                        'buttons' => [
                            'dropdown' => function ($url,$model) {
                                return '<div class="dropdown">
                                  <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton'.$model->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$model->id.'">
                                    '.Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'dropdown-item']).'
                                    '.Html::a('Служебная информация', ['update', 'id' => $model->id], ['class' => 'dropdown-item']).'
                                    '.Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'dropdown-item', 'data' => [
                                        'confirm' => 'Вы точно уверены, что нужно УДАЛИТЬ данную запись?',
                                        'method' => 'post',
                                    ]]).'
                                  </div>
                                </div>';
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>