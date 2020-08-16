<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\widgets\PerPageWidget;
use \common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\User\DelegationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Делегации | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="members right-part">

    <!--<div class="search-line">
        <input type="search" placeholder="Поиск по регионам..." name="regions-search" class="search-line__input">
    </div>-->

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
            'fio' => [
                'attribute' => 'fio',
                'value' => function ($model) {
                    /** @var $model \backend\models\User\User */
                    return Html::a($model->fio, ['/member-info/index?MemberInfoSearch[user_id]='.$model->id]);
                },
                'format' => 'raw',
            ],
            'description',
            'role' => [
                'attribute' => 'role',
                'value' => function ($model) {
                    /** @var $model \backend\models\User\User */
                    return User::getRoleName($model->role);
                },
                'filter' => User::getRoleArray(),
                'filterOptions' => ['class' => '']
            ],
            [
                'header' => 'Количество участникова',
                'content' => function ($model) {
                    /** @var $model \backend\models\User\User */
                    return $model->numberMembersPerUser();
                }
            ],
        ],
    ]); ?>

    <div class="members__pagination">
        <div class="pagination">
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => ['class' => ''],
                'prevPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="284.929" height="284.929" viewBox="0 0 284.929 284.929"><path fill="#5c5c5c" d="M282.082 76.511l-14.274-14.273c-1.902-1.906-4.093-2.856-6.57-2.856-2.471 0-4.661.95-6.563 2.856L142.466 174.441 30.262 62.241c-1.903-1.906-4.093-2.856-6.567-2.856-2.475 0-4.665.95-6.567 2.856L2.856 76.515C.95 78.417 0 80.607 0 83.082c0 2.473.953 4.663 2.856 6.565l133.043 133.046c1.902 1.903 4.093 2.854 6.567 2.854s4.661-.951 6.562-2.854L282.082 89.647c1.902-1.903 2.847-4.093 2.847-6.565 0-2.475-.945-4.665-2.847-6.571z"/></svg>',
                'nextPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="284.929" height="284.929" viewBox="0 0 284.929 284.929"><path fill="#5c5c5c" d="M282.082 76.511l-14.274-14.273c-1.902-1.906-4.093-2.856-6.57-2.856-2.471 0-4.661.95-6.563 2.856L142.466 174.441 30.262 62.241c-1.903-1.906-4.093-2.856-6.567-2.856-2.475 0-4.665.95-6.567 2.856L2.856 76.515C.95 78.417 0 80.607 0 83.082c0 2.473.953 4.663 2.856 6.565l133.043 133.046c1.902 1.903 4.093 2.854 6.567 2.854s4.661-.951 6.562-2.854L282.082 89.647c1.902-1.903 2.847-4.093 2.847-6.565 0-2.475-.945-4.665-2.847-6.571z"/></svg>',
            ]) ?>
        </div>
    </div>

</div>