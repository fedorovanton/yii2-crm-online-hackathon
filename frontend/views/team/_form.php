<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Nomination\BaseNomination;
use \frontend\forms\TeamForm;
use \frontend\models\MemberInfo\MemberInfo;
use \kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model TeamForm */
/* @var $form yii\widgets\ActiveForm */

/**
 * Вьюха: форма создание/редактирования команды
 */

/**
 * по user_id определяем к кому принадлежит команда
 * по user_create_role определяем сущность, в которой создаются команды
 */
$user = Yii::$app->user->identity;

// Дефолтные значения
$model->user_id = (empty($model->user_id)) ? $user->getId() : $model->user_id;
$model->user_create_role = (empty($model->user_create_role)) ? $user->role : $model->user_create_role;

// Массив номинаций
$nominationsList = BaseNomination::getNominationArray($user->role);

// Массив участников
if (!empty($model->name)) {
    // Редактирование команды
    $membersList = MemberInfo::getMembersArray($user, true, [
        $model->member_info_id_1,
        $model->member_info_id_2,
        $model->member_info_id_3,
        $model->member_info_id_4,
        $model->member_info_id_5
    ]);
} else {
    // Создание команды
    $membersList = MemberInfo::getMembersArray($user, true);
}

$style = <<<CSS
/**
 * Скрыть непонятный квадратик, который появляется под select2
 */
.field-teamform-member_info_id_1 a.chosen-single,
.field-teamform-member_info_id_2 a.chosen-single,
.field-teamform-member_info_id_3 a.chosen-single,
.field-teamform-member_info_id_4 a.chosen-single,
.field-teamform-member_info_id_5 a.chosen-single,
.field-teamform-nomination_id_1 a.chosen-single,
.field-teamform-nomination_id_2 a.chosen-single,
.field-teamform-nomination_id_3 a.chosen-single,
 .field-teamform-nomination_id_final a.chosen-single {
    display: none !important;
}
CSS;
$this->registerCss($style);

/*$javascript = <<<JS
$( document ).ready(function() {

})
JS;
$this->registerJs($javascript);*/
?>

<div class="members right-part">
    <div class="info-text">
        <span>*</span> - поля, обязательные для заполнения
    </div>

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'input-error'
    ]); ?>
    <?= $form->field($model, 'team_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'user_create_role')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-lg-6 right-part__half">
            <div class="input">
                <?= $form->field($model, 'name')->textInput() ?>
            </div>

            <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                <div class="input">
                    <?= $form->field($model, 'city_regional_stage')->textInput(['maxlength' => true]) ?>
                </div>
            <?php endif; ?>

            <hr>

            <div class="input-big-title">Номинации</div>

            <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                <div class="input">
                    <?php //echo $form->field($model, 'nomination_id_1')->dropDownList($nominationsList)->hint('Необходимо выбрать разные приоритеты для разных номинаций.', ['class' => 'small text-muted']) ?>
                    <?php echo $form->field($model, 'nomination_id_1')->widget(Select2::classname(), [
                        'data' => $nominationsList,
                        'bsVersion' => 4,
                        'options' => ['placeholder' => 'Выберите приоритет 1...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="input">
                    <?php //echo $form->field($model, 'nomination_id_2')->dropDownList($nominationsList)->hint('Необходимо выбрать разные приоритеты для разных номинаций.', ['class' => 'small text-muted']) ?>
                    <?php echo $form->field($model, 'nomination_id_2')->widget(Select2::classname(), [
                        'data' => $nominationsList,
                        'bsVersion' => 4,
                        'options' => ['placeholder' => 'Выберите приоритет 2...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="input">
                    <?php //echo $form->field($model, 'nomination_id_3')->dropDownList($nominationsList)->hint('Необходимо выбрать разные приоритеты для разных номинаций.', ['class' => 'small text-muted']) ?>
                    <?php echo $form->field($model, 'nomination_id_3')->widget(Select2::classname(), [
                        'data' => $nominationsList,
                        'bsVersion' => 4,
                        'options' => ['placeholder' => 'Выберите приоритет 3...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            <?php endif; ?>

            <div class="input">
                <?php
                switch($model->scenario) {
                    case TeamForm::SCENARIO_MEMBER_MAIN:
                        $isDisabled_nominationFinal = true;
                        $prompt = 'Номинация будет определена позже';
                        break;
                    case TeamForm::SCENARIO_MEMBERS_UNIVERSITIES:
                        $isDisabled_nominationFinal = false;
                        $prompt = 'Выберите номинацию...';
                        break;
                    case TeamForm::SCENARIO_MEMBERS_PUPILS:
                        $isDisabled_nominationFinal = true;
                        $prompt = 'Школьная номинация';
                        break;
                    default:
                        // todo хз почему сюда попадает
                        $isDisabled_nominationFinal = true;
                        $prompt = 'Значение...';
                        break;
                }

                ?>
                <?php //echo $form->field($model, 'nomination_id_final')->dropDownList($nominationsList, ['disabled' => $isDisabled_nominationFinal, 'prompt' => $prompt]) ?>
                <?php echo $form->field($model, 'nomination_id_final')->widget(Select2::classname(), [
                    'data' => $nominationsList,
                    'bsVersion' => 4,
                    'options' => ['placeholder' => 'Выберите итоговую номинацию...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
        </div>

        <div class="col-lg-6 right-part__half">

            <div class="input-big-title">Участники</div>

            <div class="input">
                <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                    <?= $form->field($model, 'member_number_is_captain')->radio(['label' => '<small class="text-muted">Является капитаном</small>', 'value' => 1]) ?>
                <?php endif; ?>

                <?php //echo $form->field($model, 'member_info_id_1')->dropDownList($membersList, ['prompt' => 'Выберите участника...']) ?>
                <?php echo $form->field($model, 'member_info_id_1')->widget(Select2::classname(), [
                    'data' => $membersList,
                    'value' => $model->member_info_id_1,
                    'bsVersion' => 4,
                    'options' => ['placeholder' => 'Выберите участника...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <hr>

            <div class="input">
                <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                    <?= $form->field($model, 'member_number_is_captain')->radio(['label' => '<small class="text-muted">Является капитаном</small>', 'value' => 2]) ?>
                <?php endif; ?>

                <?php //echo $form->field($model, 'member_info_id_2')->dropDownList($membersList, ['prompt' => 'Выберите участника...']) ?>
                <?php echo $form->field($model, 'member_info_id_2')->widget(Select2::classname(), [
                    'data' => $membersList,
                    'bsVersion' => 4,
                    'options' => ['placeholder' => 'Выберите участника...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <hr>

            <div class="input">
                <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                    <?= $form->field($model, 'member_number_is_captain')->radio(['label' => '<small class="text-muted">Является капитаном</small>', 'value' => 3]) ?>
                <?php endif; ?>

                <?php //echo $form->field($model, 'member_info_id_3')->dropDownList($membersList, ['prompt' => 'Выберите участника...']) ?>
                <?php echo $form->field($model, 'member_info_id_3')->widget(Select2::classname(), [
                    'data' => $membersList,
                    'bsVersion' => 4,
                    'options' => ['placeholder' => 'Выберите участника...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <hr>

            <div class="input">
                <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                    <?= $form->field($model, 'member_number_is_captain')->radio(['label' => '<small class="text-muted">Является капитаном</small>', 'value' => 4]) ?>
                <?php endif; ?>

                <?php //echo $form->field($model, 'member_info_id_4')->dropDownList($membersList, ['prompt' => 'Выберите участника...']) ?>
                <?php echo $form->field($model, 'member_info_id_4')->widget(Select2::classname(), [
                    'data' => $membersList,
                    'bsVersion' => 4,
                    'options' => ['placeholder' => 'Выберите участника...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <hr>

            <div class="input">
                <?php if (in_array($model->scenario, [TeamForm::SCENARIO_MEMBER_MAIN])): ?>
                    <?= $form->field($model, 'member_number_is_captain')->radio(['label' => '<small class="text-muted">Является капитаном</small>', 'value' => 5]) ?>
                <?php endif; ?>

                <?php //echo $form->field($model, 'member_info_id_5')->dropDownList($membersList, ['prompt' => 'Выберите участника...']) ?>
                <?php echo $form->field($model, 'member_info_id_5')->widget(Select2::classname(), [
                    'data' => $membersList,
                    'bsVersion' => 4,
                    'options' => ['placeholder' => 'Выберите участника...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <div class="to-right">
                <?php if (empty($model->name)): ?>
                    <?= Html::submitButton('<span class="plus-button-icon"></span><span>Добавить команду</span>', ['class' => 'members-add-button']) ?>
                <?php else: ?>
                    <?= Html::submitButton('<span>Сохранить команду</span>', ['class' => 'members-add-button']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
