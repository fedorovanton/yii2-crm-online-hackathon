<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 14:22
 */

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \frontend\forms\MemberForm;
use \frontend\models\MemberMain\MemberMain;
use \corpsepk\DaData\SuggestionsWidget;
use \common\models\Nomination\BaseNomination;
use \common\models\MemberGuests\BaseMemberGuests;
use \common\models\MemberManagement\BaseMemberManagement;
use \common\models\Region\BaseRegion;
use \kartik\select2\Select2;
use \yii\widgets\MaskedInput;
use \backend\models\User\User;
use \common\models\MemberJury\BaseMemberJury;
use \frontend\models\MemberInfo\MemberInfo;

/**
 * Вьюха: Заполнение анкеты основого участника
 * @var $model MemberForm
 * @var $this \yii\web\View
 */

$javascript = <<<JS
    $( document ).ready(function() {
        
        var selectName_IsPlansLiveInCity = '#memberform-is_plans_live_in_city';
        
        /**
        * Функция проверки списка Проживает ли в городе Казань 
        * @param val
        */
        function activeAddressLive(val) {
            if (val === 'Да') {
                $('#show-address-live').show();    
            } else {
                $('#show-address-live').hide();
            }
        }
        
        // Был ли изменен список Проживает ли в городе Казань
        $('body').on('change', selectName_IsPlansLiveInCity, function() {
            activeAddressLive($(this).val());
        });
        
        // Был ли изменен чекбокс Нет отчества
        $('body').on('change', '#memberform-missing_second_name', function() {
            var inputName_second_name = '#memberform-second_name';
            
            if ($(this).is(":checked")) {
                // Нажат
                $(inputName_second_name).val(''); // очищаем введенное значение
                $(inputName_second_name).attr('disabled', 'disabled'); // делаем недоступным к изменению
            } else {
                // Не нажат
                $(inputName_second_name).removeAttr('disabled');
            }
        });
        
        // Значение по умолчанию 
        activeAddressLive($(selectName_IsPlansLiveInCity).val());
        
    });
JS;
$this->registerJs($javascript);

$style = <<<CSS
/**
 * Скрыть непонятный квадратик, который появляется под select2
 */
.field-memberform-region_residence a.chosen-single,
.field-memberform-clothing_size a.chosen-single, 
.field-memberform-nomination_id a.chosen-single {
    display: none !important;
}
CSS;
$this->registerCss($style);

/*
 * Дефолтный label для fileInput
 */
switch ($model->scenario) {
    case MemberForm::SCENARIO_MEMBER_MAIN: $docFileLabel = 'Прикрепить резюме (.pdf)'; break;
    case MemberForm::SCENARIO_MEMBERS_UNIVERSITIES: $docFileLabel = 'Прикрепить справку с места обучения (.pdf)'; break;
    case MemberForm::SCENARIO_MEMBERS_PUPILS: $docFileLabel = 'Прикрепить диплом (.pdf)'; break;
}

if (empty($model->check_status)) {
    $model->check_status = MemberInfo::CHECK_STATUS_DRAFT;
}

?>

<div class="members right-part">
    <div class="info-text">
        <span>*</span> - поля, обязательные для заполнения
    </div>
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
        'errorCssClass' => 'input-error'
    ]) ?>
    <?= $form->field($model, 'member_info_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'member_id')->hiddenInput()->label(false) ?>
    <div class="row">
        <div class="col-lg-6 right-part__half">

            <div class="input">
                <?= $form->field($model, 'last_name')->textInput() ?>
            </div>

            <div class="input">
                <?= $form->field($model, 'first_name')->textInput() ?>
            </div>

            <div class="input">
                <?= $form->field($model, 'second_name', ['template' => '
                <div class="input__wrap-m">
                    {label}
                    <label class="checkbox">
                        <input type="hidden" name="MemberForm[missing_second_name]">
                        <input type="checkbox" id="memberform-missing_second_name" name="MemberForm[missing_second_name]">
                        <div class="checkbox__text">Нет отчества</div>
                    </label>
                </div>
                {input}
                {error}
                '])->textInput() ?>
            </div>

            <?php if (!in_array($model->scenario, [
                MemberForm::SCENARIO_GUESTS,
            ])): ?>
                <div class="input">
                    <?php if (!empty($model->phone)) {
                        $model->phone = substr($model->phone, 1);
                    }?>
                    <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                        'name' => 'phone',
                        'mask' => '+7 (999) 999-99-99'
                    ]) ?>
                </div>
            <?php endif; ?>

            <?php if (!in_array($model->scenario, [
                MemberForm::SCENARIO_TECHNICAL_STAFF,
                MemberForm::SCENARIO_GUESTS,
            ])): ?>
                <div class="input">
                    <?php //echo $form->field($model, 'email')->input('email') ?>
                    <?= $form->field($model, 'email')->widget(MaskedInput::className(), [
                        'name' => 'phone',
                        'clientOptions' => [
                            'alias' =>  'email'
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-6 right-part__half">
            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MEMBER_MAIN, MemberForm::SCENARIO_MEMBERS_PUPILS, MemberForm::SCENARIO_MEMBERS_UNIVERSITIES])): ?>
                <div class="input">
                    <?php echo $form->field($model, 'clothing_size')->widget(Select2::classname(), [
                        'data' => MemberMain::getClothingSizeArray(),
                        'bsVersion' => 4,
                        'options' => ['placeholder' => 'Выберите размер одержды...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MEMBER_MAIN, MemberForm::SCENARIO_MEMBERS_PUPILS, MemberForm::SCENARIO_MEMBERS_UNIVERSITIES])): ?>

                <div class="input ">
                    <?php echo $form->field($model, 'region_residence')->widget(Select2::classname(), [
                        'data' => BaseRegion::getRegionsArray(),
                        'bsVersion' => 4,
                        'options' => ['placeholder' => 'Выберите регион проживания...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($model->team_status)): ?>
                <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MEMBER_MAIN, MemberForm::SCENARIO_MEMBERS_PUPILS, MemberForm::SCENARIO_MEMBERS_UNIVERSITIES])): ?>
                    <div class="input">
                        <?= $form->field($model, 'team_status')->dropDownList(MemberMain::getTeamStatusArray(),['prompt' => 'Появится здесь автоматически после распределения в команду', 'disabled' => true]) ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MEMBER_MAIN, MemberForm::SCENARIO_MEMBERS_UNIVERSITIES])): ?>
                <div class="input">
                    <?= $form->field($model, 'is_plans_live_in_city')->dropDownList(MemberMain::getPlansLiveInCityArray(), ['prompt' => 'Выберите значение...']) ?>
                </div>
                <div class="input" id="show-address-live">
                    <?= $form->field($model, 'address_live_in_city')->widget(SuggestionsWidget::class, [
                        'token' => Yii::$app->params['dadata.apiKey'],
                        'type' => SuggestionsWidget::TYPE_ADDRESS,
                    ]) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [
                MemberForm::SCENARIO_PARTNERS,
                MemberForm::SCENARIO_PRESS,
            ])): ?>
                <div class="input">
                    <?= $form->field($model, 'name_organization')->textInput() ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [
                MemberForm::SCENARIO_JURY,
            ])): ?>
                <div class="input">
                    <?php echo $form->field($model, 'nomination_id')->widget(Select2::classname(), [
                        'data' => BaseNomination::getNominationArray(),
                        'bsVersion' => 4,
                        'options' => ['placeholder' => 'Выберите номинацию...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [
                MemberForm::SCENARIO_GUESTS,
                MemberForm::SCENARIO_JURY,
            ])): ?>
                <div class="input">
                    <?= $form->field($model, 'place_work')->widget(SuggestionsWidget::class, [
                        'token' => Yii::$app->params['dadata.apiKey'],
                        'type' => SuggestionsWidget::TYPE_PARTY,
                    ]) ?>
                </div>
                <div class="input">
                    <?= $form->field($model, 'position')->textInput() ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MEMBERS_PUPILS])): ?>
                <div class="input">
                    <?= $form->field($model, 'agent_fio')->textInput() ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MEMBERS_PUPILS])): ?>
                <div class="input">
                    <?= $form->field($model, 'agent_phone')->widget(MaskedInput::className(), [
                        'name' => 'phone',
                        'mask' => '+7 (999) 999-99-99'
                    ]) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_GUESTS])): ?>
                <div class="input">
                    <?= $form->field($model, 'status')->dropDownList(BaseMemberGuests::getStatusArray(), ['prompt' => 'Выберите статус...']) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_JURY])): ?>
                <div class="input">
                    <?= $form->field($model, 'status')->dropDownList(BaseMemberJury::getStatusArray(), ['prompt' => 'Выберите статус...']) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [MemberForm::SCENARIO_MANAGEMENT])): ?>
                <div class="input">
                    <?= $form->field($model, 'status')->dropDownList(BaseMemberManagement::getStatusArray(), ['prompt' => 'Выберите статус...']) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [
                MemberForm::SCENARIO_TECHNICAL_STAFF,
                MemberForm::SCENARIO_SECURITY_SERVICE,
                MemberForm::SCENARIO_PARTNERS,
                MemberForm::SCENARIO_PRESS,
                MemberForm::SCENARIO_MODERATORS,

                MemberForm::SCENARIO_VOLUNTEERS,
            ])): ?>
                <div class="input">
                    <?php
                    /** @var MemberForm $model */
                    $model->status = $model->scenario
                    ?>
                    <?= $form->field($model, 'status')->textInput(['readonly' => true, 'value' => User::getRoleName($model->status)]) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [
                MemberForm::SCENARIO_MEMBER_MAIN,
                MemberForm::SCENARIO_MEMBERS_UNIVERSITIES,
                MemberForm::SCENARIO_MEMBERS_PUPILS
            ])): ?>
                <div class="input">
                    <?php echo $form->field($model, 'check_status')->dropDownList(MemberInfo::getCheckStatusArray()) // todo Тут ошибка на продакшене ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($model->badge_number)): ?>
                <div class="input">
                    <?= $form->field($model, 'badge_number')->textInput(['disabled' => true]) ?>
                </div>
            <?php endif; ?>

            <?php if (in_array($model->scenario, [
                MemberForm::SCENARIO_MEMBER_MAIN,
                MemberForm::SCENARIO_MEMBERS_UNIVERSITIES,
                MemberForm::SCENARIO_MEMBERS_PUPILS
            ])): ?>
                <?php if (!empty($model->errors) && !empty($model->errors['docFile'])) {
                    $text_error = '';
                    foreach ($model->errors['docFile'] as $error) {
                        $text_error .= $error . ',';
                    }
                    echo Html::tag('span', $text_error, ['class' => 'text-danger']);
                } ?>

                <?php echo (!empty($model->doc_file)) ? Html::a('Скачать файл', Yii::getAlias('@backendURL').'/uploads/members-doc-file/'.$model->doc_file) : '' ?>

                <div class="input scan required">
                    <!--<input type="file" name="members-passport-scan1" id="members-passport-scan1" class="upload-scan-input" accept="image/gif, image/jpeg, image/png" />-->

                    <label class="control-label" for="memberform-docfile"><?= $docFileLabel ?></label>
                    <input type="hidden" name="MemberForm[docFile]" value="">
                    <input type="file" id="memberform-docfile" class="upload-scan-input" accept="application/pdf" name="MemberForm[docFile]">
                    <div class="upload-scan upload-button">
                        <span class="weblink-icon"></span><span>Прикрепить файл</span>
                    </div>

                    <div class="upload-scan__row row">
                        <span class="filename"></span>
                        <span class="removefile">Удалить</span>
                    </div>

                    <div class="form-group field-memberform-docfile">
                        <?php //echo $form->field($model, 'docFile')->fileInput(['class' => 'upload-scan-input'])->label(); ?>
                        <div class="help-block"></div>
                    </div>

                </div>
            <?php endif; ?>

            <div class="to-right">
                <?php if (empty($model->last_name)): ?>
                    <?= Html::submitButton('<span class="plus-button-icon"></span><span>Добавить анкету</span>', ['class' => 'members-add-button']) ?>
                <?php else: ?>
                    <?= Html::submitButton('<span>Сохранить анкету</span>', ['class' => 'members-add-button']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
