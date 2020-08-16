<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \backend\models\User\User;
use \yii\widgets\LinkPager;
use \common\widgets\PerPageWidget;
use \yii\helpers\ArrayHelper;
use \common\components\Role;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\Team\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список команд';
$this->params['breadcrumbs'][] = $this->title;
$identity = Yii::$app->user->identity;

$gridColumns = [
    'name:ntext',
    'city_regional_stage',
    'user_create_role' => [
        'attribute' => 'user_create_role',
        'label' => 'Категория',
        'value' => function ($model) {
            /** @var $model \frontend\models\Team\Team */
            return User::getRoleName($model->user_create_role);
        },
        'filter' => User::getRolesForAccreditationArray(),
    ],
];

// Пользователям с ролью Аккредитация запрещено Редактировать/Удалять записи
if ($identity->role != Role::ACCREDITATION) {
    ArrayHelper::merge($gridColumns, [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{dropdown}',
        'buttons' => [
            'dropdown' => function ($url,$model) {
                return '<div class="dropdown">
                                  <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton'.$model->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$model->id.'">
                                    '.Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'dropdown-item']).'
                                    '.Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'dropdown-item', 'data' => [
                        'confirm' => 'Вы точно уверены, что нужно УДАЛИТЬ данную запись?',
                        'method' => 'post',
                    ]]).'
                                  </div>
                                </div>';
            },
        ],
    ]);
}
?>
<div class="members right-part">
    <div class="members__breadcrumbs">
        <ul class="breadcrumbs">
            <li class="breadcrumbs__item"><?= User::getRoleName($identity->role) ?></li>
            <li class="breadcrumbs__item"><?= $identity->fio ?></li>
            <?php if(!empty($identity->description)): ?>
                <li class="breadcrumbs__item"><?= $identity->description ?></li>
            <?php endif; ?>
        </ul>
    </div>

    <?php if ($identity->role != Role::ACCREDITATION): ?>
        <div class="members__controls">
            <?= Html::a('<div class="control__text">Добавить команду</div>', ['team/create'], ['class' => 'members__control-link members__control--add'])?>
        </div>
    <?php endif; ?>

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
                'columns' => $gridColumns,
            ]); ?>

            <div class="members__pagination">
                <div class="pagination">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => ''],
                        'prevPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="284.929" height="284.929" viewBox="0 0 284.929 284.929"><path fill="#5c5c5c" d="M282.082 76.511l-14.274-14.273c-1.902-1.906-4.093-2.856-6.57-2.856-2.471 0-4.661.95-6.563 2.856L142.466 174.441 30.262 62.241c-1.903-1.906-4.093-2.856-6.567-2.856-2.475 0-4.665.95-6.567 2.856L2.856 76.515C.95 78.417 0 80.607 0 83.082c0 2.473.953 4.663 2.856 6.565l133.043 133.046c1.902 1.903 4.093 2.854 6.567 2.854s4.661-.951 6.562-2.854L282.082 89.647c1.902-1.903 2.847-4.093 2.847-6.565 0-2.475-.945-4.665-2.847-6.571z"/></svg>',
                        'nextPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="284.929" height="284.929" viewBox="0 0 284.929 284.929"><path fill="#5c5c5c" d="M282.082 76.511l-14.274-14.273c-1.902-1.906-4.093-2.856-6.57-2.856-2.471 0-4.661.95-6.563 2.856L142.466 174.441 30.262 62.241c-1.903-1.906-4.093-2.856-6.567-2.856-2.475 0-4.665.95-6.567 2.856L2.856 76.515C.95 78.417 0 80.607 0 83.082c0 2.473.953 4.663 2.856 6.565l133.043 133.046c1.902 1.903 4.093 2.854 6.567 2.854s4.661-.951 6.562-2.854L282.082 89.647c1.902-1.903 2.847-4.093 2.847-6.565 0-2.475-.945-4.665-2.847-6.571z"/></svg>',
                    ]) ?>
                </div>
            </div>

        </div>
    </div>
</div>