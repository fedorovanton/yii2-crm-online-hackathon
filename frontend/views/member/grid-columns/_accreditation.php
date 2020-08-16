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
use \common\components\Role;


return [
    'badge_number' => [
        'attribute' => 'badge_number',
    ],
    'badge_issued' => [
        'attribute' => 'badge_issued',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            $html = $model->getBadgeIssuedValue();
            if ($model->badge_issued) {
                $html .= Html::a('Отменить <i class="fas fa-user-times"></i>', ['badge', 'issued' => MemberInfo::BADGE_NOT_ISSUED, 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-secondary', 'title' => 'Отменить выдачу бейджа']);
            } else {
                $html .= Html::a('Выдать <i class="fas fa-user-tag"></i>', ['badge', 'issued' => MemberInfo::BADGE_YES_ISSUED, 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-success', 'title' => 'Выдать бейдж']);
            }
            return $html;
        },
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'filter' => MemberInfo::getBadgeIssuedStatusArray(),
    ],
    'member_form_scenario' => [
        'label' => 'Категория',
        'attribute' => 'member_form_scenario',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return \common\models\User::getRoleName($model->member_form_scenario);
        },
        'filter' => \common\models\User::getRolesForAccreditationArray(),
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
            switch ($model->member_form_scenario) {
                case Role::MEMBERS_MAIN:
                    $relation = 'memberMain';
                    break;
                case Role::MEMBERS_UNIVERSITIES:
                    $relation = 'memberUniversities';
                    break;
                case Role::MEMBERS_PUPILS:
                    $relation = 'memberPupils';
                    break;
                default:
                    return '---';
            }
            return $model->$relation->region_residence;
        }
    ],
    'team_id' => [
        'label' => 'Команда',
        'attribute' => 'team_id',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            switch ($model->member_form_scenario) {
                case Role::MEMBERS_MAIN:
                    $relation = 'memberMain';
                    break;
                case Role::MEMBERS_UNIVERSITIES:
                    $relation = 'memberUniversities';
                    break;
                case Role::MEMBERS_PUPILS:
                    $relation = 'memberPupils';
                    break;
                default:
                    return '---';
            }
            if ($model->$relation->team) {
                return $model->$relation->team->name;
            } else {
                return 'Не определена';
            }
        }
    ],
    'team_status' => [
        'label' => 'Статус участника',
        'attribute' => 'team_status',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            switch ($model->member_form_scenario) {
                case Role::MEMBERS_MAIN:
                    $relation = 'memberMain';
                    break;
                case Role::MEMBERS_UNIVERSITIES:
                    $relation = 'memberUniversities';
                    break;
                case Role::MEMBERS_PUPILS:
                    $relation = 'memberPupils';
                    break;
                default:
                    return '---';
            }
            return $model->$relation->getTeamStatusName();
        }
    ],
    'check_status' => [
        'attribute' => 'check_status',
        'value' => function ($model) {
            /** @var $model \frontend\models\MemberInfo\MemberInfo */
            return $model->getCheckStatusValue();
        }
    ],
];