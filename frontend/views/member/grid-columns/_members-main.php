<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 23/09/2019
 * Time: 09:35
 */

use \yii\helpers\Html;
use \common\models\NominationTeam\BaseNominationTeam;
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
    'region_residence' => [
        'label' => 'Регион проживания',
        'attribute' => 'region_residence',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->memberMain->region_residence;
        }
    ],
    'team_id' => [
        'label' => 'Команда',
        'attribute' => 'team_id',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            if ($model->memberMain->team) {
                return $model->memberMain->team->name;
            } else {
                return 'Не определена';
            }
        }
    ],
    /*[
        'label' => 'Итоговая номинация',
        'value' => function ($model) {
            // есть ли команда у участника
            $team = $model->memberMain->team;
            if ($team) {
                // Есть ли номинация у команды
                if ($team->nominationsTeam) {
                    foreach ($team->nominationsTeam as $nomination_team) {
                        // ищем в цикле Итоговую номинацию
                        if ($nomination_team->priority == BaseNominationTeam::PRIORITY_FINAL) {
                            return $nomination_team->nomination->name;
                        }
                    }
                }
            }
            return 'Не определена';
        }
    ],*/
    'team_status' => [
        'label' => 'Статус участника',
        'attribute' => 'team_status',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->memberMain->getTeamStatusName();
        }
    ],
    // todo тут ошибка на продакшене выскакивает
    'check_status' => [
        'attribute' => 'check_status',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->getCheckStatusValue();
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