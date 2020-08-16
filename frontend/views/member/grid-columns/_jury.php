<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 23/09/2019
 * Time: 09:35
 */

use \yii\helpers\Html;
use \frontend\models\MemberInfo\MemberInfo;

return [
    'badge_number' => [
        'attribute' => 'badge_number',
        'headerOptions' => ['style' => 'max-width:45px;'],
    ],
    'fio' => [
        'attribute' => 'fio',
        'label' => 'ФИО',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->getLastNameWithInitials();
        }
    ],
    'email',
    'phone' => [
        'attribute' => 'phone',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->getPhoneInIsoFormat();
        }
    ],
    'place_work' => [
        'attribute' => 'place_work',
        'label' => 'Место работы',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->memberJury->place_work;
        }
    ],
    'nomination_id' => [
        'attribute' => 'nomination_id',
        'label' => 'Номинация',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->memberJury->nomination->name;
        }
    ],
    'status' => [
        'attribute' => 'status',
        'label' => 'Статус',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->memberJury->getStatusValue();
        }
    ],
    [
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
    ],
];