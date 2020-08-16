<?php
/**
 * Created by PhpStorm.
 * User: antonfedorov
 * Date: 15/09/2019
 * Time: 11:31
 */

use \frontend\forms\MemberMainPublicForm;
use \yii\web\View;
use \yii\widgets\ActiveForm;
use \frontend\models\MemberMain\MemberMain;
use \yii\helpers\Html;
use \corpsepk\DaData\SuggestionsWidget;

/**
 * Вьюха: Публичная анкета
 * @var $model MemberMainPublicForm
 * @var $this \yii\web\View
 */

$this->title = 'Анкета основного участника | ' . Yii::$app->name;

$javascript = <<<JS
    $( document ).ready(function() {
        
        var selectName_IsPlansLiveInCity = '#membermainpublicform-is_plans_live_in_city';
        
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
        $('body').on('change', '#membermainpublicform-missing_second_name', function() {
            var inputName_second_name = '#membermainpublicform-second_name';
            
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

?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

        <div class="input">
            <?= $form->field($model, 'last_name')->textInput(['disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'first_name')->textInput(['disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'second_name')->textInput(['disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'phone')->input('tel',['disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'email')->input('email',['disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'clothing_size')->dropDownList(MemberMain::getClothingSizeArray(), ['prompt' => 'Выберите размер одежды...', 'disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'region_residence')->textInput(['disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'team_status')->dropDownList(MemberMain::getTeamStatusArray(), ['prompt' => 'Выберите статус в команде', 'disabled' => true]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'is_plans_live_in_city')->dropDownList(MemberMain::getPlansLiveInCityArray(), ['prompt' => 'Выберите значение...']) ?>
        </div>
        <div class="input" id="show-address-live">
            <?= $form->field($model, 'address_live_in_city')->widget(SuggestionsWidget::class, [
                'token' => Yii::$app->params['dadata.apiKey'],
                'type' => SuggestionsWidget::TYPE_ADDRESS,
            ]) ?>
        </div>
        <div class="input">
            <?= $form->field($model, 'accept')->checkbox(['label' => 'Я согласен(-а) на обработку данных']) ?>
        </div>

        <?= (empty($model->doc_file)) ? '<small class="text-muted">Загрузите документ.</small>' : Html::a('Скачать файл', Yii::getAlias('@backendURL').'/uploads/members-doc-file/'.$model->doc_file) ?>
        <div class="input scan required">
            <!--<input type="file" name="members-passport-scan1" id="members-passport-scan1" class="upload-scan-input" accept="image/gif, image/jpeg, image/png" />-->

            <label class="control-label" for="membermainpublicform-docfile">Резюме</label>
            <input type="hidden" name="MemberMainPublicForm[docFile]" value="">
            <input type="file" id="membermainpublicform-docfile" class="upload-scan-input" name="MemberMainPublicForm[docFile]">
            <div class="upload-scan upload-button">
                <span class="weblink-icon"></span><span>Прикрепить файл</span>
            </div>

            <div class="upload-scan__row row">
                <span class="filename"></span>
                <span class="removefile">Удалить</span>
            </div>

            <div class="form-group field-membermainpublicform-docfile">
                <?php //echo $form->field($model, 'docFile')->fileInput(['class' => 'upload-scan-input'])->label(); ?>
                <div class="help-block"></div>
            </div>

        </div>

        <div class="to-right">
            <?= Html::submitButton('<span class="plus-button-icon"></span><span>Добавить анкету</span>', ['class' => 'members-add-button']) ?>
        </div>

        <?php echo $this->render('_partial-tech-info') ?>

        <?php ActiveForm::end() ?>
    </div>
</div>
